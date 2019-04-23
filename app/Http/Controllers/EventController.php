<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Event;
use App\Location;
use App\Group;
use App\File;
use App\Poll;
use App\EventOrganizer;
use App\Comment;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Shows the event for a given id.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $event = Event::find($id);

        $this->authorize('show', $event);

        $this->getEventKeyInfo($event);

        return view('pages.event', ['event' => $event]);
    }

    public function getEventKeyInfo($event)
    {
        $event['loc_name'] = Location::find($event->location)->name;

        //TODO CHANGE THIS
        $event['groups'] = DB::table('event_group')->join('group', 'group.id', '=', 'event_group.group')->where('event', $event->id)->pluck('group.name');

        $event['going'] = $event->participants()->where('state', 'Going')->get();

        $event['invited'] = DB::table('event_participant')->where('event', $event->id)->whereNotIn('participant', DB::table('event_group')->join('group_member', 'event_group.group', '=', 'group_member.group')->pluck('group_member.member'))->join('user', 'user.id', '=', 'participant')->pluck('user.name');
        
        $event['files'] = File::where('event', $event->id)->get();

        $poll = Poll::where('event', $event->id)->first();
        if ($poll)
            $event['options'] = $poll->options()->get();
        else $event['options'] = [];

        $total = 0;
        foreach ($event['options'] as $option){
            $option['num_votes'] = $option->votes()->get()->count();
            $total += $option['num_votes'];
        }

        $event['total_votes'] = $total;

        $event['organizers'] = EventOrganizer::where('event', $event->id)->join('user', 'user.id', '=', 'event_organizer.organizer')->pluck('name')->toArray();

        $event['comments'] = Comment::where('event', $event->id)->join('user', 'user.id', '=', 'comment.participant')->get();
    }

    public function getEventFullInfo($event){
        $this->getEventKeyInfo($event);
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


        foreach ($events as $event) {
            $this->getEventKeyInfo($event);
        }

        return view('pages.events', ['events' => $events]);
    }

    /**
     * Creates a new item.
     *
     * @param int $event_id
     * @param Request request containing the description
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
     * @param int $id
     * @param Request request containing the new state
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
     * @param int $id
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
