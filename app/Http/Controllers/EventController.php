<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Event;
use App\Location;
use App\File;
use App\Poll;
use App\Comment;
use Illuminate\Support\Facades\Validator;

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

        $this->getEventFullInfo($event);

        return view('pages.event', ['event' => $event]);
    }

    public function getEventKeyInfo($event)
    {
        $event['location'] = Location::find($event->location);
        if ($event['location'])
            $event['loc_name'] = $event->location->name;

        //TODO CHANGE THIS
        $event['groups'] = DB::table('event_group')->join('group', 'group.id', '=', 'event_group.group')->where('event', $event->id)->pluck('group.name');

        $event['going'] = $event->participants()->where('state', 'Going')->get();

        //$event['invited'] = DB::table('event_participant')->where('event', $event->id)->join('user', 'user.id', '=', 'participant')->limit(3)->pluck('user.name');

        $event['invited'] = $event->participants()->limit(3)->get();
    }

    public function getEventFullInfo($event)
    {
        $this->getEventKeyInfo($event);

        $event['files'] = File::where('event', $event->id)->get();

        $poll = Poll::where('event', $event->id)->first();
        if ($poll)
            $event['options'] = $poll->options()->get();
        else $event['options'] = [];

        $total = 0;
        foreach ($event['options'] as $option) {
            $option['num_votes'] = $option->votes()->get()->count();
            $total += $option['num_votes'];
        }

        $event['total_votes'] = $total;

        $event['organizers'] = $event->organizers;

        // $event['organizers'] = EventOrganizer::where('event', $event->id)->join('user', 'user.id', '=', 'event_organizer.organizer')->pluck('name')->toArray();

        $event['comments'] = Comment::where('event', $event->id)->join('user', 'user.id', '=', 'comment.participant')->orderBy('comment.id', 'DESC')->get();
    }

    public function getGroupInfo($group)
    {

    }

    /**
     * Shows all events.
     *
     * @return Response
     */
    public function list()
    {

        //TODO IS THIS NEEDED?
        //$this->authorize('list', Event::class);

        $events_part = Auth::user()->participant()->orderBy('id')->get();

        $events_org = Auth::user()->organizer()->orderBy('id')->get();

        $events = $events_part->merge($events_org);


        foreach ($events as $event) {
            $this->getEventKeyInfo($event);
        }

        $groups_mem = Auth::user()->member()->get();
        $groups_mod = Auth::user()->moderator()->get();

        $groups = $groups_mem->merge($groups_mod);

        return view('pages.events', ['events' => $events], ['groups' => $groups]);
    }

    /**
     * Creates a new item.
     *
     * @param int $event_id
     * @param Request request containing the description
     * @return Response
     */
    public function create()
    {
        $locations = Location::all();

        return view('pages/create_event', ['locations' => $locations]);
    }

    /**
     * Get a validator for an incoming event request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'string|required',
            'description' => 'string|required',
            'location' => 'required',
            'price' => 'required'
        ]);
    }

    public function store(Request $request)
    {


        $data = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'price' => 'required',
            'start_date' => 'nullable|date',
            'final_date' => 'nullable|date',
            'location' => 'required',
            'participants' => 'nullable'
        ]);


        $event = new Event();

        $this->authorize('store', Event::class);

        $event->title = $data['title'];
        $event->description = $data['description'];
        $event->price = $data['price'];
        $event->start_date = $data['start_date'];
        $event->final_date = $data['final_date'];
        $event->location = $data['location'];
        $event->save();

        if (isset($data['participants']))
            foreach ($data['participants'] as $new_participant)
                $event->participants()->attach($new_participant);

        $event->organizers()->attach(Auth::id());

        return redirect('events/' . $event->id);

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
        $event = Event::find($id);

        $this->authorize('delete', $event);
        $event->delete();

        return $event;
    }

    public function addParticipant(Request $request, Event $event)
    {
        foreach ($request->input('new-members') as $member) {
            $event->participants()->attach($member);
        }

        return response(json_encode('Sucess in adding members'), 200);
    }


}
