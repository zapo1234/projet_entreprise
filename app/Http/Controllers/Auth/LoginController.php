<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * login Auth
     * @return 
     */

    public function login(Request $request)
    {
       $input = $request->all();
       $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
       ]);

        if(auth()->attempt(array('email' => $input['email'], 'password' =>$input['password'])))
        {
            if(auth()->user()->is_admin == 1)
            {
               return redirect()->route('superadmin.home');
            }

            elseif(auth()->user()->is_admin == 2)
            {
              return redirect()->route('amabassadirece.user');
            }
            
            elseif(auth()->user()->is_admin == 3)
            {
                return redirect()->route('comptable.comptas');
            }
            
            else
            {
                return redirect()->route('other.users');
            }
        }
        else
        {
           return redirect()->route('login')->with('error','Identifiants incorrectes !');
        }
       
    }

    /**
     * Create a new controller instance.
     * redirigé user après logout vers la route login
     * @return void
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('login');
    }
}
