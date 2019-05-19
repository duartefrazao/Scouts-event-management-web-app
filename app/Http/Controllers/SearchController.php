<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Event;
use App\Group;
use DateTime;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $resource = request()->all()['resource'];

        switch ($resource)
        {
            case "simple":
                return $this->showSimpleSearch();
                break;
            
            case "events":
                return $this->showEventsSearch();
                break;
            
            case "users":
                return $this->showUsersSearch();
                break;
            
            default:
                abort(404);
                
        }
    }

    public function showSimpleSearch () {

        $query = request()->all()["query"];

        $users = DB::select('Select * ,ts_rank(vector,keywords,2) AS rank
        FROM "user", plainto_tsquery(\'Portuguese\',?) keywords
        WHERE vector @@ keywords
        ORDER BY rank DESC LIMIT 10;', [$query]);


        $events = DB::select('Select event.*, location.*, event_participant.*, ts_rank(vector,keywords,2) AS rank
                FROM event JOIN location ON (event.location = location.id) JOIN event_participant 
                ON (event_participant.participant = ? AND event_participant.event = event.id)
                ,plainto_tsquery(\'Portuguese\',?) keywords
                WHERE vector @@ keywords 
                ORDER BY rank DESC LIMIT 10;', [auth()->id(),$query]);

        $groups = DB::select('Select * ,ts_rank(vector,keywords,2) AS rank
                FROM "group" join group_member ON (id=group_member.group AND member = ?), plainto_tsquery(\'Portuguese\',?) keywords
                WHERE vector @@ keywords
                ORDER BY rank DESC LIMIT 10;', [auth()->id(),$query]);

        foreach($groups as $group){
            
            $retrieved_group = Group::find($group->id);

            $group->events = $retrieved_group->events()->get();
            $group->members = $retrieved_group->members()->get();
        
        }
        
        foreach($events as $event){
            //$event->going = ($event == "Going") ? true:false; 
            $retrieved_event = Event::find($event->id);
            
            $event->invited = $retrieved_event->participants()->limit(3)->get();
            $event->groups = DB::table('event_group')->join('group', 'group.id', '=', 'event_group.group')->where('event', $event->id)->pluck('group.name');
            $event->going = $retrieved_event->participants()->where('state', 'Going')->get();
        }
        
        
        return view('pages.search', compact('query','users','events','groups'));
    }

    public function showEventsSearch (){



        $request = request()->all();
        $query = $request["query"];
        $tag = $request["tag"];
        $start_date = $request["start_date"];
        $end_date = $request["end_date"];

        $events = DB::select('Select *, location.name, event_participant.*, ts_rank(vector,keywords,2) AS rank
        FROM event JOIN location ON (event.location = location.id) JOIN event_participant 
        ON (event_participant.participant = ? AND event_participant.event = event.id)
        ,plainto_tsquery(\'Portuguese\',?) keywords
        WHERE vector @@ keywords 
        ORDER BY rank DESC LIMIT 10;', [auth()->id(),$query]);

        
        if(isset($start_date)){
            $events = collect($events)->filter(function($event,$key) use($start_date){
                return $event->start_date >= $start_date;
            });
        }
        
        if(isset($end_date)){
            $events = collect($events)->filter(function($event,$key) use($end_date){
                return $event->final_date <= $end_date;
            });
        }

        foreach($events as $event){
            $event->going = ($event == "Going") ? true:false; 
        }

        return view('pages.search', compact('query','events'));
        
    }

    public function showUsersSearch (){

        $request = request()->all();
        $query = $request["query"];
        $age = $request['age'];
        $section = $request['section'];
       
        
        $users = DB::select('Select * ,ts_rank(vector,keywords,2) AS rank
            FROM "user", plainto_tsquery(\'Portuguese\',?) keywords
            WHERE vector @@ keywords 
            ORDER BY rank DESC LIMIT 10;', [$query]);
        
            
        if(isset($age)){
            $users = collect($users)->filter(function($member,$key) use ($age){
                $now = new DateTime();
                $calculated_age = $now->diff(new DateTime($member->birthdate))->y;

                return  $calculated_age === (int) $age;
            });
        }


        if(isset($section) && $section>0 && $section<5){
            $users = collect($users)->filter(function($member,$key) use($section){
                $user = User::find($member->id);

                return $user->member->contains($section);
            });
        }

        return view('pages.search', compact('query','users'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
