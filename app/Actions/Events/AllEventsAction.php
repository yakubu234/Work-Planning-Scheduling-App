<?php

namespace App\Actions\Events;

use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;

class AllEventsAction
{
    use ResponseTrait;

    public function events()
    {
        $event = Event::orderBy('id', 'desc')->paginate(50);
        $events = EventResource::collection(
            $event
        );

        return $this->success(['events' => $events], 'Event fetched successfully');
    }
}
