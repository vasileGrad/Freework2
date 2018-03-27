<?php

namespace App\Http\Controllers\Freelancer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\JobSaved;
use Auth;
use DB;

class JobController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:freelancer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobSaved()
    {
        $jobs = DB::table('job_saved')->leftJoin('jobs', 'jobs.id', '=', 'job_saved.job_id')
                                     ->leftJoin('clients', 'clients.id', '=', 'jobs.clientId')
                                     ->leftJoin('users', 'users.id', '=', 'clients.user_id')
                                     ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                     ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'users.firstName', 'users.country')
                                     ->where('job_saved.freelancer_id', Auth::user()->id)
                                     ->paginate(5); 

        return view('freelancerPages.findWork.jobSaved', compact('jobs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function jobShow($id)
    {
        $job = DB::table('job_saved')->leftJoin('users', 'users.id', '=', 'job_saved.user_id')
                                     ->leftJoin('jobs', 'jobs.id', '=', 'job_saved.jobId')
                                     ->leftJoin('clients', 'clients.id', '=', 'jobs.clientId')
                                     ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                     ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'clients.firstName', 'clients.country')
                                     ->where('users.id', Auth::user()->id)
                                     ->get(); // 5 is the number of

        $count = DB::table('job_saved')->leftJoin('users', 'job_saved.userId', '=', 'users.id')
                                    ->where([
                                        ['users.id', Auth::user()->id], 
                                        ['job_saved.jobId', '=', $id]
                                    ])
                                    ->count('jobId'); 

        return view('freelancerPages.jobShow')->withCount($count)->withJob($job);
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
        //
    }

/* #######################################################################*/
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $jobs = DB::table('job_saved')->leftJoin('jobs', 'jobs.id', '=', 'job_saved.job_id')
                                     ->leftJoin('clients', 'clients.id', '=', 'jobs.clientId')
                                     ->leftJoin('users', 'users.id', '=', 'clients.user_id')
                                     ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                     ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'users.firstName', 'users.country')
                                     ->where('job_saved.freelancer_id', Auth::user()->id)
                                     ->get(); 

        return view('freelancerPages.findWork.jobSaved', compact('jobs'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveJob(Request $request, $jobId)
    {
        $job_saved = new JobSaved();
        $job_saved->freelancer_id = Auth::user()->id;
        $job_saved->job_id = $jobId;

        $job_saved->save();

        //Session::flash('success', 'The job was successfully saved!');
        // Redirect to another Controller
        return redirect()->action('Freelancer\SearchController@jobShow', $jobId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unsaveJob($jobId)
    {
        DB::table('job_saved')->where([
                                ['job_saved.job_id', '=', $jobId],
                                ['job_saved.freelancer_id', '=', Auth::user()->id]
                            ])->delete();

        //Session::flash('success', 'The job was successfully unsaved!');

        return redirect()->action('Freelancer\SearchController@jobShow', $jobId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = DB::table('job_saved')->leftJoin('users', 'users.id', '=', 'job_saved.user_id')
                                     ->leftJoin('jobs', 'jobs.id', '=', 'job_saved.jobId')
                                     ->leftJoin('clients', 'clients.id', '=', 'jobs.clientId')
                                     ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                     ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'clients.firstName', 'clients.country')
                                     ->where('users.id', Auth::user()->id)->get(); // 5 is the number of

        $count = DB::table('job_saved')->leftJoin('users', 'job_saved.userId', '=', 'users.id')
                                    ->where([
                                        ['users.id', Auth::user()->id], 
                                        ['job_saved.jobId', '=', $id]
                                    ])
                                    ->count('jobId'); 
                                    
        return view('freelancerPages.jobShow')->withCount($count)->withJob($job);
    }

}
