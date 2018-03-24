<?php

namespace App\Http\Controllers\Freelancer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use Auth;
use DB;

class JobSavedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //dd('heloooo');
        $jobs = DB::table('job_saved')->leftJoin('jobs', 'jobs.id', '=', 'job_saved.job_id')
                                     ->leftJoin('clients', 'clients.id', '=', 'jobs.clientId')
                                     ->leftJoin('users', 'users.id', '=', 'clients.user_id')
                                     ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                     ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'users.firstName', 'users.country')
                                     ->where('users.id', Auth::user()->id)->get(); // 5 is the number of


        //dd(count($jobs)); 
        return view('freelancerPages.jobSaved', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $jobId)
    {
        $user = new User();
        $user->id = Auth::user()->id;
        //$user->jobs()->sync($jobId, false);
        //$user->jobs()->toggle($jobId);
        /*$job_saved = DB::table('users')->leftJoin('freelancers', 'users.id', '=', 'freelancers.user_id')
                                 ->leftJoin('job_saved', 'job_saved.freelancer_id', '=', 'freelancers.id')
                                 ->leftJoin('jobs', 'jobs.id', '=', 'job_saved.job_id')
                                 ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                 ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'users.firstName', 'users.country')
                                 ->where('users.id', $user->id)->get(); // 5 is the number of*/

        $jobs = DB::table('job_saved')->leftJoin('jobs', 'jobs.id', '=', 'job_saved.job_id')
                                 ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                 ->leftJoin('freelancers', 'freelancers.user_id', '=', 'job_saved.freelancer_id')
                                 ->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
                                 ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'users.firstName', 'users.country')
                                 ->where('users.id', $user->id)->get(); // 5 is the number of

        //dd($job_saved);
        return view('freelancerPages.jobSaved', compact('jobs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the post item
       
    }
}
