<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function toLogin(){
        return view('Auth.login');
    }
    public function login(Request $req){
         $key = 'login-'.$req->ip();
    if (RateLimiter::tooManyAttempts($key, 5)) {
        $seconds = RateLimiter::availableIn($key);
         return back();
    }

    RateLimiter::hit($key, 60);
        $req->validate([
            "email" => "required|email",
            "password" => "required"
        ], [
            "email.required" => "L'email est obligatoire",
            "email.email" => "Le format de l'email est invalide",
            "password.required" => "Le mot de passe est obligatoire"
        ]);
        $data = $req->only("email","password");
        if(Auth::attempt($data)){
            session()->regenerate();
            return to_route('acc');
        }
        return back()
                ->withErrors(['msg'=>'Email ou mot de passe invalide'])
                ->onlyInput('email');
    }
    public function logout(Request $req)
    {
        Auth::logout();

        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return to_route('login.form');
    }
}
