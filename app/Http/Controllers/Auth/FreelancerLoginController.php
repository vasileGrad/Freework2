<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\User;
use Auth;


class FreelancerLoginController extends Controller
{
    public function __construct()
	{
		$this->middleware('guest:freelancer');
	}

    public function showLoginForm()
    {
    	return view('auth.freelancer-login');
    }

    public function login(Request $request)
    {
    	// Validate the form data
    	$this->validate($request, [
    		'email' 	=> 'required|email',
    		'password' 	=> 'required|min:4'
    	]);

        $user = User::where('email', '=', $request->email)
                    ->orWhere('password', '=', $request->password)->first();
        //dd($user->role_id);
        if($user->role_id == 2){
            //The attempt method accepts an array of key / value pairs as its first argument. The values in the array will be used to find the user in your database table.

            // guard('admin') - will run in the Admin Model instead of User Model
            // Auth::guard('admin')->attempt($credentials, $remember)

            if (Auth::guard('freelancer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))  {
                // If successful, then redirect to their intended location
                return redirect()->intended(route('freelancer.dashboard'));

                // The intended method on the redirector will redirect the user to the URL they were attempting to access before being intercepted by the authentication middleware. A fallback URI may be given to this method in case the intended destination is not available.
            }

        }

        //Session::flash('errors', "You don't have a client account!");
        //dd($user->role_id);
    	// If unsuccessful, then redirect back to the login with the form data

    	// back() - this will send to the page that we were at before which should be the login page
		return redirect()->back()->withInput($request->only('email', 'remember')); // withInput will fill back the fields
    }
}
