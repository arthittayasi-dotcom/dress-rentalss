<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| เข้าสู่ระบบร่วมกันทุกประเภทบัญชี
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // สมัครสมาชิกลูกค้า
    Route::get('/register', [
        RegisteredUserController::class,
        'create',
    ])->name('register');

    Route::post('/register', [
        RegisteredUserController::class,
        'store',
    ]);

    // หน้าเข้าสู่ระบบเดียวสำหรับ Customer / Admin / Owner
    Route::get('/login', [
        AuthenticatedSessionController::class,
        'create',
    ])->name('login');

    Route::post('/login', [
        AuthenticatedSessionController::class,
        'store',
    ]);

    // ลิงก์ Staff เดิม พากลับมาหน้า Login เดียวกัน
    Route::get('/stafflogin', function () {
        return redirect()->route('login');
    })->name('staff.login');

    // รองรับฟอร์ม Staff เดิม โดยใช้การตรวจบัญชีเดียวกัน
    Route::post('/stafflogin', [
        AuthenticatedSessionController::class,
        'store',
    ])->name('staff.login.store');
});

/*
|--------------------------------------------------------------------------
| ออกจากระบบ
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [
        AuthenticatedSessionController::class,
        'destroy',
    ])->name('logout');

    // รองรับปุ่มออกจากระบบของ Staff ใน Navbar เดิม
    Route::post('/staff/logout', [
        AuthenticatedSessionController::class,
        'destroy',
    ])->name('staff.logout');
});