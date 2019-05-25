<?php



namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $members = $section->members()->get();

        
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

        $users = $members->filter(function($member,$key) use($begin_age){
            $birthdate = Carbon::createFromFormat('Y-m-d',$member->birthdate);
            $curr_date = Carbon::now();

            $diff = $curr_date->diffInYears($birthdate);

            return $diff >= $begin_age; 
        }); 

        return view('pages.manage_section',compact('users','section'));
    }


   
    public function store($section)
    {

        abort_if($section<0 || $section >4,401);

        $request= request()->all();

        if(isset($request['user'])){
            $promoted_scouts = collect($request['user']);
            $section = $request['section'];
    
            $promoted_scouts->map(function($scout,$key) use($section){
               Group::find($section)->members()->detach($scout);
               Group::find($section + 1)->members()->attach($scout);
            });
        }

        return back();
    }
}
