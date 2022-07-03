<?php

namespace App\Actions\Events;

use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;

class UpdateEventAction
{
    use ResponseTrait;

    public function execute(array $data)
    {
        $event = Event::where('uid', $data['event_id'])->first();
        if (!$event) {
            return $this->error('An event with this id was not found', 400);
        }

        $event->update($data);

        return $this->success(['event' => new EventResource($event)], 'Event updated successfully');
    }
}
