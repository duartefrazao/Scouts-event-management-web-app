<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Group;
use App\User;
use function PHPSTORM_META\map;


class ProfileController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {

        $user = User::find($id);

       // $this->authorize('show', $member);

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


}
