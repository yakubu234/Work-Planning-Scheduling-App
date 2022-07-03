<?php

namespace App\Actions\Events;

use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;

class CreateEventAction
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
        $user = User::findByUid($this->data['user_id']);
        $event = Event::create([
            'uid' => Str::orderedUuid(),
            'user_id' => $user->id,
            'event_name' => $this->data['event_name'],
            'location' => $this->data['location'],
            'event_date' => $this->data['event_date'],
            'type' => $this->data['type'],
        ]);

        return $this->success(['event' => new EventResource($event)], 'Event added successfully');
    }
}
