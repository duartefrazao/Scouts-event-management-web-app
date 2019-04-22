<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Event;
use App\Location;

class EventController extends Controller
{

    /**
     * Shows the event for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $event = Event::find($id);

        $this->authorize('show', $event);

        return view('pages.event', ['event' => $event]);
    }

    /**
     * Shows all events.
     *
     * @return Response
     */
    public function list()
    {
        if (!Auth::check()) return redirect('/login');

        //TODO IS THIS NEEDED?
        //$this->authorize('list', Event::class);

        $events_part = Auth::user()->participant()->orderBy('id')->get();


        $events_org = Auth::user()->organizer()->orderBy('id')->get();

        $events = $events_part->merge($events_org);

        
        foreach ($events as $event){
            $event['loc_name'] =  DB::table('location')->where('id', $event->location)->pluck('name')[0];
            $event['groups'] = DB::table('event_group')->join('group', 'group.id', '=', 'event_group.group')->where('event', $event->id)->pluck('group.name');
        }
            
        return view('pages.events', ['events' => $events]);
    }

    /**
     * Creates a new item.
     *
     * @param  int  $event_id
     * @param  Request request containing the description
     * @return Response
     */
    public function create(Request $request)
    {
        $event = new Event();

        $this->authorize('create', $event);

        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->price = $request->input('price');
        $event->start_date = $request->input('start_date');
        $event->final_date = $request->input('final_date');
        $event->location = $request->input('location');

        return $event;
    }

    /**
     * Updates the state of an individual event.
     *
     * @param  int  $id
     * @param  Request request containing the new state
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        $this->authorize('update', $event);

        $event->final_date = $request->input('final_date');
        $event->save();

        return $event;
    }

    /**
     * Deletes an individual event.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $event = event::find($id);

        $this->authorize('delete', $event);
        $event->delete();

        return $event;
    }

}
