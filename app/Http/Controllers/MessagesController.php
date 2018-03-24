<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Conversation;
use App\Message;
use App\Events\NewMessageEvent;

class MessagesController extends Controller
{
    public function messages() {
        return view('messages.messages');
    }

    public function getMessages() {
        // the persons who sent me messages
        $allUsers1 = DB::table('users') 
            ->Join('conversations', 'users.id', 'conversations.user_one')
            ->where('conversations.user_two', Auth::user()->id)
            ->get();
        //return $allUsers;

        // the persons to whom I have sent the messages
        $allUsers2 = DB::table('users') 
            ->Join('conversations', 'users.id', 'conversations.user_two')
            ->where('conversations.user_one', Auth::user()->id)
            ->get();
        //dd($allUsers2);

        // combine all the users
        return array_merge($allUsers1->toArray(), $allUsers2->toArray());
    }

    public function sendMessage(Request $request) {
        $conID = $request->conID;
        $msg = $request->msg;

        $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)->get();

        if($fetch_userTo[0]->user_from == Auth::user()->id){
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_to;
        }else {
            // fetch user_to
            $userTo = $fetch_userTo[0]->user_from;
        }

        // now send message
        $sendM = DB::table('messages')->insert([
            'user_to'         => $userTo,
            'user_from'       => Auth::user()->id,
            'msg'             => $msg,
            'status'          => 1,
            'conversation_id' => $conID
        ]);

        $message = Message::where('user_to', $userTo)
                            ->where('user_from', Auth::user()->id)
                            ->where('msg', $msg)
                            ->where('conversation_id', $conID)
                            ->first();


        //broadcast(new NewMessageEvent($message))->toOthers();
        event(new NewMessageEvent($message));

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
        $uid = Auth::user()->id;
        //dd($uid);
        if(Auth::user()->role_id == 2 && Auth::guard('freelancer')){
            $users = DB::table('users')->leftJoin('clients', 'users.id', '=', 'clients.user_id')
                                ->where('role_id', '=', 3)
                                ->select('users.id', 'users.firstName', 'users.lastName', 'users.country', 'users.location', 'users.image')
                                ->get();
        }
        elseif(Auth::user()->role_id == 3 && Auth::guard('client')){
            $users = DB::table('users')->leftJoin('freelancers', 'users.id', '=', 'freelancers.user_id')
                                ->where('role_id', '=', 2)
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

    public function sendNewMessage(Request $request) {
        $msg = $request->msg;
    	$friendId = $request->friend_id;
    	$myID = Auth::user()->id;


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
	        	->where('user_from', $idAuth)
	        	->where('user_to', $userTo)
	        	->get();

        	// now send message
	        $sendM = DB::table('messages')->insert([
	            'user_to'         => $userTo,
	            'user_from'       => $idAuth,
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
