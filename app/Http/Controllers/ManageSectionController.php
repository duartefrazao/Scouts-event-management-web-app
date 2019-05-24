<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\DB;

class ManageSectionController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($section)
    {

        $section  = Group::find($section);

        //Didn't find || Not a section
        abort_if(!isset($section) || !$section->is_section,401);
        
        $begin_age = 0;

        switch ($section->name){
            case 'Lobitos':
                $begin_age = 9;
                break;
            case 'Exploradores':
                $begin_age = 13;
                break;
            case 'Pioneiros':
                $begin_age = 17;
                break;
            case 'Caminheiros':
                $begin_age = 22;
                break;
            default:
                abort(501);
                break;
        }
    
        
        $users = DB::select('Select * from "user" where date_part(\'year\', CURRENT_DATE) - date_part(\'year\', birthdate) > ?;',[$begin_age]);


        return view('pages.manage_section',compact('users','section'));
    }


   
    public function store($section)
    {
        dd(request()->all());
    }
}
