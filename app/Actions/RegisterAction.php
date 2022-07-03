<?php

namespace App\Actions;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;

class RegisterAction
{
    use ResponseTrait;

    protected $data;

    public function execute(array $data)
    {
        $this->data = $data;
        return $this->createUser();
    }

    private function createUser()
    {
        $user = User::create([
            'uid' => Str::orderedUuid(),
            'first_name' => $this->data['first_name'],
            'last_name' => $this->data['last_name'],
            'email' => $this->data['email'],
            'password' => bcrypt($this->data['password']),
        ]);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken,
            'user_details' => $user
        ], 'User created successfully', 201);
    }
}
