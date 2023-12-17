<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return response()->json([
                'is_admin' => $user->is_admin,
                'redirect' => url('/api/orders-show')
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['Введены неверные данные'],
        ]);
    }
}
