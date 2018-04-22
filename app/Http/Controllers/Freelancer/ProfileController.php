<?php

namespace App\Http\Controllers\Freelancer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;

class ProfileController extends Controller
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
        /*$freelancer = DB::table('users')->leftJoin('freelancer_skill', 'users.id', '=', 'freelancer_skill.freelancer_id')
                                        ->leftJoin('skills', 'freelancer_skill.skill_id', '=', 'skills.id')
                                        ->select('users.firstName', 'users.lastName', 'users.location', 'users.hourlyRate', 'skills.skillName')
                                        ->where('users.id', Auth::user()->id)->get();*/
    
        //dd($freelancer);
        //return view('freelancerProfile.index', compact('freelancer'));      
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

    public function calculateValueFreelancer(){
        // Algorithm of calculation the Value of the Freelancer
        $valueFreelancer = 0;

        $user_profile = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                ->select('users.title', 'users.description','users.location','users.country')
                ->where('users.id', Auth::user()->id)
                ->first();

        if($user_profile->title != ''){
            $valueFreelancer = $valueFreelancer + 5;
        }
        if($user_profile->title != ''){
            $valueFreelancer = $valueFreelancer + 5;
        }
        if($user_profile->location != ''){
            $valueFreelancer = $valueFreelancer + 5;
        }
        if($user_profile->country != ''){
            $valueFreelancer = $valueFreelancer + 5;
        }

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
        //$valueFreelancer = $this->calculateValueFreelancer();
        $valueFreelancer = DB::select("CALL calculateValueFreelancer(Auth::user->id)");

        dd($valueFreelancer);

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
                ->take(2)->get();
                
        //dd($contracts);
        //$freelancer = User::find($id);

        //dd($freelancer);
        return view('freelancerProfile.show',compact(['freelancer','skills','contracts','valueFreelancer']));
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

    public function updateTitle(Request $request)
    {
        $this->validate($request, array(
            // rules 
            'text' => 'required|min:3|max:255'
        ));
        $user = User::find(Auth::user()->id);
        $user->title = $request->text;
        $user->save();
        return $request->all();
    }

    public function updateOverview(Request $request)
    {
        $this->validate($request, array(
            // rules 
            'text' => 'required'
        ));
        $user = User::find(Auth::user()->id);
        $user->description = $request->text;
        $user->save();
        return $request->all();
    }
}
