<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class EventTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateEvent()
    {
        // dd($this->user->uid);
        $token = $this->login();

        $data =  [
            'uid' => Str::orderedUuid(),
            'user_id' => (string)$this->user->uid,
            'event_name' => fake()->name(),
            'location' => fake()->address(),
            'event_date' => fake()->date(),
            'type' => 'free'
        ];

        $response = $this->post('/api/event/create', $data, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }

    private function login()
    {
        $loginDetails = [
            'email' => $this->user->email,
            "password" => 'password'
        ];

        $login = $this->post('/api/signin', $loginDetails);
        return $login['data']['token'];
    }
}
