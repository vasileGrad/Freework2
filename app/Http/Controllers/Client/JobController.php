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
use Session;
use Purifier;
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
        //dd($job2);

        $jobs = DB::table('jobs')->leftJoin('category', 'category.id', '=', 'jobs.categoryId')
                                 ->leftJoin('complexity', 'complexity.id', '=', 'jobs.complexityId')
                                 ->leftJoin('expected_duration', 'expected_duration.id', '=', 'jobs.expectedDurationId')
                                 ->leftJoin('levels', 'levels.id', '=', 'jobs.levelId')
                                 ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                 ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                 ->where('clientId', Auth::user()->id)->paginate(5); // 5 is the number of

        //dd($jobs);
        //$skills = DB::table('skills')->leftJoin('job_skill', 'job_skill.skill_id', '=', 'skills.id')
                                     //->leftJoin('jobs', 'jobs.id', '=', 'job_skill.job_id')
                                     //->where('clientId', Auth::user()->id)->paginate(5); // 5 is the number of        
        //dd($skills);

        //return view('jobs.index', compact('jobs', 'skills'));
        return view('jobs.index', compact('jobs'));
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

        return view('jobs.create')->withCategories($categories)
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
            'levelId'               => 'required|integer'
        )); // validate the request
        // if the data is not valid what it does? Jumps back to the Create() action and will post the errors

        // 2. store in the database

        // create a new instance of a Job Model
        $job = new Job;

        // adding things to this brand new object to be created 
        $job->title = $request->title;
        $job->nrFreelancers = $request->nrFreelancers;
        $job->categoryId = $request->categoryId;
        $job->complexityId = $request->complexityId;
        $job->clientId = Auth::user()->id;
        $job->expectedDurationId = $request->expectedDurationId;
        $job->paymentTypeId = $request->paymentTypeId;
        $job->paymentAmount = $request->paymentAmount;
        $job->levelId = $request->levelId;

        // we use Purifier to clean and secure
        $job->description = Purifier::clean($request->description);

        $job->save(); // save the object
        // save the new item into the Database
        // this job it's gonna give us an id number
        //dd(count($request->skills) !=0);
        $job->skills()->sync($request->skills, false);

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($id);
        // find an item by the id that it's past in the url
        //$job = Job::find($id);  // also deep linking for the categories
        // render the view and it's gonna pass in a variable called job which is equal to $job
        //dd($id);
        $jobs2 = Job::find($id);

        $jobs = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                                ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                ->select('clients.country', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                ->where('jobs.id', $id)
                                ->get();

        //dd($jobs);

        return view('jobs.show', compact('jobs', 'jobs2'));
        //return view('jobs.show')->withJob($job);
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
