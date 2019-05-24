<?php

namespace App\Http\Controllers;

use App\Notifications\GroupInvitation;
use App\Notifications\GroupOrganizerInvitation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Location;
use App\Group;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Shows the group for a given id.
     *
     * @param int $id
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

        foreach ($groups as $index => $group) {
            $this->getGroupKeyInfo($groups[$index]);
        }

        // return view('pages.groups', ['groups' => $groups]);
        return $groups;
    }

    public function getGroupKeyInfo(&$group)
    {
        $group['events'] = $group->events()->get();
        $group['members'] = $group->members()->get();

    }

    public function getGroupFullInfo(&$group)
    {
        $this->getGroupKeyInfo($group);

        foreach ($group['events'] as &$event) {
            $event['location'] = Location::find($event->location);
            if ($event['location'])
                $event['location'] = $event->location->name;

            //TODO CHANGE THIS
            $event['groups'] = DB::table('event_group')->join('group', 'group.id', '=', 'event_group.group')->where('event', $event->id)->pluck('group.name');

            $event['going'] = $event->participants()->where('state', 'Going')->get();

            $event['invited'] = $event->participants()->limit(3)->get();
        }

        $group['moderators'] = $group->moderators()->get();

        $this->getProfilePictures($group);

    }

    public function getGroups()
    {

        $groups_mem = Auth::user()->member()->get();
        $groups_mod = Auth::user()->moderator()->get();

        $groups = $groups_mem->merge($groups_mod);

        return $groups;
    }

    /**
     * Creates a new group.
     *
     * @param int $event_id
     * @param Request request containing the description
     * @return Response
     */
    public function create(Request $request)
    {

        return view('pages/create_group');
    }

    public function store(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'string|required',
            'member' => 'required',
            'moderator' => 'nullable'
        ]);

        $validator->after(function ($validator) use ($data) {
            if (isset($data['moderator']))
                foreach ($data['moderator'] as $new_organizer) {
                    if (!User::find($new_organizer)->is_responsible) {
                        $validator->errors()->add('moderator', 'Os moderadores têm de ser utilizadores responsáveis!');
                        break;
                    }
                }
        });

        if ($validator->fails()) {
            return redirect('group/create')
                ->withErrors($validator)
                ->withInput();
        }


        $group = new Group();

        $this->authorize('store', Group::class);

        $group->name = $data['name'];
        $group->save();


        if (isset($data['participant']))
            foreach ($data['participant'] as $new_participant) {
                $group->members()->attach($new_participant);
                $user = User::find($new_participant);
                $user->notify(new GroupInvitation(Auth::user(), $user, $group));
            }

        if (isset($data['organizer']))
            foreach ($data['organizer'] as $new_organizer) {

                if ($new_organizer->id === Auth::id())
                    continue;

                $group->moderators()->attach($new_organizer);
                $user = User::find($new_organizer);
                $user->notify(new GroupOrganizerInvitation(Auth::user(), $user, $group));
            }

        $group->moderators()->attach(Auth::id());
        Auth::user()->notify(new GroupOrganizerInvitation(Auth::user(), Auth::user(), $group));

        return redirect('groups/' . $group->id);
    }

    /**
     * Updates the state of an individual group.
     *
     * @param int $id
     * @param Request request containing the new state
     * @return Response
     */
    public
    function update(Request $request, $id)
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
     * @param int $id
     * @return Response
     */
    public
    function delete(Request $request, $id)
    {
        $group = Group::find($id);

        $this->authorize('delete', $group);
        $group->delete();

        return $group;
    }

    public
    function getProfilePictures($group)
    {
        foreach ($group['members'] as $member) {
            $member->getProfileImage();
        }

        foreach ($group['moderators'] as $mod) {
            $mod->getProfileImage();
        }
    }

    public
    function searchGroups(Request $request)
    {

        $groups = DB::select('Select id, name, ts_rank(vector,keywords,2) AS rank
                                FROM "group", plainto_tsquery(\'Portuguese\',?) keywords
                                WHERE vector @@ keywords
                                ORDER BY rank DESC LIMIT 10;', array($request->input('name')));

        foreach ($groups as $group) {
            $r_group = Group::find($group->id);
            $group->num_part = $r_group->members()->count();
        }

        return response(json_encode($groups), 200);

    }
}
