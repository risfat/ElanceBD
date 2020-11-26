<?php
/**
 * Class RegisterController
 *
  
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com
 */
namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use App\Helper;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Session;

/**
 * Class RegisterController
 *
 */
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
    protected $redirectTo = '/login';


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
     * Validate user input.
     *
     * @param mixed $request Request Attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator, 'register');
        } else {
            event(new Registered($user = $this->create($request->all())));
            $json['type'] = 'success';
            return $json;
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data return data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [

            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $request returns request
     *
     * @return \App\User
     */
    protected function create($request)
    {

        $user = new User();
        $random_number = Helper::generateRandomCode(4);
        $verification_code = strtoupper($random_number);
        $user_id = $user->storeUser($request, $verification_code);
        session()->put(['user_id' => $user_id]);
        session()->put(['email' => $request['email']]);
        session()->put(['password' => $request['password']]);
        $json['type'] = 'success';
        return $json;
    }
}
