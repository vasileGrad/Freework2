<?php

namespace App\Http\Controllers\Freelancer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Job;
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
        $jobs = DB::table('users')->leftJoin('jobSaved', 'jobSaved.freelancerId', '=', 'users.id')
                                 ->leftJoin('jobs', 'jobs.id', '=', 'jobSaved.jobId')
                                 ->leftJoin('clients', 'clients.id', '=', 'jobs.clientId')
                                 ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                 ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'clients.firstName', 'clients.country')
                                 ->where('users.id', Auth::user()->id)->get(); // 5 is the number of

        //dd($jobs);
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
        //dd(Auth::user()->id);
        //dd($jobId);

        $jobs = new Job();
        

        $jobs = DB::table('users')->leftJoin('jobSaved', 'jobSaved.freelancerId', '=', 'users.id')
                                 ->leftJoin('jobs', 'jobs.id', '=', 'jobSaved.jobId')
                                 ->leftJoin('clients', 'clients.id', '=', 'jobs.clientId')
                                 ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                 ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'clients.firstName', 'clients.country')
                                 ->where('users.id', Auth::user()->id)->get(); // 5 is the number of


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
        //
    }
}
