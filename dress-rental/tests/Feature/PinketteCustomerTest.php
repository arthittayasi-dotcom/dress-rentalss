<?php

namespace Tests\Feature;

use App\Models\Dress;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PinketteCustomerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // The imported database has role; the original project migrations omit it.
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', fn (Blueprint $table) => $table->string('role')->default('customer'));
        }
        Storage::fake('local');
        Http::preventStrayRequests();
        config(['pinkette.slip_api_key' => 'test', 'pinkette.account_number' => '1234567890']);
    }

    private function rental(?User $user = null, string $status = 'pending'): Rental
    {
        $user ??= User::factory()->create(['role' => 'customer']);
        $dress = Dress::create(['code' => 'DR'.(Dress::count() + 1), 'name' => 'Pink dress', 'price_per_day' => 100, 'status' => 'available']);

        return Rental::create(['user_id' => $user->id, 'dress_id' => $dress->id, 'start_date' => today(), 'end_date' => today()->addDays(2), 'rental_days' => 2, 'price_per_day' => 100, 'total_price' => 200, 'status' => $status]);
    }

    private function providerResponse(array $overrides = []): array
    {
        return ['success' => true, 'data' => array_replace_recursive([
            'isDuplicate' => false, 'matchedAccount' => ['bankNumber' => '123-456-7890'],
            'rawSlip' => ['transRef' => 'REF-123', 'date' => now()->toIso8601String(), 'amount' => ['amount' => 200]],
        ], $overrides)];
    }

    public function test_catalog_availability_depends_on_selected_dates(): void
    {
        $rental = $this->rental(status: 'renting');
        $rental->dress->update(['status' => 'rented']);
        $this->actingAs($rental->user)->get(route('customer.home'))->assertOk()
            ->assertSee('เลือกวันที่เพื่อเช็กวันว่าง')->assertDontSee('ว่างในวันที่เลือก');
        $overlap = ['start_date' => today()->toDateString(), 'end_date' => today()->addDay()->toDateString()];
        $this->get(route('customer.home', $overlap))->assertOk()->assertSee('ไม่ว่างในวันที่เลือก');
        $this->get(route('customer.home', ['start_date' => today()->addDays(3)->toDateString(), 'end_date' => today()->addDays(4)->toDateString()]))->assertOk()->assertSee('ว่างในวันที่เลือก')->assertDontSee('ไม่ว่างในวันที่เลือก');
        $this->get(route('customer.home', ['start_date' => $rental->end_date->toDateString(), 'end_date' => $rental->end_date->toDateString()]))->assertOk()->assertSee('ไม่ว่างในวันที่เลือก');
        $rental->update(['status' => 'cancelled']);
        $this->get(route('customer.home', $overlap))->assertOk()->assertSee('ว่างในวันที่เลือก')->assertDontSee('ไม่ว่างในวันที่เลือก');
        $this->get(route('customer.home', ['start_date' => today()->toDateString()]))->assertSessionHasErrors('end_date');
        $this->get(route('customer.home', ['start_date' => today()->addDays(3)->toDateString(), 'end_date' => today()->toDateString()]))->assertSessionHasErrors('end_date');
    }

    public function test_other_customer_cannot_access_payment_or_slip(): void
    {
        $rental = $this->rental();
        $this->actingAs(User::factory()->create(['role' => 'customer']))->get(route('customer.payment', $rental))->assertForbidden();
        $this->get(route('customer.payment.slip', $rental))->assertForbidden();
        $this->post(route('customer.payment.store', $rental), ['slip' => UploadedFile::fake()->image('slip.jpg', random_int(10, 200), 10)])->assertForbidden();
    }

    public function test_valid_slip_verifies_payment_and_is_private(): void
    {
        $rental = $this->rental();
        Http::fake(['api.easyslip.com/*' => Http::response($this->providerResponse())]);
        $this->actingAs($rental->user)->post(route('customer.payment.store', $rental), ['slip' => UploadedFile::fake()->image('slip.jpg', random_int(10, 200), 10)])->assertSessionHasNoErrors();
        $rental->refresh();
        $this->assertSame('verified', $rental->payment_status);
        $this->assertSame('REF-123', $rental->payment_reference);
        Storage::disk('local')->assertExists($rental->slip_path);
        $this->get(route('customer.payment.slip', $rental))->assertOk();
        $this->post(route('customer.payment.store', $rental), ['slip' => UploadedFile::fake()->image('new.jpg')])->assertSessionHasErrors('slip');
    }

    public function test_wrong_amount_wrong_receiver_duplicate_and_old_slips_are_rejected(): void
    {
        foreach ([['rawSlip' => ['amount' => ['amount' => 1]]], ['matchedAccount' => ['bankNumber' => '999999']], ['isDuplicate' => true], ['rawSlip' => ['date' => now()->subYear()->toIso8601String()]]] as $override) {
            Http::swap(new Factory);
            Http::preventStrayRequests();
            $rental = $this->rental();
            Http::fake(['api.easyslip.com/*' => Http::response($this->providerResponse($override))]);
            $this->actingAs($rental->user)->post(route('customer.payment.store', $rental), ['slip' => UploadedFile::fake()->image('slip.jpg', random_int(10, 200), 10)])->assertSessionHasNoErrors();
            $this->assertSame('rejected', $rental->fresh()->payment_status);
        }
    }

    public function test_no_api_key_and_provider_outage_leave_payment_pending(): void
    {
        $rental = $this->rental();
        config(['pinkette.slip_api_key' => null]);
        $this->actingAs($rental->user)->post(route('customer.payment.store', $rental), ['slip' => UploadedFile::fake()->image('slip.jpg', random_int(10, 200), 10)]);
        $this->assertSame('pending', $rental->fresh()->payment_status);
        Http::assertNothingSent();
        config(['pinkette.slip_api_key' => 'test']);
        Http::fake(['api.easyslip.com/*' => Http::response([], 503)]);
        $this->post(route('customer.payment.store', $rental), ['slip' => UploadedFile::fake()->image('other.jpg')]);
        $this->assertSame('pending', $rental->fresh()->payment_status);
    }

    public function test_duplicate_reference_cannot_pay_another_rental(): void
    {
        $first = $this->rental();
        $first->update(['payment_reference' => 'REF-123', 'payment_status' => 'verified']);
        $next = $this->rental();
        Http::fake(['api.easyslip.com/*' => Http::response($this->providerResponse())]);
        $this->actingAs($next->user)->post(route('customer.payment.store', $next), ['slip' => UploadedFile::fake()->image('slip.jpg', random_int(10, 200), 10)]);
        $this->assertSame('rejected', $next->fresh()->payment_status);
    }

    public function test_non_image_and_cancelled_rental_are_rejected(): void
    {
        $rental = $this->rental(status: 'cancelled');
        $this->actingAs($rental->user)->post(route('customer.payment.store', $rental), ['slip' => UploadedFile::fake()->create('slip.pdf')])->assertSessionHasErrors('slip');
        $this->post(route('customer.payment.store', $rental), ['slip' => UploadedFile::fake()->image('slip.jpg', random_int(10, 200), 10)])->assertSessionHasErrors('slip');
        Http::assertNothingSent();
    }

    public function test_booking_conflict_and_same_day_minimum_price(): void
    {
        $rental = $this->rental();
        $this->actingAs($rental->user)->post(route('customer.rentals.store'), ['dress_id' => $rental->dress_id, 'start_date' => today()->toDateString(), 'end_date' => today()->addDay()->toDateString()])->assertSessionHas('error');
        $date = today()->addDays(4)->toDateString();
        $this->post(route('customer.rentals.store'), ['dress_id' => $rental->dress_id, 'start_date' => $date, 'end_date' => $date])->assertSessionHas('success');
        $this->assertDatabaseHas('rentals', ['start_date' => $date.' 00:00:00', 'rental_days' => 1, 'total_price' => 100]);
    }

    public function test_admin_can_view_and_review_pending_slip(): void
    {
        $rental = $this->rental();
        Storage::disk('local')->put('payment-slips/test.jpg', 'test');
        $rental->update(['slip_path' => 'payment-slips/test.jpg', 'payment_status' => 'pending']);
        $this->actingAs(User::factory()->create(['role' => 'admin']))->get(route('admin.rentals'))->assertOk()->assertSee('ดูสลิปชำระเงิน');
        $this->get(route('admin.payment.slip', $rental))->assertOk();
        $this->post(route('admin.payment.review', $rental), ['decision' => 'verified', 'note' => 'ตรวจเงินเข้าบัญชีแล้ว'])->assertSessionHas('success');
        $this->assertSame('verified', $rental->fresh()->payment_status);
    }
}
