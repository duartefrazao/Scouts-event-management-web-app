<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Group;
use App\GuardianExchange;
use App\RegistrationRequest;
use App\RegistrationRequestGuardian;
use App\User;
use App\Mail\RegistrationAccepted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth:admin');
    }

   

    public function drawRequests()
    {
        if (!Auth::check()) return redirect('admin/login');

        $requests = $this->createRequestsArray();

        $scoutsWithParents =RegistrationRequestGuardian::all();
        $scoutsWithParentsIds =RegistrationRequestGuardian::all()->pluck("minor");
        
        $simple_registrations = RegistrationRequest::all()->filter(function($scout,$key) use($scoutsWithParentsIds){
            return !$scoutsWithParentsIds->contains($scout->id);
        });

        $simple_registrations->map(function ($scout, $key){
            $scout->profile_image = $scout->getProfileImageRegistrations(false,$scout->id);
        });

        $minor_registrations =collect();

        $scoutsWithParents->map(function ($parent, $key) use($minor_registrations){
            $scout = RegistrationRequest::find($parent->minor);

            $parent->profile_image = $parent->getProfileImageRegistrations(true,$scout->id);
            $scout->profile_image = $scout->getProfileImageRegistrations(false,$scout->id);

            $minor_registrations->push(['scout'=>$scout,"parent"=>$parent,"type"=>"guardian"]);
        });

       


        //dd($minor_registrations);
        return view('pages.admin.requests', ['duplex_regs' => $minor_registrations, 'simple' =>$simple_registrations]);
    }

    public function list()
    {
        if (!Auth::check()) return redirect('admin/login');

        $requests = $this->createRequestsArray();
        
        return view('pages.admin.requests', ['requests' => $requests]);
    }


    public function drawUsers()
    {
        if (!Auth::check()) return redirect('admin/login');

        $users = $this->createUsersArray();

        return view('pages.admin.users', ['users' => $users]);

    }

    public function drawGuardians()
    {
        if (!Auth::check()) return redirect('admin/login');

        $exchanges = $this->createExchangesArray();

        return view('pages.admin.guardians', ['exchanges' => $exchanges]);
    }

    public function drawSections()
    {
        if (!Auth::check()) return redirect('admin/login');

        $moderators = $this->createModeratorsArray();

        return view('pages.admin.sections', ['moderators' => $moderators]);
    }


    public function searchUsers(Request $request)
    {
        $query_result = DB::select('Select * ,ts_rank(vector,keywords,2) AS rank
                                FROM "user", plainto_tsquery(\'Portuguese\',?) keywords
                                WHERE vector @@ keywords
                                ORDER BY rank DESC LIMIT 10;', array($request->input('name')));


        $users['all'] = array();

        $users['lobitos'] = array();

        $users['pioneiros'] = array();

        $users['exploradores'] = array();

        $users['caminheiros'] = array();

        $users['guardians'] = array();

        foreach ($query_result as $temp_user) {

            $user = User::find($temp_user->id);

            array_push($users['all'], $user);

            if ($user->member->contains(1))
                array_push($users['lobitos'], $user);
            else if ($user->member->contains(2))
                array_push($users['pioneiros'], $user);
            else if ($user->member->contains(3))
                array_push($users['exploradores'], $user);
            else if ($user->member->contains(4))
                array_push($users['caminheiros'], $user);

            if ($user->is_guardian)
                array_push($users['guardians'], $user);
        }


        return view('pages.admin.users', ['users' => $users]);
    }


    public function store($id)
    {

        //TO-DO confirmar se não existe outra forma de usar ajax e confirmar o csrf
        if (csrf_token() != request()['_token']) {
            return response(json_encode(request()->all()), 401);
        }

        $return = NULL;

        try{
            $parent = RegistrationRequestGuardian::findOrFail($id);
            $minor = RegistrationRequest::find($parent->minor);

            $return =$this->registerWithParent($minor,$parent);

        } catch(ModelNotFoundException $e) {
            
            try{
                $responsible = RegistrationRequest::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response(json_encode("Bad request"), 400);
            }

            $return = $this->registerResponsible($responsible);
        }

        return response(json_encode($return), 200);

    }

    public function registerResponsible($responsible){
        $responsible->is_guardian = false;
        $responsible->is_responsible = true;
        $responsible->guardian = NULL;

        $user = $this->createUser($responsible);

        RegistrationRequest::destroy($responsible->id);

        $user->moveImageIfExists($responsible->id,$user->id,false);

        Mail::to($user->email)->queue(new RegistrationAccepted($user));

        return $responsible->id;
    }


    public function registerWithParent($minor,$parent)
    {   

        $parent->is_responsible = true;
        $parent->is_guardian = true;
        $parent->guardian = NULL;
        $userParent = $this->createUserParent($parent);


        $minor->is_responsible = false;
        $minor->is_guardian = false;
        $minor->guardian = $userParent->id;
        $userMinor = $this->createUser($minor);

        $userMinor->moveImageIfExists($minor->id,$userMinor->id,false);
        $userParent->moveImageIfExists($minor->id,$userParent->id,true);

        RegistrationRequest::destroy($minor->id);
        RegistrationRequestGuardian::destroy($minor->id);

        Mail::to($userMinor->email)->queue(new RegistrationAccepted($userMinor));
        Mail::to($userParent->email)->queue(new RegistrationAccepted($userParent));

        return $minor->id;
    }

    public function destroy($id)
    {

        //TO-DO confirmar se não existe outra forma de usar ajax e confirmar o csrf
        if (csrf_token() != request()['_token']) {
            return response(json_encode(request()->all()), 401);
        }

        $request = DB::table('registration_request')->leftJoin('guardian_added_minors', 'guardian_added_minors.request', '=', 'registration_request.id')->where('registration_request.id', '=', $id)->first();

        if ($request == [])
            return response(json_encode($request->id), 400);
        else if (isset($request->guardian)) {
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
            'guardian' => $data->guardian,
            'birthdate' => $data->birthdate,
            'is_responsible' => $data->is_responsible,
            'is_guardian' => $data->is_guardian,
            'description' => $data->description
        ]);
    }

    protected function createUserParent($data)
    {
        return User::create([
            'email' => $data->g_email,
            'password' => $data->g_password,
            'name' => $data->g_name,
            'guardian' => $data->guardian,
            'birthdate' => $data->g_birthdate,
            'is_responsible' => $data->is_responsible,
            'is_guardian' => $data->is_guardian,
            'description' => $data->g_description
        ]);
    }


    protected function removeUser($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
        } catch (\Illuminate\Database\QueryException $ex) {

            return response(json_encode($ex->getMessage()), 401);
            
        }

        return response(json_encode('Success'), 200);
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
