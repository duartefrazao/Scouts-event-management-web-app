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

        $requests = RegistrationRequest::all();

        $users = User::all();

        $exchanges = GuardianExchange::all();

        $lobitos = Group::find(1)->moderators;

        $exploradores = Group::find(2)->moderators;

        $pioneiros = Group::find(3)->moderators;

        $caminheiros = Group::find(4)->moderators;

        $moderators = array('lobitos' => $lobitos, 'exploradores' => $exploradores, 'pioneiros' => $pioneiros, 'caminheiros' => $caminheiros);

        return view('pages.admindash', ['requests' => $requests, 'users' => $users, 'exchanges' => $exchanges, 'moderators' => $moderators]);
    }

}
