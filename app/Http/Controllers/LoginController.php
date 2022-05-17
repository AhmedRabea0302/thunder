<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('pages.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->route('home');
        } else {
            return redirect()->back();
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
