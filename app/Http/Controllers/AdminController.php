<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Group;
use App\GuardianExchange;
use App\RegistrationRequest;
use App\User;
use App\Mail\RegistrationAccepted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


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

        return view('pages.admin.requests', ['requests' => $requests]);
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


        $reg_request = DB::table('registration_request')->leftJoin('guardian_added_minors', 'guardian_added_minors.request', '=', 'registration_request.id')->where('registration_request.id', '=', $id)->first();


        return $this->register($reg_request);
    }


    public function register($request)
    {

        if ($request == [])
            return response(json_encode($request->id), 400);
        else if (isset($request->guardian)) {
            return response(json_encode($request->id), 501);
        }


        //TO-DO adicionar maneira de ser responsável ou não
        //Esta parte está incompleta
        if (isset($request->guardian)) {
            $request->is_guardian = true;
            $request->is_responsible = true;
        } else {
            $request->is_guardian = false;
            $request->is_responsible = true;

        }

        //return response(json_encode("here"), 200);
        $user = $this->createUser($request);


        if ($user === null) {
            return response(json_encode($request->id), 500);
        }


        RegistrationRequest::destroy($request->id);

        Mail::to($user->email)->queue(new RegistrationAccepted($user));

        return response(json_encode($request->id), 200);


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
            'birthdate' => $data->birthdate,
            'is_responsible' => $data->is_responsible,
            'is_guardian' => $data->is_guardian,
            'description' => $data->description
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
