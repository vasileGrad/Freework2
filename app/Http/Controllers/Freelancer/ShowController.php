<?php

namespace App\Http\Controllers\Freelancer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Job;
use Auth;
use DB;

class ShowController extends Controller
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
        //

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
    public function show($id)
    {
        //dd($id);
        //$job = Job::find($id);
        $job = DB::table('job_saved')->leftJoin('users', 'users.id', '=', 'job_saved.user_id')
                                     ->leftJoin('jobs', 'jobs.id', '=', 'job_saved.jobId')
                                     ->leftJoin('clients', 'clients.id', '=', 'jobs.clientId')
                                     ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                     ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'clients.firstName', 'clients.country')
                                     ->where('users.id', Auth::user()->id)->get(); // 5 is the number of

        $count = DB::table('job_saved')->leftJoin('users', 'job_saved.userId', '=', 'users.id')
                                    ->where([['users.id', Auth::user()->id], ['job_saved.jobId', '=', $id]])->count('jobId'); 
        //dd($jobs);

        //return redirect()->route('jobShow.show', $count);

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
}
