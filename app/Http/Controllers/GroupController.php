<?php

namespace App\Http\Controllers;
include_once('EventController.php');

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

class GroupController extends Controller
{

    /**
     * Shows the group for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $group = Group::find($id);

        $this->authorize('show', $group);

        $this->getGroupFullInfo($group);

        return view('pages.group', ['group' => $group]);
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

        $group_mem = Auth::user()->member()->orderBy('id')->get();

        $group_mod = Auth::user()->moderator()->orderBy('id')->get();

        $groups = $group_mem->merge($group_mod);

        foreach($groups as $index => $group) {
            $this->getGroupKeyInfo($groups[$index]);
        }

        return view('pages.groups', ['groups' => $groups]);
    }

    public function getGroupKeyInfo(&$group){
        $group['events'] = $group->events()->get();
        $group['members'] = $group->members()->get();
    }

    public function getGroupFullInfo(&$group){
        $this->getGroupKeyInfo($group);

        foreach($group['events'] as &$event) {
            $event['location'] = Location::find($event->location);
            if ($event['location'])
                $event['loc_name'] = $event->location->name;

            //TODO CHANGE THIS
            $event['groups'] = DB::table('event_group')->join('group', 'group.id', '=', 'event_group.group')->where('event', $event->id)->pluck('group.name');

            $event['going'] = $event->participants()->where('state', 'Going')->get();

            $event['invited'] = DB::table('event_participant')->where('event', $event->id)->join('user', 'user.id', '=', 'participant')->limit(4)->pluck('user.name');
        }  

        $group['moderators'] = $group->moderators()->get();
    }

    /**
     * Creates a new group.
     *
     * @param  int  $event_id
     * @param  Request request containing the description
     * @return Response
     */
    public function create(Request $request)
    {
        $group = new Group();

        $this->authorize('create', $group);

        $group->name = $request->input('name');
        $group->is_section = $request->input('is_section');

        return $group;
    }

    /**
     * Updates the state of an individual group.
     *
     * @param  int  $id
     * @param  Request request containing the new state
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $group = Group::find($id);

        $this->authorize('update', $group);

        $group->name = $request->input('name');
        $group->save();

        return $group;
    }

    /**
     * Deletes an individual event.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $group = Group::find($id);

        $this->authorize('delete', $group);
        $group->delete();

        return $group;
    }

}
