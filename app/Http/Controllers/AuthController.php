<?php

namespace App\Http\Controllers;

use App\Actions\LoginAction;
use App\Actions\RegisterAction;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        return (new RegisterAction())->execute($request->validated());
    }

    public function signin(LoginRequest $request)
    {
        return (new LoginAction())->login($request->validated());
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
