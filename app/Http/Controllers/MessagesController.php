<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Conversation;
use App\Message;
use App\Proposal;
use App\Contract;
use App\Review;
use App\Job;
use Session;
use App\Events\NewMessageEvent;

class MessagesController extends Controller
{
    /**
     * Take messages
     *
     * @return \Illuminate\Http\Response
     */
    public function messages() {
        $userId = Session::get('AuthUser');
        $AuthUserRole = Session::get('AuthUserRole');
        //dd($AuthUserRole);

        if ($AuthUserRole == 2) {
            $user = DB::table('users')->join('freelancers', 'users.id', '=', 'freelancers.user_id')
                                ->select('users.id', 'users.firstName', 'users.lastName', 'users.location', 'users.country')
                                ->where('users.id', '=', $userId)
                                ->first();
        }elseif($AuthUserRole == 3){
            $user = DB::table('users')->join('clients', 'users.id', '=', 'clients.user_id')
                                ->select('users.id', 'users.firstName', 'users.lastName', 'users.location', 'users.country')
                                ->where('users.id', '=', $userId)
                                ->first();
        }
        //$userMsg = DB::select('messages_get(?)', array($id));
        //dd($jobs);
        //dd($userMsg);
        //dd([$user, $userId]);
        return view('messages.messages', compact('user','userId'));
    }
 
    /**
     * Get Messages
     *
     * @return \Illuminate\Http\Response
     */
    public function getMessages() {
        $AuthUser = Session::get('AuthUser');

        $allUsers1 = DB::table('users') 
            ->leftJoin('conversations', 'users.id', 'conversations.user_two')
            ->leftJoin('proposals', 'conversations.proposal_id', '=', 'proposals.id')
            ->leftJoin('jobs', 'proposals.job_id', '=', 'jobs.id')
            ->select('jobs.title', 'conversations.id','users.firstName', 'users.lastName', 'users.image')
            ->where('conversations.user_one', $AuthUser)
            ->get();
        //dd($allUsers1);

        $allUsers2 = DB::table('users') 
            ->leftJoin('conversations', 'users.id', 'conversations.user_one')
            ->leftJoin('proposals', 'conversations.proposal_id', '=', 'proposals.id')
            ->leftJoin('jobs', 'proposals.job_id', '=', 'jobs.id')
            ->select('jobs.title', 'conversations.id','users.firstName', 'users.lastName','users.image')
            ->where('conversations.user_two', $AuthUser)
            ->get();
        // combine all the users

        return array_merge($allUsers1->toArray(), $allUsers2->toArray());
    }

