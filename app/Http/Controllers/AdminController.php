<?php

namespace App\Http\Controllers;

use App\Group;
use App\GuardianExchange;
use App\RegistrationRequest;
use App\User;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function list()
    {

        if (!Auth::check()) return redirect('admin/login');

        $requests = $this->createRequestsArray();

        $users = $this->createUsersArray();

        $moderators = $this->createModeratorsArray();

        $exchanges = $this->createExchangesArray();


        return view('pages.admindash', ['requests' => $requests, 'users' => $users, 'exchanges' => $exchanges, 'moderators' => $moderators]);
    }


    private function createRequestsArray()
    {

        $requests = RegistrationRequest::all();

        return $requests;

    }

    private function createUsersArray()
    {


        $users = array();

        $users['all'] = User::all();

        $users['lobitos'] = Group::find(1)->members;

        $users['pioneiros'] = Group::find(2)->members;

        $users['exploradores'] = Group::find(3)->members;

        $users['caminheiros'] = Group::find(4)->members;

        $users['guardians'] = User::where('is_guardian', true)->get();

        return $users;

    }

    private function createModeratorsArray()
    {


        $lobitos = Group::find(1)->moderators;

        $exploradores = Group::find(2)->moderators;

        $pioneiros = Group::find(3)->moderators;

        $caminheiros = Group::find(4)->moderators;

        $moderators = array('lobitos' => $lobitos, 'exploradores' => $exploradores, 'pioneiros' => $pioneiros, 'caminheiros' => $caminheiros);


        return $moderators;
    }

    private function createExchangesArray()
    {

        $exchanges_temp = GuardianExchange::all();

        $exchanges = array();

        $i = 0;

        foreach ($exchanges_temp as $exch) {

            $new_guardian = $exch->new_guardian;

            $minor = $exch->minor;

            $minor_user = User::find($minor);


            $exchanges[$i] = array('new_guardian' => User::find($new_guardian), 'minor' => $minor_user, 'old_guardian' => User::find($minor_user->guardian));

            ++$i;

        }

        return $exchanges;
    }
}
