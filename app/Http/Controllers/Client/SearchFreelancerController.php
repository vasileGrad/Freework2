<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User;
use Auth;
use DB;

class SearchFreelancerController extends Controller
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
        $skills = DB::table('skills')->get();

        $freelancersCount = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')->where([
                                                        ['users.role_id', '=', 2],
                                                        ['users.statusActiv', '!=', 0]
                                                    ])
                                                ->count();
        $freelancers = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
            ->select('users.id','users.firstName','users.lastName', 'users.image', 'users.location','users.country','users.title','users.description','freelancers.hourlyRate',
                DB::raw("(SELECT sum(contracts.paymentAmount) FROM contracts
                            where (contracts.freelancerId = 'id' && contracts.endTime != '')) as totalEarnings")
            )
            ->where([
                ['users.role_id', '=', 2],
                ['users.statusActiv', '!=', 0]
            ])
            ->orderBy('freelancers.id','desc')->paginate(3);

        //dd($freelancers);

        //dd($freelancers);
        return view('clientPages.freelancerSearch', compact('freelancers', 'freelancersCount','skills'));
    }

    /**
     * Search with multiple filters
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchFilter(Request $request) 
    {
        $keyword_search = $request->input('search'); 
        $country = $request->input('country');
        $id_skill = $request->input('skill');
        $earn_amount = Input::get('earn_amount');
        $hourly_rate = Input::get('hourly_rate');
        $freelancer_level = Input::get('freelancer_level');
        $english_level = Input::get('english_level');

        $skill_name = DB::table('skills')->where('skills.id', '=', $id_skill)
                                        ->select('skills.skillName')->first();
        if($country != null)
            $keyword_country = $country;
        else
            $keyword_country = '';

        $freelancers = DB::table('freelancers')->leftJoin('users','freelancers.user_id', '=', 'users.id')
                    ->leftJoin('freelancer_skill', 'freelancers.id', '=', 'freelancer_skill.freelancer_id')
                    ->leftJoin('skills', 'freelancer_skill.skill_id', '=', 'skills.id')
                    ->select('users.id','users.firstName','users.lastName','users.image','users.title','users.location','users.country','description','freelancers.hourlyRate')
                    ->where([
                        ['users.firstName', 'LIKE', '%'.$keyword_search.'%'],
                        ['users.role_id', '=', 2]
                    ])
                    ->orWhere([
                        ['users.lastName', 'LIKE', '%'.$keyword_search.'%'],
                        ['users.role_id', '=', 2]
                    ])
                    ->orWhere([
                        ['users.country', '=', $keyword_country], 
                        ['skills.skillName', 'LIKE', '%'.$skill_name->skillName.'%']
                    ])
                    ->orderBy('freelancers.id','desc')->distinct()
                    ->paginate(3);
        //dd($freelancers);

        $skills = DB::table('skills')->get();
        $freelancersCount = count($freelancers);
        /*$freelancersCount = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')->where('users.role_id', '=', 2)
            ->count();*/

        //dd($freelancersCount);
        return view('clientPages.freelancerSearch', compact('freelancers','freelancersCount','skills'));
    }

    /**
     * Display all the freelancers that workd for a Client
     *
     * @param  int  $id - user_id
     * @return \Illuminate\Http\Response
     */
    public function myFreelancers($id) {

        // all the contracts finished
        $contracts = DB::table('contracts')->leftJoin('proposals', 'contracts.proposalId', 'proposals.id')
                ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                ->rightJoin('freelancers', 'proposals.freelancer_id', 'freelancers.id')
                ->rightJoin('users', 'freelancers.user_id', 'users.id')
                ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                ->select('jobs.id as jobId','jobs.title', 'users.id as userId','users.firstName', 'users.lastName', 'users.image','contracts.id as constractId','contracts.startTime', 'contracts.endTime', 'contracts.paymentAmount','reviews.reviewFreelancer','rateFreelancer')
                ->where([
                    ['contracts.clientId', '=', $id],
                    ['contracts.endTime', '!=', '']
                ])
                ->orderBy('contracts.endtime', 'desc')
                ->paginate(5);

        return view('clientPages.freelancers.myFreelancers', compact('contracts'));
    }

    /**
     * Search invite Freelancers
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchInviteFreelancers(Request $request) 
    {
        $keyword_search = $request->input('search'); 
        //$country = $request->input('country');
        //$id_skill = $request->input('skill');
        $job_id = $request->input('job_id');
        //dd($job_id);

        //$skill_name = DB::table('skills')->where('skills.id', '=', $id_skill)
                                        //->select('skills.skillName')->first();

        /*if($country != null)
            $keyword_country = $country;
        else
            $keyword_country = '';*/

        $freelancers = DB::table('freelancers')->leftJoin('users','freelancers.user_id', '=', 'users.id')
                    ->select('users.id','users.firstName','users.lastName','users.image','users.title','users.location','users.country','description','freelancers.hourlyRate')
                    ->Where([
                        ['users.firstName', 'LIKE', '%'.$keyword_search.'%'],
                        ['users.role_id', '=', 2],
                        ['users.statusActiv', '!=', 0]
                    ])
                    ->orWhere([
                        ['users.lastName', 'LIKE', '%'.$keyword_search.'%'],
                        ['users.role_id', '=', 2],
                        ['users.statusActiv', '!=', 0] 
                    ])
                    ->orderBy('freelancers.id','desc')
                    ->distinct()
                    ->paginate(3);

                    /*->orWhere([
                        ['users.country', '=', $keyword_country], 
                        ['users.role_id', '=', 2],
                        ['users.statusActiv', '!=', 0] 
                    ])
                    ->orWhere([
                        ['skills.skillName', 'LIKE', '%'.$skill_name->skillName.'%'],
                        ['users.role_id', '=', 2],
                        ['users.statusActiv', '!=', 0]
                    ])*/
                    

        //dd($freelancers->total());

        /*$countFreelancers = 0;
        foreach ($freelancers as $freelancer) {
            if($freelancer->id)
                $countFreelancers++;
        }*/

        //dd($freelancers);

        $skills = DB::table('skills')->leftJoin('job_skill','skills.id','job_skill.skill_id')
                                     ->select('skills.id','skills.skillName')
                                     ->where('job_skill.job_id',$job_id)
                                     ->get();

        //dd($skills);
        return view('clientPages.jobs.inviteFreelancers', compact('job_id','freelancers','skills'));
    }

    /**
     * Display all the freelancers that workd for a Client
     *
     * @param  int  $id - user_id
     * @return \Illuminate\Http\Response
     */
    public function inviteFreelancer($id, $job_id) {
        $valueFreelancer = $this->calculateValueFreelancer($id);

        $freelancerId = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                ->select('freelancers.id')
                ->where('users.id', '=', $id)
                ->first();

        $freelancer = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                        ->leftJoin('proposals', 'freelancers.id', 'proposals.freelancer_id')
                        ->leftJoin('contracts', 'contracts.id', 'contracts.proposalId')
                        ->select(DB::raw("(SELECT count(contracts.id) FROM contracts
                            where (contracts.freelancerId = '$freelancerId->id' && contracts.endTime != '')) as countJobs"),
                                DB::raw("(SELECT sum(contracts.paymentAmount) FROM contracts
                            where (contracts.freelancerId = '$freelancerId->id' && contracts.endTime != '')) as totalEarnings"),'users.id', 'users.firstName', 'users.lastName', 'users.location', 'users.country', 'users.image', 'users.title', 'users.description', 'freelancers.hourlyRate')
                        ->where([
                            ['users.id', '=', $id],
                            ['users.role_id', '=', 2]
                        ])
                        ->first();

        $skills = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                ->leftJoin('freelancer_skill', 'freelancers.id','freelancer_skill.freelancer_id')
                ->leftJoin('skills', 'freelancer_skill.skill_id', 'skills.id')
                ->select('skills.skillName')
                ->where('freelancers.id', $freelancerId->id)
                ->get();

        $contracts = DB::table('contracts')->leftJoin('proposals', 'contracts.proposalId', 'proposals.id')
                ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                ->leftJoin('payment_type', 'contracts.paymentTypeId', 'payment_type.id')
                ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                ->leftJoin('freelancers', 'proposals.freelancer_id', 'freelancers.id')
                ->leftJoin('users', 'freelancers.user_id', 'users.id')
                ->select('jobs.title', 'contracts.paymentAmount', 'contracts.startTime', 'contracts.endTime', 'payment_type.paymentName', 'reviews.reviewClient', 'reviews.rateClient')
                ->where([
                    ['freelancers.id', '=', $freelancerId->id],
                    ['users.role_id', '=', 2],
                    ['contracts.endTime', '!=', '']
                ])
                ->orderBy('contracts.id','desc')
                ->take(2)
                ->get();   
                
        return view('clientPages.Profile.inviteFreelancer', compact(['freelancer','skills','contracts','valueFreelancer','job_id']));
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

    public function calculateValueFreelancer($id){
        // Algorithm of calculation the Value of the Freelancer
        $freelancerId = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')
                                          ->select('freelancers.id')
                                          ->where('users.id',$id)
                                          ->first();

        $valueFreelancer = 0;

        $user_profile = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                ->select('users.title', 'users.description','users.location','users.country')
                ->where('users.id', $id)
                ->first();

        if($user_profile->title != ''){
            $valueFreelancer = $valueFreelancer + 5;
        }
        if($user_profile->description != ''){
            $valueFreelancer = $valueFreelancer + 5;
        }
        if($user_profile->location != ''){
            $valueFreelancer = $valueFreelancer + 5;
        }
        if($user_profile->country != ''){
            $valueFreelancer = $valueFreelancer + 5;
        }

        $totalEarnings = DB::table('contracts')->where([
                                                    ['contracts.freelancerId','=',$freelancerId->id],
                                                    ['contracts.endTime','!=','']
                                                ])
                                                ->sum('paymentAmount');
        //dd($totalEarnings->sum);

        return $valueFreelancer;
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
        $valueFreelancer = $this->calculateValueFreelancer($id);
        //$valueFreelancer = DB::statement('select calculateValueFreelancer()');
        //$value = DB::table('users')->select('users.firstName')->where('users.id','=',1)->first();
        //dd($value);

        //$valueFreelancer = DB::raw(DB::select('select calculateValueFreelancer()'));
        //dd(DB::raw(DB::select('select calculateValueFreelancer()')));
        //echo $valueFreelancer;
        //die();

        //$param1 = 2;
        //$param2 = 3;
        //dd(DB::select('exec maxim(?,?)', array($param1,$param2)));
        //dd(DB::select('bla'));
        //dd(DB::select()->from(DB::raw('"bla"()')));
        //dd(DB::statement('select maxim(?,?)', array($param1,$param2)));

        //$valueFreelancer=DB::select('SELECT public."bla"()');
        //$valueFreelancer=DB::statement('select bla()');
        //dd($valueFreelancer);

        $freelancerId = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                ->select('freelancers.id')
                ->where('users.id', '=', $id)
                ->first();

        $freelancer = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                        ->leftJoin('proposals', 'freelancers.id', 'proposals.freelancer_id')
                        ->leftJoin('contracts', 'contracts.id', 'contracts.proposalId')
                        ->select(DB::raw("(SELECT count(contracts.id) FROM contracts
                            where (contracts.freelancerId = '$freelancerId->id' && contracts.endTime != '')) as countJobs"),
                                DB::raw("(SELECT sum(contracts.paymentAmount) FROM contracts
                            where (contracts.freelancerId = '$freelancerId->id' && contracts.endTime != '')) as totalEarnings"),'users.id', 'users.firstName', 'users.lastName', 'users.location', 'users.country', 'users.image', 'users.title', 'users.description', 'freelancers.hourlyRate')
                        ->where([
                            ['users.id', '=', $id],
                            ['users.role_id', '=', 2]
                        ])
                        ->first();

        $skills = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                ->leftJoin('freelancer_skill', 'freelancers.id','freelancer_skill.freelancer_id')
                ->leftJoin('skills', 'freelancer_skill.skill_id', 'skills.id')
                ->select('skills.skillName')
                ->where('freelancers.id', $freelancerId->id)
                ->get();

        $contracts = DB::table('contracts')->leftJoin('proposals', 'contracts.proposalId', 'proposals.id')
                ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                ->leftJoin('payment_type', 'contracts.paymentTypeId', 'payment_type.id')
                ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                ->leftJoin('freelancers', 'proposals.freelancer_id', 'freelancers.id')
                ->leftJoin('users', 'freelancers.user_id', 'users.id')
                ->select('jobs.title', 'contracts.paymentAmount', 'contracts.startTime', 'contracts.endTime', 'payment_type.paymentName', 'reviews.reviewClient', 'reviews.rateClient')
                ->where([
                    ['freelancers.id', '=', $freelancerId->id],
                    ['users.role_id', '=', 2],
                    ['contracts.endTime', '!=', '']
                ])
                ->orderBy('contracts.id','desc')
                ->take(2)
                ->get();   
                
        return view('clientPages.freelancerShow', compact(['freelancer','skills','contracts','valueFreelancer']));
        //$freelancer = User::find($id);
        //return view('clientPages.freelancerShow')->withFreelancer($freelancer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function contractsFinishFreelancer($id)
    {
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

        return view('clientPages.freelancers.contractsFinishFreelancer', compact('contracts'));
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
