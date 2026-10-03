<?php

use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DressController;
use App\Http\Controllers\Admin\HistoryController as AdminHistoryController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\RentalController as CustomerRentalController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\HistoryController as OwnerHistoryController;
use App\Http\Controllers\Owner\PdfReportController;
use App\Http\Controllers\Owner\ReportController;
use App\Http\Controllers\Owner\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\Dress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// ลูกค้า
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        // หน้าหลัก: ตารางตรวจสอบสถานะชุด
        Route::get('/home', function (Request $request) {
            $request->validate([
                'start_date' => [
                    'nullable',
                    'required_with:end_date',
                    'date_format:Y-m-d',
                    'after_or_equal:today',
                ],
                'end_date' => [
                    'nullable',
                    'required_with:start_date',
                    'date_format:Y-m-d',
                    'after_or_equal:start_date',
                ],
            ]);

            $dresses = Dress::with('unavailableRentals')
                ->orderBy('code')
                ->paginate(10)
                ->withQueryString();

            return view('customers.home', compact('dresses'));
        })->name('home');

        // หน้าเลือกชุด: รูปชุดและฟอร์มเช่า
        Route::get('/dresses', function () {
            $dresses = Dress::orderBy('code')->paginate(8);

            return view('customers.dresses', compact('dresses'));
        })->name('dresses');

        // เกี่ยวกับร้าน
        Route::view('/about', 'customers.about')->name('about');

        // การเช่าของฉัน
        Route::get('/rentals', [
            CustomerRentalController::class,
            'index',
        ])->name('rentals');

        Route::post('/rentals', [
            CustomerRentalController::class,
            'store',
        ])->name('rentals.store');

        // หน้าชำระเงิน
        Route::get('/rentals/{rental}/payment', [
            PaymentController::class,
            'show',
        ])->name('payment');

        // อัปโหลดสลิป
        Route::post('/rentals/{rental}/payment', [
            PaymentController::class,
            'store',
        ])->middleware('throttle:6,1')->name('payment.store');

        // ดูสลิป
        Route::get('/rentals/{rental}/slip', [
            PaymentController::class,
            'slip',
        ])->name('payment.slip');
    });

// เจ้าของร้าน
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', [
            OwnerDashboardController::class,
            'index',
        ])->name('dashboard');

        Route::get('/reports', [
            ReportController::class,
            'index',
        ])->name('reports');

        Route::get('/reports/pdf', [
            PdfReportController::class,
            'export',
        ])->name('reports.pdf');

        Route::get('/history', [
            OwnerHistoryController::class,
            'index',
        ])->name('history');

        Route::get('/users', [
            UserController::class,
            'index',
        ])->name('users');

        Route::post('/users', [
            UserController::class,
            'store',
        ])->name('users.store');

        Route::put('/users/{user}', [
            UserController::class,
            'update',
        ])->name('users.update');

        Route::delete('/users/{user}', [
            UserController::class,
            'destroy',
        ])->name('users.destroy');
    });

// แอดมิน
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [
            DashboardController::class,
            'index',
        ])->name('dashboard');

        Route::get('/calendar', [
            CalendarController::class,
            'index',
        ])->name('calendar');

        // รายการเช่า
        Route::get('/rentals', [
            AdminRentalController::class,
            'index',
        ])->name('rentals');

        Route::post('/rentals/{rental}/approve', [
            AdminRentalController::class,
            'approve',
        ])->name('rentals.approve');

        Route::post('/rentals/{rental}/reject', [
            AdminRentalController::class,
            'reject',
        ])->name('rentals.reject');

        Route::post('/rentals/{rental}/start', [
            AdminRentalController::class,
            'startRental',
        ])->name('rentals.start');

        Route::post('/rentals/{rental}/return', [
            AdminRentalController::class,
            'returnDress',
        ])->name('rentals.return');

        Route::post('/rentals/{rental}/cancel', [
            AdminRentalController::class,
            'cancel',
        ])->name('rentals.cancel');

        // ตรวจสอบการชำระเงิน
        Route::get('/rentals/{rental}/slip', [
            PaymentController::class,
            'slip',
        ])->name('payment.slip');

        Route::post('/rentals/{rental}/payment-review', [
            PaymentController::class,
            'review',
        ])->name('payment.review');

        // จัดการชุด
        Route::get('/dresses', [
            DressController::class,
            'index',
        ])->name('dresses');

        Route::post('/dresses', [
            DressController::class,
            'store',
        ])->name('dresses.store');

        Route::put('/dresses/{dress}', [
            DressController::class,
            'update',
        ])->name('dresses.update');

        Route::delete('/dresses/{dress}', [
            DressController::class,
            'destroy',
        ])->name('dresses.destroy');

        // ตรวจสอบคืนชุด
        Route::get('/returns', [
            ReturnController::class,
            'index',
        ])->name('returns');

        // ประวัติ
        Route::get('/history', [
            AdminHistoryController::class,
            'index',
        ])->name('history');
    });

// โปรไฟล์
Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit',
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update',
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy',
    ])->name('profile.destroy');
});

// เข้าสู่ระบบ สมัครสมาชิก และออกจากระบบ
require __DIR__.'/auth.php';