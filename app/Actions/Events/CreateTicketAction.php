<?php

namespace App\Actions\Events;

use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;

class CreateTicketAction
{
    use ResponseTrait;

    protected $data;

    public function execute(array $data)
    {
        $this->data = $data;
        return $this->create();
    }

    private function create()
    {
        $event = Event::findByUid($this->data['event_id']);
        $ticket = Ticket::create([
            'uid' => Str::orderedUuid(),
            'event_id' => $event->id,
            'amount' => $this->data['amount'],
            'type' => $this->data['type']
        ]);

        return $this->success(['ticket' => $ticket], 'Ticket created successfully');
    }
}
