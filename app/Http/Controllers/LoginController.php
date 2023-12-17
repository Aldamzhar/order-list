<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(Request $request)
    {
        return $this->loginService->login($request);
    }




}
