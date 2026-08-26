<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone'=>['required','digits_between:10,11'],
            'profile'=>['required','image','mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        $profilePath=null;
        if(isset($data['profile'])){
            $fileName=time().'.'.$data['profile']->extension();
            $data['profile']->move(public_path('images/profiles/'),$fileName);
            $profilePath="/images/profiles/".$fileName;
        }
        return User::create([
            'name' => $data['name'],
            'phone'=>$data['phone'],
            'profile'=>$profilePath,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role'=>'User',
        ]);
    }
}
//Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
