<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {



        $data = $request->request->all();

        //TO-DO adicionar maneira de ser responsável ou não
        if($data['options'] == 'guardian') {
            $request->request->add([
                'is_guardian' => true,
                'is_responsible' =>true
                ]);
        }else{
            $request->request->add([
                'is_guardian' => false,
                'is_responsible' =>true
            ]);
        }

        //TO-DO Descrição

        $request->request->add([
            'description' => 'Descrição predefinida',
            'deactivated' => false]);


        $this->validator(request()->all())->validate();

        $user = $this->create(request()->all());

        auth()->login($user);


        return redirect($this->redirectTo);

    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'birthdate' => 'required|date',
            'is_responsible' => 'required|boolean',
            'is_guardian' => 'required|boolean',
            'description' => 'required|string',
            'deactivated' => 'required|boolean',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'name' => $data['name'],
            'birthdate' => $data['birthdate'],
            'is_responsible' => $data['is_responsible'],
            'is_guardian' => $data['is_guardian'],
            'description' => $data['description']
        ]);
    }
}
