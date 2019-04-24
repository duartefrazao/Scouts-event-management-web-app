<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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

    public function profileUpdate(Request $request){
        $name = $request->input('name');
        $description= $request->input('description');
        $email = $request->input('email');

        $user = Auth::user();

        print_r($user);

        $user->name=$name;
        $user->description=$description;
        $user->email=$email;



        return response(json_encode("Success in changing profile"), 200);

    }

}
