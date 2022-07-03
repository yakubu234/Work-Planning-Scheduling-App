<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $data =  [
            'uid' => Str::orderedUuid(),
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            "password" => "T!xXAfrica22",
            "password_confirmation" => "T!xXAfrica22"
        ];

        $response = $this->post('/api/register', $data);
        $response->assertStatus(201);
    }
}
