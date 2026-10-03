<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Services\SlipVerifier;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PaymentController extends Controller
{
    public function show(Request $request, Rental $rental): View
    {
        abort_unless($rental->user_id === $request->user()->id, 403);

        return view('customers.payment', ['rental' => $rental->load('dress')]);
    }

    public function store(Request $request, Rental $rental, SlipVerifier $verifier): RedirectResponse
    {
        abort_unless($rental->user_id === $request->user()->id, 403);
        $request->validate(['slip' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096']]);
        $file = $request->file('slip');
        $hash = hash_file('sha256', $file->getRealPath());
        $path = null;
        $oldPath = null;
        try {
            DB::transaction(function () use ($rental, $file, $hash, $verifier, &$path, &$oldPath) {
                $locked = Rental::whereKey($rental->id)->lockForUpdate()->firstOrFail();
                if (! in_array($locked->status, ['pending', 'approved', 'renting']) || $locked->payment_status === 'verified' || (float) $locked->total_price <= 0) {
                    throw ValidationException::withMessages(['slip' => 'รายการนี้ไม่สามารถรับสลิปเพิ่มเติมได้ กรุณาติดต่อร้าน']);
                }
                if (Rental::where('slip_hash', $hash)->where('id', '!=', $locked->id)->exists()) {
                    throw ValidationException::withMessages(['slip' => 'รูปสลิปนี้ถูกใช้กับรายการอื่นแล้ว']);
                }
                $path = $file->store('payment-slips', 'local');
                $result = $verifier->verify(Storage::disk('local')->path($path), $locked);
                $oldPath = $locked->slip_path;
                $locked->update(array_merge(['slip_path' => $path, 'slip_hash' => $hash, 'payment_reference' => null, 'paid_at' => null], $result));
            });
        } catch (UniqueConstraintViolationException $exception) {
            if ($path) {
                Storage::disk('local')->delete($path);
            }
            throw ValidationException::withMessages(['slip' => 'สลิปนี้ถูกใช้กับรายการอื่นแล้ว']);
        } catch (\Throwable $exception) {
            if ($path) {
                Storage::disk('local')->delete($path);
            }
            throw $exception;
        }
        if ($oldPath && $oldPath !== $path) {
            Storage::disk('local')->delete($oldPath);
        }

        return to_route('customer.payment', $rental)->with('success', 'ส่งสลิปเรียบร้อยแล้ว กรุณาดูผลตรวจสอบด้านล่าง');
    }

    public function slip(Request $request, Rental $rental): BinaryFileResponse
    {
        abort_unless($request->user()->role === 'admin' || $rental->user_id === $request->user()->id, 403);
        abort_unless($rental->slip_path && Storage::disk('local')->exists($rental->slip_path), 404);

        return response()->file(Storage::disk('local')->path($rental->slip_path), ['Cache-Control' => 'private, no-store', 'X-Content-Type-Options' => 'nosniff']);
    }

    public function review(Request $request, Rental $rental): RedirectResponse
    {
        abort_unless($request->user()->role === 'admin', 403);
        $data = $request->validate(['decision' => ['required', 'in:verified,rejected'], 'note' => ['required', 'string', 'max:200']]);
        DB::transaction(function () use ($rental, $data) {
            $locked = Rental::whereKey($rental->id)->lockForUpdate()->firstOrFail();
            abort_unless($locked->slip_path && in_array($locked->status, ['pending', 'approved', 'renting']) && $locked->payment_status !== 'verified', 422);
            $locked->update(['payment_status' => $data['decision'], 'payment_message' => 'แอดมินตรวจสอบ: '.$data['note'], 'paid_at' => $data['decision'] === 'verified' ? now() : null]);
        });

        return back()->with('success', 'บันทึกผลตรวจสอบการชำระเงินแล้ว');
    }
}
