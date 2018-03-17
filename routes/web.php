<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'PagesController@getIndex')->name('main');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function() {
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('/', 'AdminController@index')->name('admin.dashboard');
	Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});

Route::prefix('client')->group(function() {
    Route::get('/login', 'Auth\ClientLoginController@showLoginForm')->name('client.login');
    Route::post('/login', 'Auth\ClientLoginController@login')->name('client.login.submit');

    Route::get('/register', 'Auth\ClientRegisterController@showRegistrationForm')->name('client.register');
    Route::post('/register', 'Auth\ClientRegisterController@register')->name('client.register.submit');
    Route::get('/', 'ClientController@index')->name('client.dashboard');
});

Route::prefix('freelancer')->group(function() {
	Route::get('/login', 'Auth\FreelancerLoginController@showLoginForm')->name('freelancer.login');
	Route::post('/login', 'Auth\FreelancerLoginController@login')->name('freelancer.login.submit');

	Route::get('/register', 'Auth\FreelancerRegisterController@showRegistrationForm')->name('freelancer.register');
	Route::post('/register', 'Auth\FreelancerRegisterController@register')->name('freelancer.register.submit');
	Route::get('/', 'FreelancerController@index')->name('freelancer.dashboard');
});

Route::resource('jobs', 'Client\JobController');

Route::post('/jobSearch', 'Freelancer\SearchController@search')->name('jobSearch');
Route::get('/jobShow/{id}', 'Freelancer\SearchController@show')->name('jobShow');
Route::post('/jobShow/{freelancerId}', 'Freelancer\JobSavedController@store')->name('jobSaved.store');

Route::get('/jobSaved', 'Freelancer\JobSavedController@index')->name('jobSaved');

//Route::resource('jobSaved', 'Freelancer\JobSavedController');
Route::resource('showJob', 'Freelancer\ShowController');

Route::resource('freelancerProfile', 'Freelancer\ProfileController');

Route::resource('freelancerSearch', 'Client\SearchFreelancerController');


Route::post('/updateTitle', 'Freelancer\ProfileController@updateTitle');
Route::post('/updateOverview', 'Freelancer\ProfileController@updateOverview');


Route::get('newMessage','MessagesController@newMessage');
Route::post('sendNewMessage', 'MessagesController@sendNewMessage');
Route::post('sendMessage', 'MessagesController@sendMessage');


Route::post('/startContract', 'MessagesController@startContract');

Route::post('/finishContract', 'MessagesController@finishContract');


Route::get('/messages', function () {
	/*$privateMsgs = DB::table('users')	
    	->where('id', '!=', Auth::user()->id)
    	->get();

    return view('/messages', compact('privateMsgs'));*/
	    return view('messages.messages');
	});

Route::get('/getMessages', function () {
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
});

Route::get('/getMessages/{id}', function ($id) {
    // check Conversation
    /*$checkCon = DB::table('conversations')->where('user_one', Auth::user()->id)
    	->where('user_two', $id)->get();
    if(count($checkCon)!=0){
    	//echo $checkCon[0]->id;
    	// fetch msgs
    	$userMsg = DB::table('messages')->where('messages.conversation_id', $checkCon[0]->id)->get();
    	return $userMsg;
    }else{
    	echo "no messages";
    }*/
    $userMsg = DB::table('messages')
    	->leftJoin('users', 'users.id', 'messages.user_from')
    	->where('messages.conversation_id', $id)
    	->get();
    return $userMsg;

});
