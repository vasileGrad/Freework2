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
Auth::routes(); 
Route::get('/', 'PagesController@getIndex')->name('main');
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

// Admin Profile
Route::prefix('admin')->group(function() {
    Route::get('/findFreelancers', 'AdminController@findFreelancers')->name('findFreelancers');
    Route::get('/findClients', 'AdminController@findClients')->name('findClients');
    Route::get('/findJobs', 'AdminController@findJobs')->name('findJobs');
    Route::resource('skills', 'Admin\SkillController');
    Route::get('/findSkill', 'Admin\SkillController@findSkill')->name('findSkill');
    Route::get('/showSkills', 'Admin\SkillController@showSkills')->name('showSkills');
    Route::resource('categories', 'Admin\CategoryController');
    Route::get('/findCategory', 'Admin\CategoryController@findCategory')->name('findCategory');
    Route::get('/showCategories', 'Admin\CategoryController@showCategories')->name('showCategories');
    Route::get('/findJob', 'Admin\JobController@findJob')->name('findJob');
    Route::get('/findJobFilter', 'Admin\JobController@findJobFilter')->name('findJobFilter');
    Route::get('/showJob/{id}', 'Admin\JobController@showJob')->name('showJob');
    Route::get('/showBlockedJob/{id}', 'Admin\JobController@showBlockedJob')->name('showBlockedJob');
    Route::put('/blockJob/{id}', 'Admin\JobController@blockJob')->name('blockJob');
    Route::get('/blockedJobs', 'Admin\JobController@blockedJobs')->name('blockedJobs');
    Route::get('/blockedJobsFilter', 'Admin\JobController@blockedJobsFilter')->name('blockedJobsFilter');
    Route::put('/unblockJob/{id}', 'Admin\JobController@unblockJob')->name('unblockJob');

});

// Freelancer pages
Route::prefix('freelancer')->group(function() {
    Route::resource('freelancerProfile', 'Freelancer\ProfileController');
    Route::post('/saveJob/{id}', 'Freelancer\JobController@saveJob')->name('saveJob');
    Route::post('/unsaveJob/{id}', 'Freelancer\JobController@unsaveJob')->name('unsaveJob');
    Route::get('/jobSaved', 'Freelancer\JobController@jobSaved')->name('jobSaved');
    Route::get('/goBack', 'Freelancer\JobController@goBack')->name('goBack');
    


    Route::get('/jobSearch', 'Freelancer\SearchController@search')->name('jobSearch');
    Route::get('/jobSearchFilter', 'Freelancer\SearchController@searchFilters')->name('jobSearchFilter');
    Route::get('/jobShow/{id}', 'Freelancer\SearchController@jobShow')->name('jobShow');
    
    
});

//Route::resource('jobSaved', 'Freelancer\JobSavedController');
Route::post('/updateTitle', 'Freelancer\ProfileController@updateTitle');
Route::post('/updateOverview', 'Freelancer\ProfileController@updateOverview');


Route::resource('jobs', 'Client\JobController');
Route::resource('freelancerSearch', 'Client\SearchFreelancerController');
Route::post('/freelancerSearch', 'Client\SearchFreelancerController@searchFilter')->name('freelancerSearchFilter');



Route::get('newMessage', 'MessagesController@newMessage')->name('newMessage');
Route::post('sendNewMessage', 'MessagesController@sendNewMessage');
Route::post('sendMessage', 'MessagesController@sendMessage');


Route::post('/startContract', 'MessagesController@startContract');

Route::post('/finishContract', 'MessagesController@finishContract');


Route::get('/messages', 'MessagesController@messages')->name('messages');

Route::get('/getMessages', 'MessagesController@getMessages')->name('getMessages');


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
