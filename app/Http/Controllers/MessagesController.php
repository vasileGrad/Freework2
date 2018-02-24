<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
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
