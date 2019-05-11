<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function list()
    {

        if (!Auth::check()) {
            return redirect(route('login'));
        }

        $event_controller = new EventController();

        $group_controller = new GroupController();

        $events = $event_controller->list();

        $groups = $group_controller->list();

        
        return view('pages.homepage', ['events' => $events, 'groups' => $groups]);

    }
}
