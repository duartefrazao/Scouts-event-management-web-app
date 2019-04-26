<?php

namespace App\Http\Controllers;

use App\RegistrationRequest;
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

        $users = RegistrationRequest::all();

        return view('pages.admindash', ['users' => $users]);
    }

}
