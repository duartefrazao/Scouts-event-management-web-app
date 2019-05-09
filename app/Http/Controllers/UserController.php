<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth, auth:admin');
    }

    public function participation(Request $request, $event_id)
    {

        $going = $request->input('presence');

        //$this->authorize('create', $event_id);

        if (!Event::find($event_id)->participants->contains(Auth::id()))
            return response(json_encode("You cannot make a decision for an event you were not invited"), 400);
        else {

            $update = 'Pending';

            if ($going == "true")
                $update = 'Going';
            else if ($going == "false")
                $update = 'Not Going';
            else
                return response(json_encode("Value not valid!"), 400);


            Auth::user()->participant()->updateExistingPivot($event_id, ['state' => $update]);

            return response(json_encode("Success in registering the status"), 200);
        }

    }

    public function searchUsers(Request $request)
    {

        $users = DB::select('Select id, name, is_responsible,ts_rank(vector,keywords,2) AS rank
                                FROM "user", plainto_tsquery(\'Portuguese\',?) keywords
                                WHERE vector @@ keywords
                                ORDER BY rank DESC LIMIT 10;', array($request->input('name')));

        return response(json_encode($users), 200);

    }

    public function create($reg_request)
    {
        return User::create([
            'email' => $reg_request['email'],
            'password' => bcrypt($reg_request['password']),
            'name' => $reg_request['name'],
            'birthdate' => $reg_request['birthdate'],
            'is_responsible' => $reg_request['is_responsible'],
            'is_guardian' => $reg_request['is_guardian'],
            'description' => $reg_request['description']
        ]);

    }

    public function destroy(User $user)
    {
        return $user->delete();

        if (Request::ajax())
            return response(json_encode('Success'), 200);
    }

}
