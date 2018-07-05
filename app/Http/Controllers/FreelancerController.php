<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
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
        $this->middleware('auth:freelancer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // return freelancer last job searches
        $jobSearches = DB::table('job_search_history')->select('job_search_history.jobTitle')
                            ->orderBy('created_at','desc')->take(5)->get();

        $skills = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')
                ->leftJoin('freelancer_skill','freelancers.id','freelancer_skill.freelancer_id')
                ->leftJoin('skills','freelancer_skill.skill_id','skills.id')
                ->select('skills.skillName')
                ->where('users.id', Session::get('AuthUser'))
                ->take(5)
                ->get();

        $freelancer = DB::table('users')->leftJoin('freelancers','users.id', 'freelancers.user_id')->select('freelancers.id')
                    ->where('users.id', Session::get('AuthUser'))
                    ->first();

        $proposals = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')
                    ->leftJoin('proposals','freelancers.id','proposals.freelancer_id')
                    ->where('proposals.freelancer_id',$freelancer->id)
                    ->count();

        $contracts = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')
                    ->leftJoin('proposals','freelancers.id','proposals.freelancer_id')
                    ->leftJoin('contracts','proposals.id','contracts.proposalId')
                    ->where([
                        ['contracts.freelancerId', $freelancer->id],
                        ['contracts.endTime', '!=', '']
                    ])
                    ->count();

        return view('profiles.freelancer', compact('jobSearches','skills','proposals','contracts'));
    }
}
