<?php

namespace App\Actions\Events;

use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;

class DeleteEventAction
{
    use ResponseTrait;

    public function execute(array $data)
    {
        $event = Event::where('uid', $data['event_id'])->first();
        if (!$event) {
            return $this->error('An event with this id was not found', 400);
        }

        $event->delete();

        return $this->success(null, 'Event deleted successfully');
    }
}
