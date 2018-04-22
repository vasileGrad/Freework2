<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\User;
use DB;

class FreelancerController extends Controller
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
     * Find specific freelancers.
     *
     * @return \Illuminate\Http\Response
     */
    public function findFreelancers()
    {
    	$freelancersCount = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
                    ->where([
                        ['users.role_id', '=', 2],
                        ['users.statusActiv', '=', 1]
                    ])
                    ->count();

        $freelancers = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
        	->select(
                'users.id as id','users.firstName','users.lastName','users.location','users.country', 'users.image', 'users.title', 'users.description','freelancers.hourlyRate')
        	->where([
                ['users.role_id', '=', 2],
                ['users.statusActiv', '=', 1]
            ])
            ->orderBy('freelancers.id','desc')->paginate(3);

        //dd([$freelancersCount,$freelancers]);
        return view('adminPages.Freelancers.findFreelancers', compact('freelancersCount','freelancers'));
    }

    /**
     * Find specific freelancer.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findFreelancerFilter(Request $request)
    {
    	$search = $request->input('search');
        if($search != null)
            $keyword = $search;
        else
            $keyword = '';

        $freelancers = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
            ->select('users.id','users.firstName','users.lastName','users.location','users.country', 'users.image', 'users.title', 'users.description','freelancers.hourlyRate')
            ->where([
                ['users.firstName', 'LIKE', '%'.$keyword.'%'],
                ['users.role_id', '=', 2],
                ['users.statusActiv', '=', 1]
            ])
            ->orWhere([
                ['users.lastName', 'LIKE', '%'.$keyword.'%'],
                ['users.role_id', '=', 2],
                ['users.statusActiv', '=', 1]
            ])
            ->orderBy('freelancers.id','desc')->paginate(3);

        return view('adminPages.Freelancers.findFreelancers', compact('freelancers'));
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showFreelancer($id)
    {  
        $freelancerId = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')->select('freelancers.id')->where('users.id',$id)->first();
        $freelancerId = $freelancerId->id;

        $freelancer = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')
                            ->leftJoin('levels', 'freelancers.level_id', 'levels.id')
                            ->select(DB::raw("(SELECT sum(contracts.paymentAmount) FROM contracts where (contracts.endTime != 'NULL' and contracts.freelancerId = '$freelancerId')) as earnings"),
                                'users.id', 'users.firstName', 'users.lastName', 'users.title', 'users.country', 'users.location', 'users.image', 'users.statusActiv', 'freelancers.hourlyRate', 'levels.levelName'
                            )
                            ->where([
                                ['users.id', '=', $id],
                                ['users.statusActiv', '=', 1]
                            ])
                            ->first(); 
     
        $freelancer_skills = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')
                            ->leftJoin('freelancer_skill', 'freelancers.id','freelancer_skill.freelancer_id')
                            ->leftJoin('skills', 'freelancer_skill.skill_id', '=', 'skills.id')
                            ->select('skills.skillName')
                            ->where('users.id', '=', $id)
                            ->get();                                                       
        return view('adminPages.Freelancers.showFreelancer', compact('freelancer','freelancer_skills'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showBlockedFreelancer($id)
    {  
        $freelancerId = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')->select('freelancers.id')->where('users.id',$id)->first();
        $freelancerId = $freelancerId->id;

        $freelancer = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')
                            ->leftJoin('levels', 'freelancers.level_id', 'levels.id')
                            ->select(DB::raw("(SELECT sum(contracts.paymentAmount) FROM contracts where (contracts.endTime != 'NULL' and contracts.freelancerId = '$freelancerId')) as earnings"),
                                'users.id', 'users.firstName', 'users.lastName', 'users.title', 'users.country', 'users.location', 'users.image', 'users.statusActiv', 'freelancers.hourlyRate', 'levels.levelName'
                            )
                            ->where([
                                ['users.id', '=', $id],
                                ['users.statusActiv', '=', 0]
                            ])
                            ->first(); 
     
        $freelancer_skills = DB::table('users')->leftJoin('freelancers','users.id','freelancers.user_id')
                            ->leftJoin('freelancer_skill', 'freelancers.id','freelancer_skill.freelancer_id')
                            ->leftJoin('skills', 'freelancer_skill.skill_id', '=', 'skills.id')
                            ->select('skills.skillName')
                            ->where('users.id', '=', $id)
                            ->get();                                                       
        return view('adminPages.Freelancers.showFreelancer', compact('freelancer','freelancer_skills'));
    }

    /**
     * Block specified freelancer
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blockFreelancer($id)
    {   
        $user = User::find($id);
        $user->statusActiv = 0;
        $user->save();

        // Set flash data with success message
        Session::flash('success', 'This Freelancer was successfully blocked!');
        
        return redirect()->route('findFreelancers');
    }

    /**
     * Unblock specified freelancer
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unblockFreelancer($id)
    {   
        $user = User::find($id);
        $user->statusActiv = 1;
        $user->save();

        // Set flash data with success message
        Session::flash('success', 'This Freelancer was successfully unblocked!');
        // redirect with flash data to posts.show
        return redirect()->route('blockedFreelancers');
    }

    /**
     * Show blocked freelancers.
     *
     * @return \Illuminate\Http\Response
     */
    public function blockedFreelancers()
    {   
        $freelancers = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
            ->select('users.id','users.firstName','users.lastName','users.location','users.country', 'users.image', 'users.title', 'users.description','freelancers.hourlyRate')
            ->where([
                ['users.role_id', '=', 2],
                ['users.statusActiv', '=', 0]
            ])
            ->orderBy('freelancers.id','desc')->paginate(3);

        return view('adminPages.Freelancers.blockedFreelancers', compact('freelancers'));
    }

    /**
     * Find specific freelancer.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function blockedFreelancersFilter(Request $request)
    {
        $search = $request->input('search');
        if($search != '')
            $keyword = $search;
        else
            $keyword = '';
        $freelancers = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
            ->select('users.id','users.firstName','users.lastName','users.location','users.country', 'users.image', 'users.title', 'users.description','freelancers.hourlyRate')
            ->where([
                ['users.role_id', '=', 2],
                ['users.statusActiv', '=', 0],
                ['users.firstName', 'LIKE', '%'.$keyword.'%']
            ])
            ->orWhere([
                ['users.role_id', '=', 2],
                ['users.statusActiv', '=', 0],
                ['users.lastName', 'LIKE', '%'.$keyword.'%']
            ])
            ->orderBy('freelancers.id','desc')->paginate(3);

        return view('adminPages.Freelancers.blockedFreelancers', compact('freelancers'));
    }
}
