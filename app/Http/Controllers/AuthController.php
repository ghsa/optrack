<?php

namespace App\Http\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.signin');
    }

    public function signIn()
    {
        request()->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (\Auth::attempt(
            [
                'email' => request()->email,
                'password' => request()->password
            ]
        )) {
            return redirect()->route('dashboard.home');
        }

        return back()->withErrors("Email and password don't match");
    }

    public function signOut()
    {
        \Auth::logout();
        return back();
    }

    public function firstUser()
    {
        if (User::count()) {
            return 'error';
        }

        \DB::beginTransaction();
        try {
            $user = User::create([
                'name' => "Gustavo Andrade",
                'email' => "contato@gustavoandrade.net",
                'password' => bcrypt('123456')
            ]);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return $e->getMessage();
        }
    }
}
