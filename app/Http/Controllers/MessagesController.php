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
                ->where('messages.conversation_id', $conID)->get();
            return $userMsg;
        }else{
            echo 'not sent';
        }
    }
}
