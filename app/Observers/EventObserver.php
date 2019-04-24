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
        while(1){
            $checker = str_random(5);
            if(!Event::where('event_url',$checker)->first()){
                $event->event_url = $checker;
                break;
            }
        }   
    }
}