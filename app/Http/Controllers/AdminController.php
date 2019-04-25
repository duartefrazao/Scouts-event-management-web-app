<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function list(){

        if (!Auth::check()) return redirect('admin/login');

        return view('pages.admindash');
    }

}
