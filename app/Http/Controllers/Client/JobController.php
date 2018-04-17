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
        //$job2 = Job::all()->where('clientId', Auth::user()->id);
        //dd(Auth::user()->id);

        $jobs = DB::table('jobs')->leftJoin('clients', 'clients.id', '=', 'jobs.clientId')
                                 ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                 ->leftJoin('category', 'category.id', '=', 'jobs.categoryId')
                                 ->leftJoin('complexity', 'complexity.id', '=', 'jobs.complexityId')
                                 ->leftJoin('expected_duration', 'expected_duration.id', '=', 'jobs.expectedDurationId')
                                 ->leftJoin('levels', 'levels.id', '=', 'jobs.levelId')
                                 ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                 ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                 ->where('users.id', Auth::user()->id)->paginate(5); // 5 is the number of
        // 1. Selecteaza toate joburile salvate de freelancerul cu id= 4
        //$user_id = Auth::user()->id;
        //$jobs = DB::select('call saved_jobs_freelancer(?)', [$user_id]);
        //dd($jobs);
        
        // 2.   Selecteaza numele clientului care a postat jobul cu numele “Job 1”
        //$job_title = 'Java programmer'; 
        //$nume_client_job = DB::select('CALL nume_client_job(?)', [$job_title]);
        //dd($nume_client_job);


        //  3. Sa se afiseze toate joburile clientului cu numele “Client1”
        //$nume_client = 'Client1';  
        //$job_pentru_client = DB::select('CALL job_pentru_client(?)', [$nume_client]);
        //dd($job_pentru_client); 


        // 4. count_joburi_more_500
        //$count = DB::select("CALL numara_joburi_more_500()");
        //dd($count);

        //5. //delete
        //$job_title = 'Italian translation';
        //$job_title = DB::select('CALL delete_job(?)', [$job_title]);
        //dd($job_title);

        //6. // insert
       // $job_title = 'Job Job';
        //$job_insert = DB::select('CALL insert_job(?)', [$job_title]);
        //dd($job_insert);

        // 6. calculoaza_valoare_freelancer - Procedura matematica
        //$freelancer_nume = 'vasile';
        //$freelancer_email = 'vasile@gmail.com';
        //$valoare = DB::SELECT('CALL calculeaza_valoare_freelancer(?,?)', [$freelancer_nume, $freelancer_email]);
        //dd($valoare);



        //$skills = DB::table('skills')->leftJoin('job_skill', 'job_skill.skill_id', '=', 'skills.id')
                                     //->leftJoin('jobs', 'jobs.id', '=', 'job_skill.job_id')
                                     //->where('clientId', Auth::user()->id)->paginate(5); // 5 is the number of        
        //dd($skills);

        //return view('jobs.index', compact('jobs', 'skills'));
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
           'files.*'                 => 'sometimes|required|mimes:pdf,png,jpg,jpeg,gif,doc,docx,ods,sql,txt,zip|max:4000'
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
        return redirect()->route('jobs.show', $job->id); // redirect to the named post called posts.show
        // grab the id from the $post->id of the post object
    }

    /**
     * Download a specific file_name
     *
     * @param  int  $file_name
     * @return \Illuminate\Http\Response
     */
    public function downloadFileClient($file_name) {
        //dd($file_name);
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
        //dd($id);
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
                                        ->select('users.firstName', 'users.lastName', 'proposals.created_at','proposals.id')
                                        ->where('proposals.job_id', '=', $id)
                                         ->get();
        $uploads = DB::table('uploads')->where('uploads.job_id', $job->id)
                                       ->select('uploads.fileName')->get();

        //dd([count($job_skills),$job_skills,$id,$freelancer_proposals,$uploads]);

        return view('clientPages.jobs.show', compact('job','job_skills','freelancer_proposals','uploads'));
    }

    /**
     * Show proposal info
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProposal($id) {
        //dd($id);
        $job = DB::table('proposals')->leftJoin('proposal_status_catalog', 'proposals.current_proposal_status', '=', 'proposal_status_catalog.id')
                                    ->leftJoin('payment_type', 'proposals.payment_type_id', '=', 'payment_type.id')
                                    ->leftJoin('jobs', 'proposals.job_id', '=', 'jobs.id')
                                    ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                    ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                    ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                    ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                    ->select('proposal_status_catalog.statusName', 'payment_type.paymentName', 'proposals.job_id', 'proposals.payment_amount', 'proposals.current_proposal_status', 'proposals.freelancer_comment', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName')
                                    ->where('proposals.id','=', $id)
                                    ->first();

        //dd($job);
        $job_skills = DB::table('jobs')->leftJoin('job_skill', 'jobs.id', '=', 'job_skill.job_id')
                                    ->leftJoin('skills', 'job_skill.skill_id', '=', 'skills.id')
                                    ->select('skills.skillName')
                                    ->where([
                                        ['jobs.id', '=', $job->job_id],
                                        ['jobs.statusActiv', '=', 1]
                                    ])->get();
        
        $freelancer = DB::table('proposals')->leftJoin('freelancers', 'proposals.freelancer_id', '=', 'freelancers.id')
                                ->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
                                ->select('freelancers.id','users.firstName', 'users.lastName', 'users.country', 'users.location', 'users.created_at','proposals.id')
                                ->where('proposals.id', '=', $id)
                                ->first();

        /*$count_jobs = DB::table('jobs')->where([
                                        ['jobs.clientId', '=', $client->id],
                                        ['jobs.statusActiv', '=', 1]
                                    ])
                                    ->count();*/
       /* $proposal_status = DB::table('proposals')->select('proposals.current_proposal_status')->where('proposals.id', '=', )->first();
*/
        $proposals_job = DB::table('proposals')->where('proposals.job_id', '=', $job->job_id)
                                                ->count();

        //dd([$job,$job_skills,$freelancer]);

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
                ->select('jobs.title', 'users.firstName', 'users.lastName', 'users.image','contracts.id','contracts.startTime', 'contracts.paymentAmount')
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
                ->select('jobs.title', 'users.firstName', 'users.lastName', 'users.image','contracts.id','contracts.startTime', 'contracts.endTime', 'contracts.paymentAmount','reviews.reviewClient','rateClient')
                ->where([
                    ['contracts.clientId', '=', $id],
                    ['contracts.endTime', '!=', '']
                ])
                ->orderBy('contracts.endtime', 'desc')
                ->paginate(5);

        return view('clientPages.jobs.contracts', compact('contracts'));
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