    /**
     * Get information about that particular message
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMessagesId($id) {
        $AuthUserRole = Session::get('AuthUserRole');

        if($AuthUserRole == 2){
            $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('contracts', 'proposals.id', 'contracts.proposalId')
                        ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select(DB::raw("(SELECT(firstName) FROM proposals
                            left join conversations on proposals.id = conversations.proposal_id
                            left join jobs on proposals.job_id = jobs.id
                            left join clients on jobs.clientId = clients.id 
                            left join users on clients.user_id = users.id
                            where conversations.id = '$id') as firstNameShow"),
                                DB::raw("(SELECT(lastName) FROM proposals
                            left join conversations on proposals.id = conversations.proposal_id
                            left join jobs on proposals.job_id = jobs.id
                            left join clients on jobs.clientId = clients.id
                            left join users on clients.user_id = users.id
                            where conversations.id = '$id') as lastNameShow"),
                            'users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.status','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal','proposals.payment_amount','proposals.current_proposal_status as currentProposalStatus','reviews.reviewClient as reviewClient','reviews.rateClient as rateClient')
                        ->where('messages.conversation_id', $id)
                        ->get();
        //dd($userMsg1);
        }elseif($AuthUserRole == 3){
            $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('contracts', 'proposals.id', 'contracts.proposalId')
                        ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select(DB::raw("(SELECT(firstName) FROM proposals
                            left join freelancers on proposals.freelancer_id = freelancers.id
                            left join users on freelancers.user_id = users.id
                            left join conversations on proposals.id = conversations.proposal_id where conversations.id = '$id') as firstNameShow"),
                                DB::raw("(SELECT(lastName) FROM proposals
                            left join freelancers on proposals.freelancer_id = freelancers.id
                            left join users on freelancers.user_id = users.id
                            left join conversations on proposals.id = conversations.proposal_id where conversations.id = '$id') as lastNameShow"),
                            'users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.status','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal','proposals.payment_amount','proposals.current_proposal_status as currentProposalStatus','reviews.reviewFreelancer as reviewFreelancer', 'reviews.rateFreelancer as rateFreelancer')
                        ->where('messages.conversation_id', $id)
                        ->get();
            //dd($userMsg);
        }
        return $userMsg;
    }

    /**
     * Write a message to somebody
     *
     * @param  int  $proposal_id
     * @return \Illuminate\Http\Response
     */
    public function messageProposal($proposal_id) {
        $AuthUser = Session::get('AuthUser');
        $AuthUserRole = Session::get('AuthUserRole');
        
        $proposal_id = (int)$proposal_id;
        //dd($proposal_id);
        $proposal = Proposal::find($proposal_id);
        //dd($proposal);
        $proposal->current_proposal_status = 2; // 2 = negociation phase
        $proposal->save();

        $freelancer_id = DB::table('proposals')->join('freelancers', 'proposals.freelancer_id', '=', 'freelancers.id')
                                                ->select('freelancers.user_id')
                                                ->where('proposals.id', '=', $proposal_id)
                                                ->first();


        $client = DB::table('proposals')->select('proposals.client_id')
                                            ->where('proposals.id', '=', $proposal_id)
                                            ->first();
        //dd($client_id);
        //dd($freelancer_id);

        //dd([$AuthUser, $freelancer_id->user_id, $proposal_id]);

        //dd($AuthUserRole);
        if($AuthUserRole == 3){ //Client starts a new conversation
            // new conversation for a new Job
            $conId_new = DB::table('conversations')->insertGetId([
                'user_one'    => $AuthUser,
                'user_two'    => $freelancer_id->user_id,
                'proposal_id' => $proposal_id
            ]);

            // Client send Message
            $sendM = DB::table('messages')->insert([
                'user_from'       => $AuthUser,
                'user_to'         => $freelancer_id->user_id,
                'msg'             => 'Started the conversation',
                'status'          => 1,
                'conversation_id' => $conId_new
            ]);
            //dd($sendM);
        }elseif($AuthUserRole == 2) {// Freelancer starts a new conversation
            // new conversation for a new Job
            $conId_new = DB::table('conversations')->insertGetId([
                'user_one'    => $AuthUser,
                'user_two'    => $client->client_id,
                'proposal_id' => $proposal_id
            ]);

            // Client send Message
            $sendM = DB::table('messages')->insert([
                'user_from'       => $AuthUser,
                'user_to'         => $client->client_id,
                'msg'             => 'Started accepted the invitation',
                'status'          => 1,
                'conversation_id' => $conId_new
            ]);
            //dd($sendM);
        }

        return redirect()->route('messages');
    }

    /**
     * Send Message
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request) {
        //dd('hello');
        $AuthUser = Session::get('AuthUser');
        
        $conID = $request->conID;
        $msg = $request->msg;
        //dd(['conID','msg']);
        $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)->get();

        //dd($fetch_userTo);
        if($fetch_userTo[0]->user_from == $AuthUser){
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_to;
        }else {
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_from;
        }

        // now send message
        $sendM = DB::table('messages')->insert([
            'user_to'         => $userTo,
            'user_from'       => $AuthUser,
            'msg'             => $msg,
            'status'          => 1,
            'conversation_id' => $conID
        ]);

        $message = Message::where('user_to', $userTo)
                            ->where('user_from', $AuthUser)
                            ->where('msg', $msg)
                            ->where('conversation_id', $conID)
                            ->first();

        /*dd($message);                    
        //broadcast(new NewMessageEvent($message))->toOthers();
        event(new NewMessageEvent($message));*/

