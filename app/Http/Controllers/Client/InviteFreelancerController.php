<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Proposal;
use Purifier;
use Session;
use DB;

class InviteFreelancerController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:client');
    }

    /**
     * Invite Freelancer to work
     *
     * @param  int  $id, $job_id
     * @return \Illuminate\Http\Response
     */
    public function createInvitation($id, $job_id) {
    	$freelancer = DB::table('users')->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
    							->select('freelancers.id')
    							->where('users.id',$id)
    							->first();

        //dd([$freelancer, $id, $job_id]);
        return view('clientPages.jobs.createInvitation', compact('freelancer','id','job_id'));
    }

    /**
     * Save Invitation
     *
     * @param  int  $id, $job_id
     * @return \Illuminate\Http\Response
     */
    public function saveInvitation(Request $request, $id, $job_id) {

        
        $this->validate($request, array(
            'body'    => 'required|min:5|max:2000'
        ));

        $job = DB::table('jobs')->select('jobs.paymentAmount', 'jobs.paymentTypeId')
                                ->where('jobs.id', '=', $job_id)
                                ->first();
        //dd($id, $job_id, $job);
        $proposal = new Proposal;
        $proposal->job_id = $job_id;
        $proposal->freelancer_id = $id;
        $proposal->client_id = Session::get('AuthUser');
        $proposal->payment_type_id = $job->paymentTypeId;
        $proposal->payment_amount = $job->paymentAmount;
        $proposal->current_proposal_status = 1;

        // we use Purifier to clean and secure
        $proposal->client_comment = Purifier::clean($request->body);

        $proposal->save();

        Session::flash('success', 'Your invitation was submitted successfully!');
        return Redirect()->route('jobs.show', $job_id);
    }

}