<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return freelancer last job searches
        $jobSearches = DB::table('job_search_history')->select('job_search_history.jobTitle')
                            ->orderBy('created_at','desc')->take(5)->get();
        //dd($jobSearches);

        return view('profiles.freelancer', compact('jobSearches'));
    }
}
