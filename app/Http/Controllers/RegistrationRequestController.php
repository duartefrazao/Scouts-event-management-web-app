<?php

namespace App\Http\Controllers;


use App\RegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use App\RegistrationRequestGuardian;



class RegistrationRequestController extends Controller
{

    /**
     * Shows the RegistrationRequest for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $reg_request = RegistrationRequest::find($id);

        //$this->authorize('show', $reg_request);

        return view('pages.reg_request', ['reg_request' => $reg_request]);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
            'birthdate' => 'required|date'
        ]);
    }



    /**
     * Updates the state of an individual RegistrationRequest.
     *
     * @param  int  $id
     * @param  Request request containing the new state
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $reg_request = RegistrationRequest::find($id);

        //$this->authorize('update', $reg_request);

        $reg_request->state = $request->input('state');
        $reg_request->save();

        return $reg_request;
    }

    /**
     * Deletes an individual RegistrationRequest.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $reg_request = RegistrationRequest::find($id);

        $this->authorize('delete', $reg_request);
        $reg_request->delete();

        return $reg_request;
    }


    /**
     * Shows all RegistrationRequest.
     *
     * @return Response
     */
    public function list()
    {
        if (!Auth::check()) return redirect()->route('login');

        //$this->authorize('list', RegistrationRequest::class);

        $reg_requests = RegistrationRequest::all();

        return view('pages.events', ['reg_requests' => $reg_requests]);
    }


    public function store(Request $request){
        if($request['options'] === "menor")
        {
            //Save form information
            session(['son_registration' => request()->all()]); 
            session()->save();
            
            return view('auth.parentRegister');
        }

        $scout_data = request()->all();

        $scout_val = $this->validateData($scout_data);

        if(isset($scout_val))
            return $scout_val;

        $same_emails = $this->checkForSameEmailsSimple($scout_data); 
        if($same_emails->isNotEmpty())
            return $this->errorProcedure("O email " .$same_emails->first()->email . " já se encontra registado no sistema");

        $scout = $this->registerScout($scout_data);

        if($scout !=NULL){
            session()->flash('message','O teu registo foi efetuado com sucesso, receberás um email com o resultado da revisão feita pelo administrador');
            return redirect("/start#toregister");
        }else{
            return $this->defaultErrorProcedure();
        }
    }

    public function create(Request $request)
    {

        $reg_request = new RegistrationRequest;

        $reg_request->name = $request->name;
        $reg_request->birthdate = $request->birthdate;
        $reg_request->email = $request->email;
        $reg_request->description = $request->description;
        $reg_request->password = $request->password;

        $reg_request->save();
        
    }

  
    public function createWithParent(){

        
        $scout = request()->all();
        $parent =session()->pull('son_registration');
        
        if(!isset($parent))
            return $this->defaultErrorProcedure();

        $same_emails = $this->checkForSameEmailsWithParent($scout,$parent); 
        if($same_emails->isNotEmpty())
            return $this->errorProcedure("O email " .$same_emails->first()->email . " já se encontra registado no sistema");

        $scout_val = $this->validateData($scout);
        $parent_val = $this->validateData($parent);
        
        if(isset($parent_val))
            return $parent_val;
        else if(isset($scout_val))
            return $scout_val;  


        $scout_instance = $this->registerScoutSimple($scout);

        if($scout_instance == NULL)
            return $this->errorProcedure("Erro ao inserir o escuteiro no sistema, por favor tente novamente e contacte o administrador");


        $parent_instance = $this->registerParent($parent,$scout_instance);

        if($parent_instance == NULL){
            $scout_instance->delete();
            return $this->errorProcedure("Erro ao inserir o encarregado de educação no sistema, por favor tente novamente e contacte o administrador");
        }


        session()->flash('message','O teu registo foi efetuado com sucesso, receberás um email com o resultado da revisão feita pelo administrador');
        return redirect('/start');

        
    }

    public function validateData($request){

        $validator = $this->validator($request);

        if($validator->fails())
            return redirect("/start#toregister")->withErrors($validator)->withInput();
        
        
        if($request['password_confirmation'] !== $request['password']){
            $validator->getMessageBag()->add('password_confirmation', 'As passwords não são iguais, por favor tente novamente');
            return redirect("/start#toregister")->withErrors($validator);
        }
        
    }

    public function registerScout($request){
        
        $scout = $this->registerScoutSimple($request);

        return  $scout;
    }

    public function registerScoutSimple($request){
        $data= request()->all();

        return RegistrationRequest::create([
            'name' => $data['name'],
            'birthdate' =>$data['birthdate'],
            'email' => $data['email'],
            'description' => $data['description'],
            'password' => bcrypt($data['password']),
        ]);
    }



    public function registerParent($request, $scout){
        $data= request()->all();
        $data['minor'] = $scout->id;

        return RegistrationRequestGuardian::create([
            'minor' => $data['minor'],
            'g_name' => $data['name'],
            'g_birthdate' =>$data['birthdate'],
            'g_email' => $data['email'],
            'g_description' => $data['description'],
            'g_password' => bcrypt($data['password']),
        ]);
    }
    public function defaultErrorProcedure(){
        session()->flash('message','Ocorreu um erro inesperado durante o registo, por favor tente novamente');
        return  redirect('/start#toregister');
    }

    public function errorProcedure($message){
        session()->flash('message',$message);
        return  redirect('/start#toregister');
    }

    public function checkForSameEmailsWithParent($scout,$parent){
        $from_users =  collect(DB::select('Select email from "user" where email = ? or email=?;', array($scout['email'],$parent['email'])));
        $from_registrations_scouts = collect(DB::select('Select email from registration_request where email = ? or email=?;', array($scout['email'],$parent['email'])));
        $from_registrations_parents = collect(DB::select('Select g_email as email from registration_request_guardian where g_email = ? or g_email=?;', array($scout['email'],$parent['email'])));

        return $from_users->concat($from_registrations_scouts)->concat($from_registrations_parents);
    }

    public function checkForSameEmailsSimple($scout){
        $from_users =  collect(DB::select('Select email from "user" where email = ?', array($scout['email'])));
        $from_registrations_scouts = collect(DB::select('Select email from registration_request where email = ? ;', array($scout['email'])));

        return $from_users->concat($from_registrations_scouts);
    }



}
