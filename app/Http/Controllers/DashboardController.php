<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class DashboardController extends Controller
{
    public function index(){
        $users = Admin::take(10)->get();
        // dd($users);
        return view('pages/dashboard/dashboard' , compact('users'));
    }
}
