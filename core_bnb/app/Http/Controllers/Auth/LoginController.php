<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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


    //-------------------------------------------------------------------------------------------
    //  This method was added to override the trait with the same method as we do not want the
    //  redirect that was in place to redirect if the attempt to login came from the front end 
    //  we only want it to redirect if the request came from the backend of the application
    //
    protected function authenticated(Request $request, $user)
    {
        if ($request->isXmlHttpRequest()) {
            return response(null, 204);
        }
    }
    //-------------------------------------------------------------------------------------------


    //-------------------------------------------------------------------------------------------
    //  This method was added to override the trait with the same method as we do not want the
    //  redirect that was in place to redirect if the attempt to login came from the front end 
    //  we only want it to redirect if the request came from the backend of the application
    //
    protected function loggedOut(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            return response(null, 204);
        }
    }
    //-------------------------------------------------------------------------------------------
}
