<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Skill;
use DB;

class SkillController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = DB::table('skills')->orderBy('skills.id','desc')->paginate(5);

        return view('adminPages.Skills.skills', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPages.Skills.addSkill');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'title'         => 'required|max:255'
        )); 

        $skill = new Skill;
        $skill->skillName = $request->title;

        $skill->save();

        Session::flash('success', 'The skill was successfully saved!');

        // 3. redirect to another page : show() or index()
        return redirect()->route('skills.show', $skill->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // find an item by the id that it's past in the url
        $skill = Skill::find($id);  // also deep linking for the categories
        // render the view and it's gonna pass in a variable called post which is equal to $post
        return view('adminPages.Skills.showSkill')->withSkill($skill);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $skill = Skill::find($id);

        return view('adminPages.Skills.editSkill')->withSkill($skill);
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
        // Validate the data
        $this->validate($request, array(
            // rules 
            'skillName' => 'required|max:255'
        ));

        $skill = Skill::find($id);
        $skill->skillName = $request->input('skillName');
        $skill->save();

        // Set flash data with success message
        Session::flash('success', 'This skill was successfully updated!');
        // redirect with flash data to posts.show
        return redirect()->route('skills.show', $skill->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $skill = Skill::find($id);
        $skill->delete();

        Session::flash('success', 'The skill was successfully deleted!');

        return redirect()->route('skills.index');
    }

    /**
     * Find specific category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showSkills()
    {
        $skills = DB::table('skills')->orderBy('skills.id','desc')->paginate(5);

        return view('adminPages.Skills.findSkill', compact('skills'));
    }

    /**
     * Find specific category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findSkill(Request $request)
    {
        $search = $request->input('search');
        if($search != '')
            $keyword_skill = $search;
        else
            $keyword_skill = '';

        $skills = DB::table('skills')->where('skills.skillName', 'LIKE', '%'.$keyword_skill.'%')->orderBy('skills.id','desc')->paginate(5);

        return view('adminPages.Skills.findSkill', compact('skills'));
    }
}
