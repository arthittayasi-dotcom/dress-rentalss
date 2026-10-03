<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StaffLoginController extends Controller
{

    public function create(): View
    {
        return view('auth.staff-login');
    }





    public function store(Request $request): RedirectResponse
    {

        $request->validate([

            'username' => [
                'required',
                'string'
            ],

            'password' => [
                'required',
                'string'
            ],

            'role' => [
                'required',
                'in:owner,admin'
            ],

        ]);





        if (Auth::check()) {

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

        }






        $credentials = [

            'username' => $request->username,

            'password' => $request->password,

            'role' => $request->role,

        ];






        if (! Auth::attempt($credentials)) {


            throw ValidationException::withMessages([

                'username' => 'ชื่อผู้ใช้ รหัสผ่าน หรือประเภทบัญชีไม่ถูกต้อง',

            ]);


        }






        $request->session()->regenerate();







        if (Auth::user()->role === 'admin') {


            return redirect()

                ->route('admin.dashboard');


        }







        return redirect()

            ->route('owner.dashboard');


    }







    public function destroy(Request $request): RedirectResponse
    {


        Auth::logout();




        $request->session()->invalidate();




        $request->session()->regenerateToken();






        return redirect()

            ->route('staff.login')

            ->withHeaders([


                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',

                'Pragma' => 'no-cache',

                'Expires' => '0',


            ]);


    }


}