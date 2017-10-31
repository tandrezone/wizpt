<?php

namespace wizpt\cms\Traits\Auth;

use View;
use Session;
use wizpt\cms\Models\AdminUser;
use wizpt\cms\Models\AdminRole;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

trait WizRegistersUsers
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
     * Where to redirect users after registration.
     *
     * @var string
     */
    public function redirectTo(){
        Session::flash('success', "Utilizador criado com sucesso!");
        return '/register';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'access_level' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Show the application create user form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $request->user()->authorize(['Administrator']);
        $roles = AdminRole::all();
        return View::make('auth.register')
                ->with('roles',$roles);
    }

    /**
     * Handle a create user request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->user()->authorize(['Administrator']);
        $this->validator($request->all());
        $user = $this->createUser($request->all());
        event(new Registered($user));
        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\AdminUser
     */
    protected function createUser(array $data)
    {
        //dd($data['role_id']);
        return AdminUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' =>  $data['role_id'],
        ]);
    }
}
