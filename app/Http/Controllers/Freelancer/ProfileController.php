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

    // id = id of the freelancer
    public function calculateValueFreelancer($id){
        // Algorithm of calculation the Value of the Freelancer

        $user_profile = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                ->select('users.title', 'users.description','users.location','users.country')
                ->where('users.id', Auth::user()->id)
                ->first();

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
        $valueFreelancer = 0;

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

        $suma = $freelancer->totalEarnings;
        if($suma > 100 && $suma < 500){
            $valueFreelancer = $valueFreelancer + 10;
        }
        if($suma > 500 && $suma < 1000){
            $valueFreelancer = $valueFreelancer + 100;
        }
        if($suma > 1000){
            $valueFreelancer = $valueFreelancer + 1000;
        }

        $contracts = $freelancer->countJobs;
        if($contracts > 1 && $contracts < 5){
            $valueFreelancer = $valueFreelancer + 10;
        }
        if($contracts > 5 && $contracts < 10){
            $valueFreelancer = $valueFreelancer + 100;
        }
        if($contracts > 10 && $contracts < 50){
            $valueFreelancer = $valueFreelancer + 1000;
        }
        if($contracts > 50 && $contracts < 100){
            $valueFreelancer = $valueFreelancer + 2000;
        }
        if($contracts > 100 && $contracts < 500){
            $valueFreelancer = $valueFreelancer + 3000;
        }
        if($contracts > 500){
            $valueFreelancer = $valueFreelancer + 5000;
        }

        return $valueFreelancer;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function freelancerProfile($id)
    {
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
                ->take(2)
                ->get();   

        return view('freelancerPages.Profile.show', compact(['freelancer','skills','contracts','valueFreelancer']));
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
