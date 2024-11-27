<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;

class EventViewEmbeddedController extends Controller
{

    /**
     * Show an embedded version of the event page
     *
     * @param $event_id
     * @return mixed
     */
    public function showEmbeddedEvent($event_id)
    {
        $event = Event::findOrFail($event_id);

        $data = [
            'event' => $event,
            'tickets' => $event->tickets()->where('is_hidden', 0)
//                ->where('start_sale_date','<',Carbon::now())
//                ->where('end_sale_data','>',Carbon::now())
                ->orderBy('sort_order', 'asc')->get(),
            'is_embedded' => '1',
        ];

        return view('Public.ViewEvent.Embedded.EventPage', $data);
    }
}
