<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Group;
use App\GuardianExchange;
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

        $requests = $this->createRequestsArray();

        $users = $this->createUsersArray();

        $moderators = $this->createModeratorsArray();

        $exchanges = $this->createExchangesArray();


        return view('pages.admindash', ['requests' => $requests, 'users' => $users, 'exchanges' => $exchanges, 'moderators' => $moderators]);
    }

 

    public function store($id){

        //TO-DO confirmar se não existe outra forma de usar ajax e confirmar o csrf
        if(csrf_token() != request()['_token']){
            return response(json_encode(request()->all()), 401);
        }


        $reg_request = DB::table('registration_request')->leftJoin('guardian_added_minors','guardian_added_minors.request','=','registration_request.id')->where('registration_request.id','=',$id)->first();


        return $this->register($reg_request);
    }


    public function register($request){

        if($request == [])
            return response(json_encode($request->id), 400);
        else if(isset($request->guardian)){
            return response(json_encode($request->id), 501);
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
            return response(json_encode($request->id), 500);
        }



    }

    public function destroy($id){

        //TO-DO confirmar se não existe outra forma de usar ajax e confirmar o csrf
        if(csrf_token() != request()['_token']){
            return response(json_encode(request()->all()), 401);
        }

        $request= DB::table('registration_request')->leftJoin('guardian_added_minors','guardian_added_minors.request','=','registration_request.id')->where('registration_request.id','=',$id)->first();

        if($request == [])
            return response(json_encode($request->id), 400);
        else if(isset($request->guardian)){
            return response(json_encode($request->id), 501);
        }


        RegistrationRequest::destroy($request->id);
        return response(json_encode($request->id), 200);
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


    private function createRequestsArray()
    {

        $requests = RegistrationRequest::all();

        return $requests;

    }

    private function createUsersArray()
    {


        $users = array();

        $users['all'] = User::all();

        $users['lobitos'] = Group::find(1)->members;

        $users['pioneiros'] = Group::find(2)->members;

        $users['exploradores'] = Group::find(3)->members;

        $users['caminheiros'] = Group::find(4)->members;

        $users['guardians'] = User::where('is_guardian', true)->get();

        return $users;

    }

    private function createModeratorsArray()
    {


        $lobitos = Group::find(1)->moderators;

        $exploradores = Group::find(2)->moderators;

        $pioneiros = Group::find(3)->moderators;

        $caminheiros = Group::find(4)->moderators;

        $moderators = array('lobitos' => $lobitos, 'exploradores' => $exploradores, 'pioneiros' => $pioneiros, 'caminheiros' => $caminheiros);


        return $moderators;
    }

    private function createExchangesArray()
    {

        $exchanges_temp = GuardianExchange::all();

        $exchanges = array();

        $i = 0;

        foreach ($exchanges_temp as $exch) {

            $new_guardian = $exch->new_guardian;

            $minor = $exch->minor;

            $minor_user = User::find($minor);


            $exchanges[$i] = array('new_guardian' => User::find($new_guardian), 'minor' => $minor_user, 'old_guardian' => User::find($minor_user->guardian));

            ++$i;

        }

        return $exchanges;
    }
}
