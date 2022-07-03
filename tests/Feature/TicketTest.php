<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class TicketTest extends TestCase
{
    private $user;
    private $event;
    private $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->token = $this->login();

        $eventdata =  [
            'uid' => Str::orderedUuid(),
            'user_id' => (string)$this->user->uid,
            'event_name' => fake()->name(),
            'location' => fake()->address(),
            'event_date' => fake()->date(),
            'type' => 'free'
        ];

        $this->event = $this->post('/api/event/create', $eventdata, ['Authorization' => 'Bearer ' . $this->token]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateTicket()
    {

        $data =  [
            'uid' => Str::orderedUuid(),
            'event_id' => $this->event['data']['event']['id'],
            'amount' => 50000,
            'type' => 'gold'
        ];

        $response = $this->post('/api/event/create-ticket', $data, ['Authorization' => 'Bearer ' . $this->token]);
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
