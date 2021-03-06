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

        return view('freelancerPages.jobShow', compact('count','job'));
    }

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

        Session::flash('success', 'The job was successfully saved!');
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

        Session::flash('success', 'The job was successfully unsaved!');

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
                                     ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                     ->leftJoin('category', 'jobs.categoryId', '=', 'categoryName')
                                     ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.complexityName')
                                     ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.paymentAmount', 'jobs.created_at', 'payment_type.paymentName', 'clients.firstName', 'clients.country','expected_duration.durationName','category.categoryName', 'complexity.complexityName')
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
     * Display the contracts for the that freelancer
     *
     * @param  int  $id - user_id
     * @return \Illuminate\Http\Response
     */
    public function contractsFinish($id) {

        $freelancerId = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                ->select('freelancers.id')
                ->where('users.id', '=', $id)
                ->first(); 

        // all the contracts finished
        $contracts = DB::table('contracts')->leftJoin('proposals', 'contracts.proposalId', 'proposals.id')
                ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                ->leftJoin('clients', 'jobs.clientId', 'clients.id')
                ->leftJoin('users', 'clients.user_id', 'users.id')
                ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                ->select('jobs.title', 'users.firstName', 'users.lastName', 'users.image','contracts.id','contracts.startTime', 'contracts.endTime', 'contracts.paymentAmount', 'reviews.rateClient', 'reviews.reviewClient'
                    )
                ->where([
                    ['contracts.freelancerId', '=', $freelancerId->id],
                    ['contracts.endTime', '!=', '']
                ])
                ->orderBy('contracts.endtime', 'desc')
                ->paginate(5);

        return view('freelancerPages.myJobs.contractsFinish', compact('contracts'));
    }

    /**
     * Display the jobs in progress
     *
     * @param  int  $id - user_id
     * @return \Illuminate\Http\Response
     */
    public function contractsNow($id) {
        $freelancerId = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                ->select('freelancers.id')
                ->where('users.id', '=', $id)
                ->first();

        // all the contracts finished
        $contracts = DB::table('contracts')->leftJoin('proposals', 'contracts.proposalId', 'proposals.id')
                ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                ->leftJoin('clients', 'jobs.clientId', 'clients.id')
                ->leftJoin('users', 'clients.user_id', 'users.id')
                ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                ->select('jobs.title', 'users.firstName', 'users.lastName', 'users.image','contracts.id','contracts.startTime', 'contracts.endTime', 'contracts.paymentAmount')
                ->where([
                    ['contracts.freelancerId', '=', $freelancerId->id],
                    ['contracts.endTime', '=', null]
                ])
                ->orderBy('contracts.endtime', 'desc')
                ->paginate(5);
                
        return view('freelancerPages.myJobs.contractsNow', compact('contracts'));
    }

    /**
     * Display business reports
     *
     * @param  int  $id - user_id
     * @return \Illuminate\Http\Response
     */
    public function earnings($id) {
        return view('freelancerPages.myJobs.earnings');
    }
}
