<?php

namespace App\Http\Controllers\Freelancer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Proposal;
use App\Job;
use Auth;
use DB;

class ProposalController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth:freelancer');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freelancer = DB::table('freelancers')->where('freelancers.user_id', '=', Auth::user()->id)
                                                ->select('freelancers.id')
                                                ->first(); 

        $proposals = DB::table('proposals')->leftJoin('jobs', 'proposals.job_id', '=', 'jobs.id')
                                    ->select('jobs.title', 'proposals.id', 'proposals.created_at')
                                    ->where('proposals.freelancer_id','=', $freelancer->id)
                                    ->get();
                                    
        //dd($proposals);  
        return view('freelancerPages.Proposal.proposals', compact('proposals'));                              
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProposal(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $job = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                            ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                            ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                            ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                            ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                            ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                            ->select('users.firstName', 'users.country', 'users.location', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.statusActiv','jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                            ->where([
                                ['jobs.id', '=', $id],
                                ['jobs.statusActiv', '=', 1]
                            ])
                            ->first(); 

        //dd($job);
        return view('freelancerPages.Proposal.createProposal', compact('job'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProposal(Request $request, $id)
    {
        $this->validate($request, array(
            'body'    => 'required|min:5|max:2000'
        ));

        $freelancer = DB::table('freelancers')->where('freelancers.user_id', '=', Auth::user()->id)
                                                ->select('freelancers.id')
                                                ->first();
        //dd($freelancer_id);

        $job = DB::table('jobs')->select('jobs.paymentAmount', 'jobs.paymentTypeId')
                                ->where('jobs.id', '=', $id)
                                ->first();

        $proposal = new Proposal;
        $proposal->job_id = $id;
        //$proposal->freelancer_id = Auth::user()->id;
        $proposal->freelancer_id = $freelancer->id;
        $proposal->payment_type_id = $job->paymentTypeId;
        $proposal->payment_amount = $job->paymentAmount;
        $proposal->current_proposal_status = 1;
        $proposal->freelancer_comment = $request->body;

        //dd($proposal);

        $proposal->save();

        //Session::flash('success', 'Your proposal was submitted!');

        return Redirect()->route('freelancerProposal.show', [$proposal->id]);

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
        $job = DB::table('proposals')->leftJoin('proposal_status_catalog', 'proposals.current_proposal_status', '=', 'proposal_status_catalog.id')
                                    ->leftJoin('payment_type', 'proposals.payment_type_id', '=', 'payment_type.id')
                                    ->leftJoin('jobs', 'proposals.job_id', '=', 'jobs.id')
                                    ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                    ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                    ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                    ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                    ->select('proposal_status_catalog.statusName', 'payment_type.paymentName', 'proposals.job_id', 'proposals.payment_amount', 'proposals.freelancer_comment', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName')
                                    ->where('proposals.id','=', $id)
                                    ->first();

        //dd($job->job_id);
        $job_skills = DB::table('jobs')->leftJoin('job_skill', 'jobs.id', '=', 'job_skill.job_id')
                                    ->leftJoin('skills', 'job_skill.skill_id', '=', 'skills.id')
                                    ->select('skills.skillName')
                                    ->where([
                                        ['jobs.id', '=', $job->job_id],
                                        ['jobs.statusActiv', '=', 1]
                                    ])->get();
        
        $client = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                ->select('clients.id','users.firstName', 'users.lastName', 'users.country', 'users.location', 'users.created_at')
                                ->where('jobs.id', '=', $job->job_id)
                                ->first();
        //dd($client);
        $count_jobs = DB::table('jobs')->where([
                                        ['jobs.clientId', '=', $client->id],
                                        ['jobs.statusActiv', '=', 1]
                                    ])
                                    ->count();
        $proposals_job = DB::table('proposals')->where('proposals.job_id', '=', $job->job_id)
                                                ->count();
        //dd([$job,$client,$count_jobs]); 
         return view('freelancerPages.Proposal.showProposal', compact(['job','client','count_jobs','job_skills','proposals_job']));
    }


    /**
     * Redirect back.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function goBackProposals() {
        return Redirect()->route('freelancerProposal.index');
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
