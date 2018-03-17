<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/*Broadcast::channel('conversation.{id}', function ($user, $id) {
    //return true;  // only login users
    // Author of the post has access

    // Grab the user id of this post and compare with the user_id that is trying to access the channel
    
    return $user->id == 1;
    //return $user->id == \App\Message::where('conversation_id', $id)->where('user_to', $user->id)->first();
});*/

Broadcast::channel('conversation.{id}', function ($user, $id) {
	return true; /*\App\Message::where('conversation_id', '13')->where('user_to', $user->id)->first()*/;
});
