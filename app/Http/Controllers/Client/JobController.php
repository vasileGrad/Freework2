<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Complexity;
use App\ExpectedDuration;
use App\PaymentType;
use App\Level;
use App\Skill;
use App\Job;
use App\Upload;
use Storage;
use Session;
use Purifier;
use File;
use Auth;
use DB;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = DB::table('jobs')->leftJoin('clients', 'clients.id', '=', 'jobs.clientId')
                                 ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                 ->leftJoin('category', 'category.id', '=', 'jobs.categoryId')
                                 ->leftJoin('complexity', 'complexity.id', '=', 'jobs.complexityId')
                                 ->leftJoin('expected_duration', 'expected_duration.id', '=', 'jobs.expectedDurationId')
                                 ->leftJoin('levels', 'levels.id', '=', 'jobs.levelId')
                                 ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                 ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                 ->where('users.id', Auth::user()->id)
                                 ->orderBy('jobs.created_at', 'desc')
                                 ->paginate(5); // 5 is the number of
        return view('clientPages.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $complexities = Complexity::all();
        $durations = ExpectedDuration::all();
        $payments = PaymentType::all();
        $levels = Level::all();
        $skills = Skill::all();

        return view('clientPages.jobs.create')->withCategories($categories)
                                 ->withComplexities($complexities)
                                 ->withDurations($durations)
                                 ->withPayments($payments)
                                 ->withLevels($levels)
                                 ->withSkills($skills);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clientId = DB::table('users')->leftJoin('clients', 'users.id', 'clients.user_id')
                                      ->where([
                                            ['users.id', Session::get('AuthUser')],
                                            ['users.role_id', 3]
                                        ])->first();

        // 1. Validate the data
        $this->validate($request, array(
            // rules 
            'title'                 => 'required|min:5|max:255',
            'description'           => 'required',
            'nrFreelancers'         => 'required|integer|min:1|max:10',
            'categoryId'            => 'required|integer',
            'complexityId'          => 'required|integer',
            'expectedDurationId'    => 'required|integer',
            'paymentTypeId'         => 'required|integer',
            'paymentAmount'         => 'required|integer|min:5|max:1000000',
            'levelId'               => 'required|integer',
            'files.*'               => 'sometimes|required|mimes:pdf,png,jpg,jpeg,gif,doc,docx,ods,sql,txt,zip|max:4000'
        )); // validate the request

        // if the data is not valid what it does? Jumps back to the Create() action and will post the errors

        // 2. store in the database
        
        // create a new instance of a Job Model
        $job = new Job;

        // adding things to this brand new object to be created 
        //$job->title = $request->title;
        $job->title = $request->title;
        $job->nrFreelancers = $request->nrFreelancers;
        $job->categoryId = $request->categoryId;
        $job->complexityId = $request->complexityId;
        $job->clientId = $clientId->id;
        $job->expectedDurationId = $request->expectedDurationId;
        $job->paymentTypeId = $request->paymentTypeId;
        $job->paymentAmount = $request->paymentAmount;
        $job->levelId = $request->levelId;

        // we use Purifier to clean and secure
        $job->description = Purifier::clean($request->input('description'));

        $job->save(); // save the object
        // save the new item into the Database
        // this job it's gonna give us an id number
        //dd(count($request->skills) !=0);

        $job->skills()->sync($request->skills, false);

        $files = $request->file('files');
        if(!empty($files)){
            foreach ($files as $file){
                //dd($file);
                $filename = time() . '.' . $file->getClientOriginalName();
                //$location = public_path('uploads/' . $filename);
                $location = 'uploads';
                //$file->move($location, $filename);
                Storage::put($filename, file_get_contents($file));

                DB::table('uploads')->insert([
                    'job_id' => $job->id, 
                    'fileName' => $filename,
                ]);
            } 
        }
        
        // $request->tags - is the id of the post
        // false - telling to overide the existing association. If you forget to write false it will delete all and set these as a new association. We want to add them !!!!!!
        // sync - creates that relationship and sync it up

        // If we successfully saved this into the database I wonna be able to pass this to the user
        //Session::flash('key', 'value'); // Creates a flass variable that OR a session that exists for a single request
        // the 'key' - when we try to  reference it
        // the 'value' - this will be the message you want to output 
        Session::flash('success', 'The job was successfully saved!');

        // 3. redirect to another page : show() or index()
        //return redirect()->route('inviteFreelancers');  
        //dd($job->id);
        return Redirect()->route('inviteFreelancers', ['id' => $job->id]); // invite Freelancers
        //return redirect()->route('jobs.show', $job->id); // redirect to the named post called posts.show
        // grab the id from the $post->id of the post object
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $job_id
     * @return \Illuminate\Http\Response
     */
    public function inviteFreelancers($job_id)
    {   
        $job = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                                ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                ->leftJoin('job_skill', 'jobs.id', '=', 'job_skill.job_id')
                                ->leftJoin('skills', 'job_skill.skill_id', '=', 'skills.id')
                                ->select('users.firstName','users.country', 'users.location', 'jobs.id as jobId', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName','skills.skillName')
                                ->where('jobs.id', $job_id)
                                ->first();

        $freelancers = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')
                                ->leftJoin('freelancer_skill','freelancers.id','freelancer_skill.freelancer_id')
                                ->leftJoin('skills','freelancer_skill.skill_id','skills.id')
                                ->select('users.id','users.firstName', 'users.lastName','users.image','users.title','users.description','freelancers.hourlyRate','users.location','users.country')
                                ->where([
                                    ['users.role_id',2],
                                    ['users.statusActiv','!=',0],
                                    ['skills.skillName','=','$job->skillName']
                                ])
                                ->orderBy('freelancers.id','desc')
                                ->paginate(3);
        $countFreelancers = 0;
        foreach ($freelancers as $freelancer) {
            if($freelancer->id)
                $countFreelancers++;
        }

        if($countFreelancers == 0){
            $freelancers = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')
                                ->select('users.id','users.firstName', 'users.lastName','users.image','users.title','users.description','freelancers.hourlyRate','users.location','users.country')
                                ->where([
                                    ['users.role_id',2],
                                    ['users.statusActiv','!=',0]
                                ])
                                ->orderBy('freelancers.id','desc')
                                ->distinct()
                                ->paginate(3);
        }

        $skills = DB::table('skills')->leftJoin('job_skill','skills.id','job_skill.skill_id')
                                     ->select('skills.id','skills.skillName')
                                     ->where('job_skill.job_id',$job_id)
                                     ->get();

        return view('clientPages.jobs.inviteFreelancers', compact('job_id','freelancers','skills'));
    }

    /**
     * Download a specific file_name
     *
     * @param  int  $file_name
     * @return \Illuminate\Http\Response
     */
    public function downloadFileClient($file_name) {
        return Storage::download($file_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $job = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                                ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                ->select('users.firstName','users.country', 'users.location', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                ->where('jobs.id', $id)
                                ->first();

        $job_skills = DB::table('jobs')->leftJoin('job_skill', 'jobs.id', '=', 'job_skill.job_id')
                                    ->leftJoin('skills', 'job_skill.skill_id', '=', 'skills.id')
                                    ->select('skills.skillName')
                                    ->where([
                                        ['jobs.id', '=', $id],
                                        ['jobs.statusActiv', '=', 1]
                                    ])->get();

        $freelancer_proposals = DB::table('proposals')->leftJoin('freelancers', 'proposals.freelancer_id', '=', 'freelancers.id')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
                                        ->select('users.id as userId','users.firstName', 'users.lastName', 'proposals.created_at','proposals.id')
                                        ->whereNull('proposals.client_id')
                                        ->where('proposals.job_id', '=', $id)
                                         ->get(); 

        $freelancer_invitations = DB::table('proposals')->leftJoin('freelancers', 'proposals.freelancer_id', '=', 'freelancers.id')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
                                        ->select('users.id as userId','users.firstName', 'users.lastName', 'proposals.created_at','proposals.id')
                                        ->where([
                                            ['proposals.job_id', '=', $id],
                                            ['proposals.client_id','!=','']
                                        ])
                                         ->get();   
        $uploads = DB::table('uploads')->where('uploads.job_id', $job->id)
                                       ->select('uploads.fileName')->get();
        //dd([count($job_skills),$job_skills,$id,$freelancer_proposals,$uploads]);
        return view('clientPages.jobs.show', compact('job','job_skills','freelancer_proposals','freelancer_invitations','uploads'));
    }

    /**
     * Show proposal info
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProposal($id) {
        $job = DB::table('proposals')->leftJoin('proposal_status_catalog', 'proposals.current_proposal_status', '=', 'proposal_status_catalog.id')
                                    ->leftJoin('payment_type', 'proposals.payment_type_id', '=', 'payment_type.id')
                                    ->leftJoin('jobs', 'proposals.job_id', '=', 'jobs.id')
                                    ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                    ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                    ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                    ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                    ->select('proposal_status_catalog.statusName', 'payment_type.paymentName', 'proposals.job_id', 'proposals.payment_amount', 'proposals.current_proposal_status', 'proposals.freelancer_comment', 'proposals.client_comment', 'proposals.client_id', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName')
                                    ->where('proposals.id','=', $id)
                                    ->first();

        $job_skills = DB::table('jobs')->leftJoin('job_skill', 'jobs.id', '=', 'job_skill.job_id')
                                    ->leftJoin('skills', 'job_skill.skill_id', '=', 'skills.id')
                                    ->select('skills.skillName')
                                    ->where([
                                        ['jobs.id', '=', $job->job_id],
                                        ['jobs.statusActiv', '=', 1]
                                    ])->get();
        
        $freelancer = DB::table('proposals')->leftJoin('freelancers', 'proposals.freelancer_id', '=', 'freelancers.id')
                                ->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
                                ->select('users.id as userId','users.firstName', 'users.lastName', 'users.country', 'users.location', 'users.created_at','proposals.id as proposalId')
                                ->where('proposals.id', '=', $id)
                                ->first();

        $proposals_job = DB::table('proposals')->where('proposals.job_id', '=', $job->job_id)
                                                ->count();

        return view('clientPages.jobs.showProposal', compact('job','job_skills','freelancer','proposals_job'));
    }

    /**
     * Return back to the proposal
     *
     * @return \Illuminate\Http\Response
     */
    public function goBackProposal($id) {
        return Redirect()->route('jobs.show', ['id' => $id]);
    }

    /**
     * Return back to the jobs list
     *
     * @return \Illuminate\Http\Response
     */
    public function goBackJobs() {
        return Redirect()->route('jobs.index');
    }

    /**
     * Display all the jobs that are in progress
     *
     * @param  int  $id - user_id
     * @return \Illuminate\Http\Response
     */
    public function workProgress($id) {
        // all the contracts finished
        $contracts = DB::table('contracts')->leftJoin('proposals', 'contracts.proposalId', 'proposals.id')
                ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                ->rightJoin('freelancers', 'proposals.freelancer_id', 'freelancers.id')
                ->rightJoin('users', 'freelancers.user_id', 'users.id')
                ->select('jobs.id as jobId','jobs.title', 'users.id as userId','users.firstName', 'users.lastName', 'users.image','contracts.id as contractId','contracts.startTime', 'contracts.paymentAmount')
                ->where([
                    ['contracts.clientId', '=', $id],
                    ['contracts.endTime', '=', null]
                ])
                ->orderBy('contracts.startTime', 'desc')
                ->paginate(5);

        //dd($contracts);
        return view('clientPages.jobs.workProgress', compact('contracts'));
    }

    /**
     * Display all the jobs done
     *
     * @param  int  $id - user_id
     * @return \Illuminate\Http\Response
     */
    public function contracts($id) {
        // all the contracts finished
        $contracts = DB::table('contracts')->leftJoin('proposals', 'contracts.proposalId', 'proposals.id')
                ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                ->rightJoin('freelancers', 'proposals.freelancer_id', 'freelancers.id')
                ->rightJoin('users', 'freelancers.user_id', 'users.id')
                ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                ->select('jobs.id as jobId','jobs.title','users.id as userId', 'users.firstName', 'users.lastName', 'users.image','contracts.id as contractId','contracts.startTime', 'contracts.endTime', 'contracts.paymentAmount','reviews.reviewClient','rateClient')
                ->where([
                    ['contracts.clientId', '=', $id],
                    ['contracts.endTime', '!=', '']
                ])
                ->orderBy('contracts.endtime', 'desc')
                ->paginate(5);

        return view('clientPages.jobs.contracts', compact('contracts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $job = Job::find($id);
        $job->delete();

        Session::flash('success', 'Job Deleted Successfully!');
        return Redirect()->route('jobs.index');
    }
}
