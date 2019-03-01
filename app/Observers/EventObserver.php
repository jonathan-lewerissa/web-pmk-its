<?php

namespace App\Observers;

use App\Models\Event;

class EventObserver
{
    /**
     * Listen to the Event creating event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function creating(Event $event)
    {
        $event->event_url = str_random(40);
    }
}