<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\School;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function store(Request $request)
    {/*
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'school_id' => $request->input('school-id'),
            'password' => bcrypt($data['password']),
        ]);*/

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'school-id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('auth/register')
                ->withErrors($validator, 'errors')
                ->withInput();
        }
        else{
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->school_id = $request->input('school-id');
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return redirect('/');
        }
    }

    /**
     * show the reigster page with schools list
     */
    public function show(){
        $schools = School::all();

        return view('auth.register')->withSchools($schools);
    }
}
