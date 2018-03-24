<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profiles.admin');
    }

    /**
     * Find freelancers
     *
     * @return \Illuminate\Http\Response
     */
    public function findFreelancers()
    {
        return view('adminPages.findFreelancers');
    }

    /**
     * Find clients
     *
     * @return \Illuminate\Http\Response
     */
    public function findClients()
    {
        return view('adminPages.findClients');
    }

    /**
     * Find jobs
     *
     * @return \Illuminate\Http\Response
     */
    public function findJobs()
    {
        return view('adminPages.findJobs');
    }

}
