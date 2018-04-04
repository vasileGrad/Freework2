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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $freelancer = User::find($id);

        //dd($id);
        return view('freelancerProfile.show')->withFreelancer($freelancer);
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
