<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ProfileController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:client');
    }

	 /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clientProfile($id) {
    	$client = DB::table('users')->leftJoin('clients', 'users.id', 'clients.user_id')
                        ->leftJoin('contracts', 'contracts.id', 'contracts.proposalId')
                        ->select(DB::raw("(SELECT count(contracts.id) FROM contracts
                            where (contracts.clientId = '$id' && contracts.endTime != '')) as countJobs"),
                                DB::raw("(SELECT count(contracts.id) FROM contracts
                            where (contracts.clientId = '$id')) as contracts"), 
                                DB::raw("(SELECT sum(contracts.paymentAmount) FROM contracts
                            where (contracts.clientId = '$id' && contracts.endTime != '')) as totalSpending"), 
                            'users.id', 'users.firstName', 'users.lastName', 'users.location', 'users.country', 'users.image')
                        ->where([
                            ['users.id', '=', $id],
                            ['users.role_id', '=', 3]
                        ])
                        ->first();

        $contractsNow = $client->contracts-$client->countJobs;

        $contracts = DB::table('contracts')->leftJoin('proposals', 'contracts.proposalId', 'proposals.id')
                ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                ->leftJoin('payment_type', 'contracts.paymentTypeId', 'payment_type.id')
                ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                ->leftJoin('clients', 'jobs.clientId', 'clients.id')
                ->leftJoin('users', 'clients.user_id', 'users.id')
                ->select('jobs.id as jobId', 'jobs.title', 'contracts.paymentAmount', 'contracts.startTime', 'contracts.endTime', 'payment_type.paymentName', 'reviews.reviewFreelancer', 'reviews.rateFreelancer',
                	DB::raw("(SELECT users.firstName FROM contracts left join proposals on contracts.proposalId = proposals.id left join freelancers on proposals.freelancer_id = freelancers.id left join users on freelancers.user_id = users.id where (contracts.clientId = '$id' && contracts.endTime != '' && proposals.job_id = jobId)) as freelancerFirstName"),
                	DB::raw("(SELECT users.lastName FROM contracts left join proposals on contracts.proposalId = proposals.id left join freelancers on proposals.freelancer_id = freelancers.id left join users on freelancers.user_id = users.id where (contracts.clientId = '$id' && contracts.endTime != '' && proposals.job_id = jobId)) as freelancerLastName"),
                	DB::raw("(SELECT users.image FROM contracts left join proposals on contracts.proposalId = proposals.id left join freelancers on proposals.freelancer_id = freelancers.id left join users on freelancers.user_id = users.id where (contracts.clientId = '$id' && contracts.endTime != '' && proposals.job_id = jobId)) as freelancerImage"))
                ->where([ 
                    ['users.id', '=', $id],
                    ['users.role_id', '=', 3],
                    ['contracts.endTime', '!=', '']
                ])
                ->take(2)
                ->get(); 

        return view('clientPages.Profile.show', compact(['client','contracts','contractsNow']));
    }
}
