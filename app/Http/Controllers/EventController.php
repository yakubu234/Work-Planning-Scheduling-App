<?php

namespace App\Http\Controllers;

use App\Actions\Events\AllEventsAction;
use App\Actions\Events\CreateEventAction;
use App\Actions\Events\CreateTicketAction;
use App\Actions\Events\DeleteEventAction;
use App\Actions\Events\MyEventsAction;
use App\Actions\Events\UpdateEventAction;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\EventIdOnlyRequest;
use App\Http\Requests\UserIdOnlyRequest;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function create(CreateEventRequest $request)
    {
        return (new CreateEventAction())->execute($request->validated());
    }

    public function update(EventIdOnlyRequest $request)
    {
        return (new UpdateEventAction())->execute($request->all());
    }

    public function delete(EventIdOnlyRequest $request)
    {
        return (new DeleteEventAction())->execute($request->all());
    }

    public function myEvent()
    {
        return (new MyEventsAction())->events();
    }

    public function all()
    {
        return (new AllEventsAction())->events();
    }

    public function createTicket(CreateTicketRequest $request)
    {
        return (new CreateTicketAction())->execute($request->validated());
    }
}
