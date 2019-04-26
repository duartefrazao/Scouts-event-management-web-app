<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\RegistrationRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    protected $redirectTo = '/home';


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


        //$reg_request = RegistrationRequest::find($id);

        $reg_request = DB::table('registration_request')->leftJoin('guardian_added_minors','guardian_added_minors.request','=','registration_request.id')->where('registration_request.id','=',$id)->first();


        return $this->register($reg_request);
    }

    public function register($request){

        if($request == [])
            return response(json_encode($request->id), 500);
        else if(isset($request->guardian)){
            return response(json_encode($request->id), 500);
        }


        //TO-DO adicionar maneira de ser responsável ou não
        //Esta parte está incompleta
        if(isset($request->guardian)) {
            $request->is_guardian = true;
            $request->is_responsible =true;
        }else{
            $request->is_guardian= false;
            $request->is_responsible =true;

        }

        //return response(json_encode("here"), 200);
        $user =  $this->createUser($request);


        if($user != null){
            RegistrationRequest::destroy($request->id);
            return response(json_encode($request->id), 200);
        }else{
            return response(json_encode($request->id), 400);
        }



    }

    protected function createUser($data)
    {


        return User::create([
            'email' => $data->email,
            'password' => $data->password,
            'name' => $data->name,
            'birthdate' => $data->birthdate,
            'is_responsible' => $data->is_responsible,
            'is_guardian' => $data->is_guardian,
            'description' => $data->description
        ]);

    }

}
