<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = md5($request->password); 

        $user = User::where('email', $email)
                    ->where('password', $password)
                    ->first();

        if ($user) {
            Session::put('user_id', $user->id);
            Session::put('role', $user->role);
            Session::put('name', $user->name);

            if ($user->role === 'gudang') {
                return redirect('/gudang');
            } else {
                return redirect('/dapur');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
    
}
