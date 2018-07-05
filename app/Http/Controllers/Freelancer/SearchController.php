<?php

namespace App\Http\Controllers\Freelancer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Job;
use Storage;
use Auth;
use DB; 

class SearchController extends Controller
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
    public function index() 
    {
        $jobs = DB::table('jobs')->leftJoin('category', 'category.id', '=', 'jobs.categoryId')
                                 ->leftJoin('complexity', 'complexity.id', '=', 'jobs.complexityId')
                                 ->leftJoin('expected_duration', 'expected_duration.id', '=', 'jobs.expectedDurationId')
                                 ->leftJoin('levels', 'levels.id', '=', 'jobs.levelId')
                                 ->leftJoin('payment_type', 'payment_type.id', '=', 'jobs.paymentTypeId')
                                 ->select('jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                 ->where('clientId', Auth::user()->id)
                                 ->paginate(5);

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function goBack()
    {
        return Redirect()->route('jobSearch');
    }

    /**
     * Search a resource in the storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword = $request->input('search');
        if(isset($keyword)){
            $job = DB::table('job_search_history')->select('job_search_history.jobTitle')->orderBy('job_search_history.created_at', 'desc')->first();
            //dd($job->jobTitle);
            if($keyword != $job->jobTitle){
                DB::table('job_search_history')->insert(
            ['jobTitle' => $keyword]);
            }
        }

        $jobs = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                                ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                ->select('users.firstName', 'users.country', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.statusActiv', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                ->where([ 
                                    ['jobs.title', 'LIKE', '%'.$keyword.'%'],
                                    ['jobs.statusActiv', '=', 1]
                                ])
                                ->orderBy('jobs.id','desc')
                                ->paginate(5);

        $hourly = DB::table('jobs')->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')->where('payment_type.paymentName', 'Hourly')->count();


        $fixed_price = DB::table('jobs')->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')->where('payment_type.paymentName', 'Fixed price')->count();

        $entry_level = DB::table('jobs')->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                        ->where('levels.levelName', 'Entry Level')->count();
        $intermediate = DB::table('jobs')->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                        ->where('levels.levelName', 'Intermediate')->count();
        $expert =  DB::table('jobs')->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                        ->where('levels.levelName', 'Expert')->count();

        $less_100 = DB::table('jobs')->where('jobs.paymentAmount', '<', 100)->count();
        $between_100_500 = DB::table('jobs')->whereBetween('jobs.paymentAmount', array(100, 500))->count();
        $between_500_1k = DB::table('jobs')->whereBetween('jobs.paymentAmount', array(500, 1000))->count();
        $between_1k_5k = DB::table('jobs')->whereBetween('jobs.paymentAmount', array(1000, 5000))->count();

        $more_5k =  DB::table('jobs')->where('jobs.paymentAmount', '>', 5000)->count();

        $less_one_week = DB::table('jobs')->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')->where('expected_duration.durationName', 'Less then 1 week')->count();
        $less_one_month = DB::table('jobs')->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')->where('expected_duration.durationName', 'Less then 1 month')->count();
        $one_three_months = DB::table('jobs')->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')->where('expected_duration.durationName', '1 to 3 months')->count(); 
        $three_six_months = DB::table('jobs')->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')->where('expected_duration.durationName', '3 to 6 months')->count();
        $more_six_months = DB::table('jobs')->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')->where('expected_duration.durationName', 'More than 6 months')->count();

        return view('freelancerPages.findWork.jobSearch', compact('jobs', 'hourly', 'fixed_price', 'entry_level','intermediate','expert','less_100','between_100_500','between_500_1k','between_1k_5k','more_5k','less_one_week','less_one_month','one_three_months','three_six_months','more_six_months'));
    }

    public function searchFilters(Request $request)
    { 
        $keyword = $request->input('search');
        $job_type = Input::get('job_type');
        $experience_level = Input::get('experience_level');
        $nr_proposals = Input::get('nr_proposals');
        $client_history = Input::get('client_history');
        $budget = Input::get('budget');
        $project_length = Input::get('project_length');

        if(isset($keyword)){
            DB::table('job_search_history')->insert(
            ['jobTitle' => $keyword]);
        }

        if($job_type != 'Any')
            $keyword_job_type = $job_type;
        else
            $keyword_job_type = '';

        if($experience_level != 'Any')
            $keyword_experience_level = $experience_level;
        else
            $keyword_experience_level = '';

        if($project_length != 'Any')
            $keyword_project_length = $project_length;
        else
            $keyword_project_length = '';

        if($budget == 'Any'){
            $keyword_budget1 = 1;
            $keyword_budget2 = 1000000;
        }
        elseif($budget == 'Less_than_100'){
            $keyword_budget1 = 1;
            $keyword_budget2 = 100;
        }
        elseif($budget == 'Budget_100_500'){
            $keyword_budget1 = 100;
            $keyword_budget2 = 500;
        }
        elseif($budget == 'Budget_500_1k'){
            $keyword_budget1 = 500;
            $keyword_budget2 = 1000;
        }
        elseif($budget == 'Budget_1k_5k'){
            $keyword_budget1 = 1000;
            $keyword_budget2 = 5000;
        }
        elseif($budget == 'More_than_5k'){
            $keyword_budget1 = 5000;
            $keyword_budget2 = 1000000;
        }
        
        $jobs = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('users', 'clients.user_id', '=', 'users.id')
                                ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                                ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                ->select('users.firstName', 'users.country', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.statusActiv', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                ->where([
                                    ['jobs.statusActiv', '=', 1],
                                    ['jobs.title', 'LIKE', '%'.$keyword.'%'],
                                    ['payment_type.paymentName', 'LIKE', '%'.$keyword_job_type.'%'],
                                    ['levels.levelName', 'LIKE', '%'.$keyword_experience_level.'%'],
                                    ['expected_duration.durationName', 'LIKE', '%'.$keyword_project_length.'%']
                                ])
                                ->orderBy('jobs.id','desc')
                                ->paginate(5);

        $hourly = DB::table('jobs')->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')->where('payment_type.paymentName', 'Hourly')->count();


        $fixed_price = DB::table('jobs')->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')->where('payment_type.paymentName', 'Fixed price')->count();

        $entry_level = DB::table('jobs')->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                        ->where('levels.levelName', 'Entry Level')->count();
        $intermediate = DB::table('jobs')->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                        ->where('levels.levelName', 'Intermediate')->count();
        $expert =  DB::table('jobs')->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                        ->where('levels.levelName', 'Expert')->count();

        $less_100 = DB::table('jobs')->where('jobs.paymentAmount', '<', 100)->count();
        $between_100_500 = DB::table('jobs')->whereBetween('jobs.paymentAmount', array(100, 500))->count();
        $between_500_1k = DB::table('jobs')->whereBetween('jobs.paymentAmount', array(500, 1000))->count();
        $between_1k_5k = DB::table('jobs')->whereBetween('jobs.paymentAmount', array(1000, 5000))->count();

        $more_5k =  DB::table('jobs')->where('jobs.paymentAmount', '>', 5000)->count();

        $less_one_week = DB::table('jobs')->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')->where('expected_duration.durationName', 'Less then 1 week')->count();
        $less_one_month = DB::table('jobs')->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')->where('expected_duration.durationName', 'Less then 1 month')->count();
        $one_three_months = DB::table('jobs')->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')->where('expected_duration.durationName', '1 to 3 months')->count();
        $three_six_months = DB::table('jobs')->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')->where('expected_duration.durationName', '3 to 6 months')->count();
        $more_six_months = DB::table('jobs')->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')->where('expected_duration.durationName', 'More than 6 months')->count();

        return view('freelancerPages.findWork.jobSearch', compact('jobs', 'hourly', 'fixed_price', 'entry_level','intermediate','expert','less_100','between_100_500','between_500_1k','between_1k_5k','more_5k','less_one_week','less_one_month','one_three_months','three_six_months','more_six_months'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function jobShow($id) 
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

        $job_skills = DB::table('skills')->leftJoin('job_skill', 'skills.id', '=', 'job_skill.skill_id')
                                        ->leftJoin('jobs', 'job_skill.job_id', '=', 'jobs.id')
                                        ->select('skills.skillName')
                                        ->where('jobs.id', '=', $id)
                                        ->get();  

        $freelancer = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')->select('freelancers.id')
                                ->where('users.id',$user_id)
                                ->first();
        $proposalCount = DB::table('proposals')->select('proposals.id')
                                        ->where([
                                            ['proposals.job_id', '=', $id],
                                            ['proposals.freelancer_id', '=', $freelancer->id]
                                        ])
                                        ->count();

        $job_saved = DB::table('job_saved')->where([
                                            ['job_saved.job_id', '=', $id],
                                            ['job_saved.freelancer_id', '=', $user_id]
                                        ])->count();

        $uploads = DB::table('uploads')->where('uploads.job_id', $job->id)
                                       ->select('uploads.fileName')->get();                                              
        return view('freelancerPages.findWork.jobShow', compact('job','job_skills','proposalCount','job_saved','uploads'));
    }

    /**
     * Download a specific file_name
     *
     * @param  int  $file_name
     * @return \Illuminate\Http\Response
     */
    public function downloadFileFreelancer($file_name) {
        return Storage::download($file_name);
    } 
}
