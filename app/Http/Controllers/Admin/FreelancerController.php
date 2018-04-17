<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class FreelancerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Find specific freelancers.
     *
     * @return \Illuminate\Http\Response
     */
    public function findFreelancers()
    {
    	$freelancersCount = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')->where('users.role_id', '=', 2)
            ->count();
        $freelancers = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
        	->select('users.firstName','users.lastName','users.location','users.country', 'users.image', 'users.title', 'users.description')
        	->where('users.role_id', '=', 2)
            ->orderBy('freelancers.id','desc')->get();

        dd([$freelancersCount,$freelancers]);

    	dd('222');
    }

    /**
     * Find specific freelancer.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findFreelancerFilter(Request $request)
    {
    	dd('heyyyy');
    	$search = $request->input('search');
        if($search != '')
            $keyword_job = $search;
        else
            $keyword_job = '';

    }

}
