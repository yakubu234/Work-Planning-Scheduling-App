<?php

namespace App\Actions;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
    use ResponseTrait;

    public function login(array $data)
    {
        if (!Auth::attempt($data)) {
            return $this->error('Credentials do not match our records', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
            'user' => auth()->user()
        ], 'login successful');
    }
}
