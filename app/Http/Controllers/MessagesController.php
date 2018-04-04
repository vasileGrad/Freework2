<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Conversation;
use App\Message;
use App\Proposal;
use Session;
use App\Events\NewMessageEvent;

class MessagesController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth:client');
    }*/

    public function getGuard() {
        //$AuthUserRole = Session::get('AuthUserRole');
        $AuthUser = Session::get('AuthUser');
        dd($AuthUser);

        //dd(Auth::check());
        if(Auth::check()){
            return 2;
        }else{
            return 3;
        }
    }

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

        /*$AuthUserRole = Session::get('AuthUserRole');

        if($AuthUserRole == 3){
            $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                    ->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                    ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                    ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                    ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                    ->select('users.firstName', 'users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal')
                    ->where('messages.conversation_id', 35)
                    ->get();
        }

        if($AuthUserRole == 2){
            $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                    ->leftJoin('freelancers', 'users.id', 'freelancers.user_id')
                    ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                    ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                    ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                    ->select('users.firstName', 'users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal')
                    ->where('messages.conversation_id', 35)
                    ->get();
        } */

        /*$id = 35;
        $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select(DB::raw('(SELECT(firstName) FROM proposals
                            left join freelancers on proposals.freelancer_id = freelancers.id
                            left join users on freelancers.user_id = users.id
                            left join conversations on proposals.id = conversations.proposal_id) as firstNameShow'),
                                DB::raw('(SELECT(lastName) FROM proposals
                            left join freelancers on proposals.freelancer_id = freelancers.id
                            left join users on freelancers.user_id = users.id
                            left join conversations on proposals.id = conversations.proposal_id) as lastNameShow'),
                            'users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal')
                        ->where('messages.conversation_id', $id)
                        ->get();
            
            dd($userMsg);*/

        //$userMsg = DB::select('messages_get(?)', array($id));
        //dd($jobs);
        //dd($userMsg);
        //dd([$user, $userId]);
        return view('messages.messages', compact('user','userId'));
    }

    public function getMessages() {
        $AuthUser = Session::get('AuthUser');

        /*// the persons who sent me messages
        $allUsers1 = DB::table('users') 
            ->leftJoin('conversations', 'users.id', 'conversations.user_one')
            ->where('conversations.user_two', $AuthUser)
            ->get();
        //dd($allUsers1);

        // the persons to whom I have sent the messages
        $allUsers2 = DB::table('users') 
            ->Join('conversations', 'users.id', 'conversations.user_two')
            ->where('conversations.user_one', $AuthUser)
            ->get();*/


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

        /*$AuthUserRole = Session::get('AuthUserRole');

        if($AuthUserRole == 3){
            $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                    ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                    ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                    ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                    ->select('users.firstName', 'users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal')
                    ->where('messages.conversation_id', $id)
                    ->get();
        }elseif($AuthUserRole == 2){
            $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                    ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                    ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                    ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                    ->select('users.firstName', 'users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal')
                    ->where('messages.conversation_id', $id)
                    ->get();
        }*/

        $AuthUserRole = Session::get('AuthUserRole');

        if($AuthUserRole == 2){
            $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
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
                            'users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal')
                        ->where('messages.conversation_id', $id)
                        ->get();
        //dd($userMsg1);
        }elseif($AuthUserRole == 3){
            $userMsg = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_from')
                        ->leftJoin('conversations', 'messages.conversation_id', 'conversations.id')
                        ->leftJoin('proposals', 'conversations.proposal_id', 'proposals.id')
                        ->leftJoin('jobs', 'proposals.job_id', 'jobs.id')
                        ->select(DB::raw("(SELECT(firstName) FROM proposals
                            left join freelancers on proposals.freelancer_id = freelancers.id
                            left join users on freelancers.user_id = users.id
                            left join conversations on proposals.id = conversations.proposal_id where conversations.id = '$id') as firstNameShow"),
                                DB::raw("(SELECT(lastName) FROM proposals
                            left join freelancers on proposals.freelancer_id = freelancers.id
                            left join users on freelancers.user_id = users.id
                            left join conversations on proposals.id = conversations.proposal_id where conversations.id = '$id') as lastNameShow"),
                            'users.firstName','users.lastName','users.image', 'jobs.id as jobId','jobs.title as jobTitle','messages.msg','messages.user_from','messages.conversation_id','messages.created_at', 'conversations.proposal_id as conProposal')
                        ->where('messages.conversation_id', $id)
                        ->get();
            
            //dd($userMsg);
        }

        //$userMsg = DB::select('messages_get(?)', [$conv_id]);
        //dd($jobs);
        //dd($userMsg);

        //dd($userMsg);
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
        $proposal_id = (int)$proposal_id;

        $proposal = Proposal::find($proposal_id);
        $proposal->current_proposal_status = 2;
        $proposal->save();

        $freelancer_id = DB::table('proposals')->join('freelancers', 'proposals.freelancer_id', '=', 'freelancers.id')
                                                ->select('freelancers.user_id')
                                                ->where('proposals.id', '=', $proposal_id)
                                                ->first();

        //dd([$AuthUser, $freelancer_id->user_id, $proposal_id]);
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

        return redirect()->route('messages');
    }

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
            $userMsg = DB::table('messages')
                ->leftJoin('users', 'users.id', 'messages.user_from')
                ->where('messages.conversation_id', $conID)
                ->get();
            return $userMsg;
        }else{
            echo 'not sent';
        }
    }

    public function newMessage(){
        //$uid = Auth::user()->id;
        /*if (Auth::check())
        {
            dd(['yes', Auth::user()->id, Auth::user()->firstName, Auth::guard('client')]);
        }else{
            dd('no');
        }*/

        //dd(Auth::user()->id);
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

      /*$uid = Auth::user()->id;
      $friends1 = DB::table('friendships')
          ->leftJoin('users', 'users.id', 'friendships.user_requested') // who is not logged in but send request to
          ->where('status', 1)
          ->where('requester', $uid) // who is loggedin
          ->get();
      $friends2 = DB::table('friendships')
          ->leftJoin('users', 'users.id', 'friendships.requester')
          ->where('status', 1)
          ->where('user_requested', $uid)
          ->get();
      $friends = array_merge($friends1->toArray(), $friends2->toArray());
      return view('newMessage', compact('friends', $friends));*/
    }

    /**
     * Get Messages
     *
     * @return \Illuminate\Http\Response
     */
    /*public function getMessages($id) {
        $userMsg = DB::table('messages')
                        ->leftJoin('users', 'users.id', 'messages.user_from')
                        ->where('messages.conversation_id', $id)
                        ->get();

        return $userMsg;
    }*/

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

    public function startContract(Request $request) {
        $AuthUser = Session::get('AuthUser');
        $conID = $request->conID;
        $conProposal = $request->conProposal;

     	$fetch_userTo = DB::table('messages')->where('conversation_id', $conID)->get();

        if($fetch_userTo[0]->user_from == $AuthUser){
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_to;
        }else {
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_from;
        }

        // check if you started or not the contract
        $checkStartContract = DB::table('messages')
        	->where('conversation_id', $conID)
        	->where('user_from', $AuthUser)
        	->where('user_to', $userTo)
        	->where('status', 3)
        	->get();

        if(count($checkStartContract) != 0) {
        	$userMsg = DB::table('messages')
	            ->leftJoin('users', 'users.id', 'messages.user_from')
	            ->where('messages.conversation_id', $conID)
	            ->get();
	        return $userMsg;
        }else {
        	// fetch the usert_to row
        	$userToName = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_to')
	        	->where('conversation_id', $conID)
	        	->where('user_from', $AuthUser)
	        	->where('user_to', $userTo)
	        	->get();

        	// now send message
	        $sendM = DB::table('messages')->insert([
	            'user_to'         => $userTo,
	            'user_from'       => $AuthUser,
	            'msg'             => 'started the contract',
	            /*'msg'             => ucwords(Auth::user()->firstName) . ' ' . ucwords(Auth::user()->lastName) . ' started the contract with the freelancer '. ucwords($userToName[0]->firstName),*/
	            'status'          => 3,
	            'conversation_id' => $conID
	        ]);

	        if($sendM){
	            $userMsg = DB::table('messages')
	                ->leftJoin('users', 'users.id', 'messages.user_from')
	                ->where('messages.conversation_id', $conID)
	                ->get();
	            return $userMsg;
	        }else{
	            echo 'not sent';
	        }
        }
        
    }

    public function finishContract(Request $request) {
    	$idAuth = Auth::user()->id;
        $conID = $request->conID;

        $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)->get();

        if($fetch_userTo[0]->user_from == $idAuth){
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_to;
        }else {
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_from;
        }
        // check if you started or not the contract
        $checkStartContract = DB::table('messages')
        	->where('conversation_id', $conID)
        	->where('user_from', $idAuth)
        	->where('user_to', $userTo)
        	->where('status', 3)
        	->get();

        // check if you finished or not the contract
        $checkFinishContract = DB::table('messages')
        	->where('conversation_id', $conID)
        	->where('user_from', $idAuth)
        	->where('user_to', $userTo)
        	->where('status', 4)
        	->get();

        if(count($checkStartContract) == 0 || count($checkFinishContract) != 0) {
    		$userMsg = DB::table('messages')
	            ->leftJoin('users', 'users.id', 'messages.user_from')
	            ->where('messages.conversation_id', $conID)
	            ->get();
	        return $userMsg;
        }else {
        	// fetch the usert_to row
        	$userToName = DB::table('messages')->leftJoin('users', 'users.id', 'messages.user_to')
	        	->where('conversation_id', $conID)
	        	->where('user_from', $idAuth)
	        	->where('user_to', $userTo)
	        	->get();

		    // now send message
		    $sendM = DB::table('messages')->insert([
		        'user_from'       => $idAuth,
		        'user_to'         => $userTo,
		        'msg'             => 'ended the contract',
	            /*'msg'             => ucwords(Auth::user()->firstName) . ' ' . ucwords(Auth::user()->lastName) . ' ended the contract with the freelancer '. ucwords($userToName[0]->firstName),*/
		        'status'          => 4,
		        'conversation_id' => $conID
		    ]);

		    if($sendM){
		        $userMsg = DB::table('messages')
		            ->leftJoin('users', 'users.id', 'messages.user_from')
		            ->where('messages.conversation_id', $conID)
		            ->get();
		        return $userMsg;
		    }else{
		        echo 'not sent';
		    }
		}
    }
}
