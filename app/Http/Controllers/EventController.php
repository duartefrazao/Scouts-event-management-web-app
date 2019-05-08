<?php

namespace App\Http\Controllers;

use App\Notifications\EventInvitation;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Storage;


use App\Event;
use App\Location;
use App\File;
use App\Poll;
use App\User;
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

        /* foreach(Storage::allFiles('files/' . $event->id) as $filename){
            $event['files']->push(Storage::get($filename));
        } */

        $files = Storage::allFiles('files/' . $event->id);
       /*  array_map(function($file){
            return Storage::get($file)->getClientOriginalName();
        },$files,$files); */

        $event['files'] = $this->removePath($files);

       // $event['files'] = Storage::allFiles('files/' . $event->id);
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

        $events_part = Auth::user()->participant()->orderBy('id')->get();

        $events_org = Auth::user()->organizer()->orderBy('id')->get();

        $events = $events_part->merge($events_org);


        foreach ($events as $event) {
            $this->getEventKeyInfo($event);
        }

        /*        $groups_mem = Auth::user()->member()->get();
                $groups_mod = Auth::user()->moderator()->get();

                $groups = $groups_mem->merge($groups_mod);

                return view('pages.events', ['events' => $events], ['groups' => $groups]);*/

        return $events;
    }

    public function getEvents()
    {

        $events_part = Auth::user()->participant()->orderBy('id')->get();

        $events_org = Auth::user()->organizer()->orderBy('id')->get();

        $events = $events_part->merge($events_org);


        foreach ($events as $event) {
            $this->getEventKeyInfo($event);
        }


        return $events;
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

    
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'string|required',
            'description' => 'string|required',
            'price' => 'required',
            'start_date' => 'nullable|date',
            'final_date' => 'nullable|date',
            'location' => 'required',
            'participant' => 'nullable',
            'organizer' => 'nullable'
        ]);

        $validator->after(function ($validator) use ($data) {
            if (isset($data['organizer']))
                foreach ($data['organizer'] as $new_organizer) {
                    if (!User::find($new_organizer)->is_responsible) {
                        $validator->errors()->add('organizer', 'Os organizadores têm de ser utilizadores responsáveis!');
                        break;
                    }
                }
        });

        if ($validator->fails()) {
            return redirect('event/create')
                ->withErrors($validator)
                ->withInput();
        }


        $event = new Event();

        $this->authorize('store', Event::class);

        $event->title = $data['title'];
        $event->description = $data['description'];
        $event->price = $data['price'];
        $event->start_date = $data['start_date'];
        $event->final_date = $data['final_date'];
        $event->location = $data['location'];
        $event->save();


        if (isset($data['participant']))
            foreach ($data['participant'] as $new_participant) {
                $event->participants()->attach($new_participant);
                $user = User::find($new_participant);
                $user->notify(new EventInvitation($user, $event));
            }

        if (isset($data['organizer']))
            foreach ($data['organizer'] as $new_organizer)
                $event->organizers()->attach($new_organizer);

        $event->organizers()->attach(Auth::id());

        $this->saveFiles($request->file('files'), $event->id);

        return redirect('events/' . $event->id);

    }


    public function removePath($files){
        $new_arr = collect();
        
        foreach($files as $file)
        {
            $info = explode('/',$file);
            $end = end($info);
            $new_arr->push($end);
        }
        return $new_arr;
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

    public function saveFiles($files, $event_id){

        $paths = [];

        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $filename  = $file->getClientOriginalName();
            $paths[]   = $file->storeAs('files/'. $event_id, $filename);
        }

    }

    public function getFile(Event $event){

        $filename = request()->all()['file'];

        return Storage::download('files/'. $event->id . '/' . $filename ); 
    }

}
