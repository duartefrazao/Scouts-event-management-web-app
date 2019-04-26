<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
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

        $users = RegistrationRequest::all();

        return view('pages.admindash', ['users' => $users]);
    }

    public function store($id){

        $reg_request = RegistrationRequest::find($id);

        RegisterController::register($reg_request);

        $name =  RegistrationRequest::find($id)->name;
        return response(json_encode("Handling request for $name"), 200);
    }

}
