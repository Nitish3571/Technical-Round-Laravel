<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    public function index(){
        return view('pages/authentications/register/register');
    }

    public function store(Request $request){
        // dd($request);
        try{
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|min:5|confirmed',
            ]);
        $token = Str::random(20);
        Admin::create(
                [
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
                    'remember_token' => $token,
                    ]
                );
        toastr()->success('Register Successfully');
        return redirect('/login');
        }catch( \Exception $e ){
            // dd($e);
            toastr()->error('Register failed Successfully');
            return redirect()->back();
        }
    }
}
