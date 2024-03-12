<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Inertia\Inertia;
use Inertia\Response;

class EventsController extends Controller
{
    /**
     * @param Event $event
     * @return Response
     */
    public function show(Event $event)
    {
        return Inertia::render('Events/Show', [
            'event' => $event->only(
                'id',
                'title',
                'start_date',
                'description'
            ),
        ]);
    }
}
