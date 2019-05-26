<?php

namespace App\Http\Controllers;

use App\RegistrationRequestGuardian;
use Illuminate\Http\Request;

class RegistrationRequestGuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reg_request = new RegistrationRequestGuardian;

        $reg_request->minor = $request->minor;
        $reg_request->name = $request->name;
        $reg_request->birthdate = $request->birthdate;
        $reg_request->email = $request->email;
        $reg_request->description = $request->description;
        $reg_request->password = $request->password;

        $reg_request->save();

        return $reg_request;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RegistrationRequestGuardian  $registrationRequestGuardian
     * @return \Illuminate\Http\Response
     */
    public function show(RegistrationRequestGuardian $registrationRequestGuardian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegistrationRequestGuardian  $registrationRequestGuardian
     * @return \Illuminate\Http\Response
     */
    public function edit(RegistrationRequestGuardian $registrationRequestGuardian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegistrationRequestGuardian  $registrationRequestGuardian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegistrationRequestGuardian $registrationRequestGuardian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegistrationRequestGuardian  $registrationRequestGuardian
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegistrationRequestGuardian $registrationRequestGuardian)
    {
        //
    }
}
