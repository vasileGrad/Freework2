<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Job;
use DB;

class JobController extends Controller
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
     * Find specific job.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findJob()
    {	
    	$jobs = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                                ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                ->select('users.firstName', 'users.country', 'users.location', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                ->where('jobs.status', '=', 1)
                                ->orderBy('jobs.id','desc')
                                ->paginate(5);                      
        return view('adminPages.Jobs.findJob', compact('jobs'));
    }

    /**
     * Find specific job.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findJobFilter(Request $request)
    {
    	$search = $request->input('search');
        if($search != '')
            $keyword_job = $search;
        else
            $keyword_job = '';

       	$jobs = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                                ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                ->select('users.firstName', 'users.country', 'users.location', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                ->where([
                                	['jobs.status', '=', 1],
                                	['jobs.title', 'LIKE', '%'.$keyword_job.'%']
                                ])
                                ->orderBy('jobs.id','desc')
                                ->paginate(5); 
        return view('adminPages.Jobs.findJob', compact('jobs'));
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJob($id)
    {
    	$job = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                            ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                            ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                            ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                            ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                            ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                            ->select('users.firstName', 'users.country', 'users.location', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.status','jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                            ->where([
                            	['jobs.id', '=', $id],
                            	['jobs.status', '=', 1]
                            ])
                            ->first(); 

        $job_skills = DB::table('skills')->leftJoin('job_skill', 'skills.id', '=', 'job_skill.skill_id')
        								->leftJoin('jobs', 'job_skill.job_id', '=', 'jobs.id')
        								->select('skills.skillName')
        								->where('jobs.id', '=', $id)
        								->get();       							                        
        return view('adminPages.Jobs.showJob', compact('job','job_skills'));
    }

    /**
     * Display blocked job
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showBlockedJob($id)
    {
        $job = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                            ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                            ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                            ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                            ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                            ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                            ->select('users.firstName', 'users.country', 'users.location', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.status', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                            ->where([
                                ['jobs.id', '=', $id],
                                ['jobs.status', '=', 0]
                            ])
                            ->first(); 

        $job_skills = DB::table('skills')->leftJoin('job_skill', 'skills.id', '=', 'job_skill.skill_id')
                                        ->leftJoin('jobs', 'job_skill.job_id', '=', 'jobs.id')
                                        ->select('skills.skillName')
                                        ->where('jobs.id', '=', $id)
                                        ->get();                                                        
        return view('adminPages.Jobs.showJob', compact('job','job_skills'));
    }

    /**
     * Block specified job
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blockJob(Request $request, $id)
    {   
        $job = Job::find($id);
        $job->status = 0;
        $job->save();

        // Set flash data with success message
        Session::flash('success', 'This Job was successfully blocked!');
        
        return redirect()->route('findJob');
    }

    /**
     * Unblock specified job
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unblockJob(Request $request, $id)
    {   
        $job = Job::find($id);
        $job->status = 1;
        $job->save();

        // Set flash data with success message
        Session::flash('success', 'This Job was successfully unblocked!');
        // redirect with flash data to posts.show
        return redirect()->route('blockedJobs');
    }


    /**
     * Find blocked jobs.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blockedJobs()
    {   
        $jobs = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                                ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                ->select('users.firstName', 'users.country', 'users.location', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                ->where('jobs.status', '=', 0)
                                ->orderBy('jobs.id','desc')
                                ->paginate(5);

        return view('adminPages.Jobs.blockedJobs', compact('jobs'));
    }

    /**
     * Find specific job.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blockedJobsFilter(Request $request)
    {
        $search = $request->input('search');
        if($search != '')
            $keyword_job = $search;
        else
            $keyword_job = '';

        $jobs = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                                ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                ->select('users.firstName', 'users.country', 'users.location', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                ->where([
                                    ['jobs.status', '=', 0],
                                    ['jobs.title', 'LIKE', '%'.$keyword_job.'%']
                                ])
                                ->orderBy('jobs.id','desc')
                                ->paginate(5); 
        return view('adminPages.Jobs.blockedJobs', compact('jobs'));
    }
}
