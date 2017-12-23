<?php

namespace App\Http\Controllers\Freelancer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Job;
use DB;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
                                 ->where('clientId', Auth::user()->id)->paginate(5); // 5 is the number of

        return view('jobs.index', compact('jobs'));
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
     * Search a resource in the storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $jobs = DB::table('jobs')->leftJoin('clients', 'jobs.clientId', '=', 'clients.id')
                                ->leftJoin('expected_duration', 'jobs.expectedDurationId', '=', 'expected_duration.id')
                                ->leftJoin('payment_type', 'jobs.paymentTypeId', '=', 'payment_type.id')
                                ->leftJoin('category', 'jobs.categoryId', '=', 'category.id')
                                ->leftJoin('complexity', 'jobs.complexityId', '=', 'complexity.id')
                                ->leftJoin('levels', 'jobs.levelId', '=', 'levels.id')
                                ->select('clients.firstName', 'clients.country', 'jobs.id', 'jobs.title', 'jobs.description', 'jobs.nrFreelancers', 'jobs.paymentAmount', 'jobs.clientId', 'jobs.created_at', 'category.categoryName', 'complexity.complexityName', 'expected_duration.durationName', 'levels.levelName', 'payment_type.paymentName')
                                ->where('title', 'LIKE', '%'.$keyword.'%')
                                ->orWhere('description', 'LIKE', '%'.$keyword.'%')
                                ->get();

        //$jobs = Job::where('title', 'LIKE', '%'.$keyword.'%')
                    //->orWhere('description', 'LIKE', '%'.$keyword.'%')->get();
        return view('freelancerPages.jobSearch', compact('jobs'));
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

        return view('freelancerPages.jobShow', compact('jobs', 'jobs2'));
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
