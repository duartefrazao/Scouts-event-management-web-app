<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProfileController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }


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
        //
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
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user()->find($id);


        $this->getInfo($user);

        $this->filterSection($user);

        return view('pages.profile', ['user' => $user]);

    }

    public function getInfo($user){
        $user['section'] = DB::table('group_member')->join('group','group.id','=','group_member.group')->join('user','user.id','=','group_member.member')->select('group.name as group')->where('user.id','=',$user->id)->get();

    }

    public function filterSection($user){

        if($user->section->contains('group','Chefes')){
            $user->section = "Chefe";
        }else if($user->section->contains('group','Pais')){
            $user->section = "Pai";
        }else if($user->section->contains('group','Caminheiros')){
            $user->section = "Caminheiro";
        }else if($user->section->contains('group','Pioneiros')){
            $user->section = "Pioneiro";
        }else if($user->section->contains('group','Exploradores')){
            $user->section = "Explorador";
        }else if($user->section->contains('group','Lobitos')){
            $user->section = "Lobito";
        }else{
            $user->section = "";
        }

    }


    /**
     * Get a validator for an incoming profile.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required:string',
            'description' => 'required:string',
            'email' => 'required:string',
            'old_password' => 'required:string',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $request= request()->all();

        if(isset($request['new_password'])){
            request()->validate([
                'new_password' => 'required:string:confirmed',
            ]);
        }

        $validator = $this->validator($request);
        $validator->validate();

        $user = User::find($id);

        if(!Hash::check($request['old_password'],$user->password)){
            $validator->getMessageBag()->add('old_password', 'Wrong current password');
            return redirect("/user/{$id}")->withErrors($validator);
        }

        $user->name= request('name');
        $user->email= request('email');
        $user->description= request('description');

        $user->save();

        return redirect("/user/{$id}");


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }


}
