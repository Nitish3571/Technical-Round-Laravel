<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index(){
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }
        return view('pages/authentications/login/login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            toastr()->success("Login successful");
            return redirect()->intended('/dashboard');
        } else {
            toastr()->error("Credentials are incorrect. Please try again.");
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        toastr()->success('Logout Successfully');
        return redirect('/');
    }
}