        if($sendM){
             $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select('users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.status','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal','proposals.payment_amount','proposals.current_proposal_status as currentProposalStatus')
                        ->where('messages.conversation_id', $conID)
                        ->get();
            return $userMsg;
        }else{
            echo 'not sent';
        }
    }

    /**
     * New Message
     *
     * @return \Illuminate\Http\Response
     */
    public function newMessage(){

        if(Session::get('AuthUserRole') == 3 /*&& Auth::guard('freelancer')*/){
            $users = DB::table('users')->leftJoin('clients', 'users.id', '=', 'clients.user_id')
                                ->where('role_id', '=', 2)
                                ->select('users.id', 'users.firstName', 'users.lastName', 'users.country', 'users.location', 'users.image')
                                ->get();
        }
        elseif(Session::get('AuthUserRole') ==  2/* && Auth::guard('client')*/){
            $users = DB::table('users')->leftJoin('freelancers', 'users.id', '=', 'freelancers.user_id')
                                ->where('role_id', '=', 3)
                                ->select('users.id', 'users.firstName', 'users.lastName', 'users.country', 'users.location', 'users.image')
                                ->get();
        } 
        //dd($users);
        return view('messages.newMessage', compact('users'));
    }

    /**
     * Send New Message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendNewMessage(Request $request) {
        $msg = $request->msg;
    	$friendId = $request->friend_id;
    	$myID = Session::get('AuthUser'); 


    	// check if conversation already started or not
    	$checkCon1 = DB::table('conversations')->where('user_one', $myID)
    		->where('user_two', $friendId)->get(); // if logged in user started the conversation

    	$checkCon2 = DB::table('conversations')->where('user_two', $myID)
    		->where('user_one', $friendId)->get(); // if logged in user received message first

    	$allCons = array_merge($checkCon1->toArray(), $checkCon2->toArray());

    	if(count($allCons) != 0){
            
    		// old conversation
    		$conId_old = $allCons[0]->id;
    		// insert data into messages table
    		$msgSent = DB::table('messages')->insert([
    			'user_from'       => $myID,
    			'user_to'         => $friendId,
    			'msg'             => $msg,
    			'conversation_id' => $conId_old,
    			'status'          => 1
    		]);
    	}else {
    		// new conversation
    		$conId_new = DB::table('conversations')->insertGetId([
    			'user_one' => $myID,
    			'user_two'  => $friendId
    		]);

    		$msgSent = DB::table('messages')->insert([
    			'user_from'       => $myID,
    			'user_to'         => $friendId,
    			'msg'             => $msg,
    			'conversation_id' => $conId_new,
    			'status'          => 1 
    		]);
    	}
    }

    /**
     * Start Contract
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function startContract(Request $request) {
        $AuthUser = Session::get('AuthUser');
        $conID = $request->conID;
        $conProposal = $request->conProposal;

     	$fetch_userTo = DB::table('messages')->where('messages.conversation_id', $conID)->get();

        if($fetch_userTo[0]->user_from == $AuthUser){
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_to;
        }else {
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_from;
        }

        // find the proposal in the table proposals 
        $proposal = Proposal::find($conProposal);

        $job = Job::find($proposal->job_id);
        $job->statusActiv = 2;
        $job->save();

        // update the status in the prorosals table
        if($proposal->current_proposal_status == 2){
            $proposal->current_proposal_status = 6;
            $proposal->save();
        }

        // save a new contract
        $id = DB::table('contracts')->insertGetId(
            ['proposalId'  => $conProposal,
            'clientId'     => $AuthUser,
            'freelancerId' => $proposal->freelancer_id,
            'startTime'    => now(),
            'paymentTypeId'=> $proposal->payment_type_id,
            'paymentAmount'=> $proposal->payment_amount
            ]
        );

    	// start contract message
        $sendM = DB::table('messages')->insert([
            'user_to'         => $userTo,
            'user_from'       => $AuthUser,
            'msg'             => 'started the contract',
            'status'          => 6,
            'conversation_id' => $conID
        ]);

        $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select('users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.status','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal','proposals.payment_amount','proposals.current_proposal_status as currentProposalStatus')
                        ->where('messages.conversation_id', $conID)
                        ->get();

        return $userMsg;   
    }

    /**
     * Finish Contract
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finishContract(Request $request) {
    	$AuthUser = Session::get('AuthUser');
        $conID = $request->conID;
        $conProposal = $request->conProposal;

        $fetch_userTo = DB::table('messages')->where('messages.conversation_id', $conID)->get();

        if($fetch_userTo[0]->user_from == $AuthUser){
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_to;
        }else {
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_from;
        }

        // find the proposal in the table proposals 
        $proposal = Proposal::find($conProposal);

        $job = Job::find($proposal->job_id);
        $job->statusActiv = 3;
        $job->save();

        // update the status in the prorosals table
        if($proposal->current_proposal_status == 6){
            $proposal->current_proposal_status = 7;
            $proposal->save();
        }

        // find the contract in the table proposals 
        $contractId = DB::table('contracts')->where('contracts.proposalId', '=', $conProposal)
                                            ->select('contracts.id')->first();

        $contract = Contract::find($contractId->id);
        // Update the endTime 
        $contract->endTime = now();
        $contract->save();

	    // end the contract message
	    $sendM = DB::table('messages')->insert([
	        'user_from'       => $AuthUser,
	        'user_to'         => $userTo,
	        'msg'             => 'ended the contract',
	        'status'          => 7,
	        'conversation_id' => $conID
	    ]);

       $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select('users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.status','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal','proposals.payment_amount','proposals.current_proposal_status as currentProposalStatus')
                        ->where('messages.conversation_id', $conID)
                        ->get();

        return $userMsg;
    }

    /**
     * Leave Review Client
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function leaveReviewClient(Request $request) {
        $conID = $request->conID;
        $proposalId = $request->conProposal;
        $reviewClient = $request->reviewClient;
        $rateClient = $request->rateClient;

        // find the contract id in the table proposals 
        $contractId = DB::table('contracts')->where('contracts.proposalId', '=', $proposalId)
                                            ->select('contracts.id')->first();
        // Save the review
        DB::table('reviews')->insert([
            'contractId'    => $contractId->id,
            'reviewClient'  => $reviewClient,
            'rateClient'    => $rateClient 
        ]);

        // find the proposal in the table proposals 
        $proposal = Proposal::find($proposalId);

        // update the status in the proposals table - review for Freelancer
        if($proposal->current_proposal_status == 7){
            $proposal->current_proposal_status = 9;
            $proposal->save();
        }

        $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('contracts', 'proposals.id', 'contracts.proposalId')
                        ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select('users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.status','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal','proposals.payment_amount','proposals.current_proposal_status as currentProposalStatus', 'reviews.reviewClient as reviewClient', 'reviews.rateClient as reviewClient')
                        ->where('messages.conversation_id', $conID)
                        ->get();

        return $userMsg;
    }

    /**
     * Leave Review Freelancer
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function leaveReviewFreelancer(Request $request) {
        $conID = $request->conID;
        $proposalId = $request->conProposal;
        $reviewFreelancer = $request->reviewFreelancer;
        $rateFreelancer = $request->rateFreelancer;

        // find the contract id in the table contracts
        $contractId = DB::table('contracts')->where('contracts.proposalId', '=', $proposalId)
                                            ->select('contracts.id')->first();

        // find the review
        $reviewId = DB::table('reviews')->where('reviews.contractId', '=', $contractId->id)
                                      ->select('reviews.id')->first();
        $review = Review::find($reviewId->id);
    
        // Update the review
        $review->reviewFreelancer = $reviewFreelancer;
        $review->rateFreelancer = $rateFreelancer;
        $review->save();

        // find the proposal in the table proposals 
        $proposal = Proposal::find($proposalId);

        // update the status in the proposals table - review for Client
        if($proposal->current_proposal_status == 9){
            $proposal->current_proposal_status = 10;
            $proposal->save();
        }

        $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('contracts', 'proposals.id', 'contracts.proposalId')
                        ->leftJoin('reviews', 'contracts.id', 'reviews.contractId')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select('users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.status','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal','proposals.payment_amount','proposals.current_proposal_status as currentProposalStatus', 'reviews.reviewClient as reviewClient', 'reviews.rateClient as rateClient','reviews.reviewFreelancer as reviewFreelancer', 'reviews.rateFreelancer as rateFreelancer')
                        ->where('messages.conversation_id', $conID)
                        ->get();

        return $userMsg;
    }

    /**
     * Leave Tip for a freelancer
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function leaveTip(Request $request) {
        $conID = $request->conID;
        $proposalId = $request->conProposal;
        $valueTip = $request->valueTip;
        $customTip = $request->customTip;

        // 1. Validate the data
        $this->validate($request, array(
            // rules 
            'customTip'  => 'required|integer|min:1|max:500'
        ));
    
        // Find the contract with the given proposal id 
        $contractId = DB::table('contracts')->where('contracts.proposalId', '=', $proposalId)
                                            ->select('contracts.id')->first();
        $contract = Contract::find($contractId->id);
        // Update the tipAmount 
        $contract->tipAmount = $customTip;
        $contract->save();

        // find the proposal in the table proposals 
        $proposal = Proposal::find($proposalId);

        echo 'proposal->current_proposal_status= ';
        echo $proposal->current_proposal_status;
        echo ' aaaaaaaaaaaaaaaaaa';
        // update the status in the proposals table - review for Client
        if($proposal->current_proposal_status == 9){
            $proposal->current_proposal_status = 11;
            $proposal->save();
        }


        $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select('users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.status','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal','proposals.payment_amount','proposals.current_proposal_status as currentProposalStatus')
                        ->where('messages.conversation_id', $conID)
                        ->get();

        return $userMsg;

        echo 'conID=';
        echo $conID;
        echo 'eeeeeeeeee';

        echo 'proposalId=';
        echo $proposalId;
        echo 'eeeeeeeeee';

        echo 'valueTip=';
        echo $valueTip;
        echo 'eeeeeeeeee';
        echo 'customTip=';
        echo $customTip;
        echo 'eeeeeeeeee';
        //echo $userMsg;
        echo 'eeeeeeeeee';
        //die();

        //return $userMsg;

        if ($valueTip == '' && $customTip != ''){
            try {
                // 1. Validate the data
                $this->validate($request, array(
                    // rules 
                    'customTip'  => 'required|integer|min:1|max:500'
                ));
            } catch (\Exception $e) {
                return $userMsg;
            } 

                $contract = Contract::find($contractId->id);
                // Update the tipAmount 
                $contract->tipAmount = $customTip;
                $contract->save();

                // find the proposal in the table proposals 
                $proposal = Proposal::find($proposalId);

                echo 'proposal->current_proposal_status= ';
                echo $proposal->current_proposal_status;
                echo ' aaaaaaaaaaaaaaaaaa';
                // update the status in the proposals table - review for Client
                if($proposal->current_proposal_status == 9){
                    $proposal->current_proposal_status = 11;
                    $proposal->save();
                }

                echo 'customTip=  ';
                echo $customTip;
                echo ' aaaaaaaaaaaaaaa';
                //die();
                /*$userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select('users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.status','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal','proposals.payment_amount','proposals.current_proposal_status as currentProposalStatus')
                        ->where('messages.conversation_id', $conID)
                        ->get();

                return $userMsg;*/
            
            
        } 
        elseif ($valueTip != ''){
            $contract = Contract::find($contractId->id);
            // Update the tipAmount 
            $contract->tipAmount = $valueTip;
            $contract->save();

            // find the proposal in the table proposals 
            $proposal = Proposal::find($proposalId);

            // update the status in the proposals table - review for Client
            if($proposal->current_proposal_status == 9){
                $proposal->current_proposal_status = 11;
                $proposal->save();
            }

            echo 'valueTip == ';
            echo $valueTip;
            echo ' bbbbbbbbbbbbbbb';
            //die();

            return $userMsg;
        }elseif ( $valueTip == '' && $customTip == ''){
            echo 'OOOOOOOOOOOOOOOOOOOOOOOOO = ';
            echo 'die ';
            //die();

            return $userMsg;
        }

        return $userMsg;

        //echo 'userMsg=';
        //echo $userMsg;
        //echo 'eeeeeeeeee';
        //die();                
    }
}
