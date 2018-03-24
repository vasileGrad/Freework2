<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User;
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
        $freelancersCount = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')->where('users.role_id', '=', 2)
            ->count();
        $freelancers = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')->where('users.role_id', '=', 2)
            ->orderBy('freelancers.id','desc')->paginate(3);

        //return view('clientPages.freelancerSearch', compact($freelancers));
        return view('clientPages.freelancerSearch', compact('freelancers', 'freelancersCount','skills'));
    }

    /**
     * Search with multiple filters
     *
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
                                            ->select('users.id','users.firstName','users.lastName','users.image','users.title','users.country','description','freelancers.hourlyRate')
                                            ->where([
                                                ['users.role_id', '=', 2], 
                                                ['skills.skillName', 'LIKE', '%'.$skill_name->skillName.'%']
                                            ])
                                            ->orWhere([
                                                ['users.firstName', 'LIKE', '%'.$keyword_search.'%'],
                                                ['users.lastName', 'LIKE', '%'.$keyword_search.'%'],
                                                ['users.country', '=', $keyword_country]
                                            ])
                                            ->orderBy('freelancers.id','desc')->distinct()->paginate(3);
        //dd($freelancers);

        $skills = DB::table('skills')->get();
        $freelancersCount = count($freelancers);
        /*$freelancersCount = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')->where('users.role_id', '=', 2)
            ->count();*/

        //dd($freelancers);
        return view('clientPages.freelancerSearch', compact('freelancers','freelancersCount','skills'));
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $freelancer = User::find($id);
        return view('clientPages.freelancerShow')->withFreelancer($freelancer);
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
