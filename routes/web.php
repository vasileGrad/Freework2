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
    Route::get('/findFreelancers', 'Admin\FreelancerController@findFreelancers')->name('findFreelancers');
    Route::get('/findFreelancerFilter', 'Admin\FreelancerController@findFreelancerFilter')->name('findFreelancerFilter');
    Route::get('/findClients', 'Admin\ClientController@findClients')->name('findClients');
    Route::get('/findClientFilter', 'Admin\ClientController@findClientFilter')->name('findClientFilter');
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
    
    Route::get('/showFreelancer/{id}', 'Admin\FreelancerController@showFreelancer')->name('showFreelancer');
    Route::get('/showBlockedFreelancer/{id}', 'Admin\FreelancerController@showBlockedFreelancer')->name('showBlockedFreelancer');

    Route::get('/showClient/{id}', 'Admin\ClientController@showClient')->name('showClient');
    Route::get('/showBlockedClient/{id}', 'Admin\ClientController@showBlockedClient')->name('showBlockedClient');

    Route::put('/blockJob/{id}', 'Admin\JobController@blockJob')->name('blockJob');
    Route::get('/blockedJobs', 'Admin\JobController@blockedJobs')->name('blockedJobs');
    Route::get('/blockedJobsFilter', 'Admin\JobController@blockedJobsFilter')->name('blockedJobsFilter');
    Route::put('/unblockJob/{id}', 'Admin\JobController@unblockJob')->name('unblockJob');


    Route::post('/blockFreelancer/{id}', 'Admin\FreelancerController@blockFreelancer')->name('blockFreelancer');
    Route::get('/blockedFreelancers', 'Admin\FreelancerController@blockedFreelancers')->name('blockedFreelancers');
    Route::get('/blockedFreelancersFilter', 'Admin\FreelancerController@blockedFreelancersFilter')->name('blockedFreelancersFilter');
    Route::post('/unblockFreelancer/{id}', 'Admin\FreelancerController@unblockFreelancer')->name('unblockFreelancer');

    Route::post('/blockClient/{id}', 'Admin\ClientController@blockClient')->name('blockClient');
    Route::get('/blockedClients', 'Admin\ClientController@blockedClients')->name('blockedClients');
    Route::get('/blockedClientsFilter', 'Admin\ClientController@blockedClientsFilter')->name('blockedClientsFilter');
    Route::post('/unblockClient/{id}', 'Admin\ClientController@unblockClient')->name('unblockClient');
});

// Freelancer pages
Route::prefix('freelancer')->group(function() {
    //Route::resource('freelancerProfile', 'Freelancer\ProfileController');
    Route::get('freelancerProfile/{id}', 'Freelancer\ProfileController@freelancerProfile')->name('freelancerProfile');
    Route::post('/saveJob/{id}', 'Freelancer\JobController@saveJob')->name('saveJob');
    Route::post('/unsaveJob/{id}', 'Freelancer\JobController@unsaveJob')->name('unsaveJob');
    Route::get('/jobSaved', 'Freelancer\JobController@jobSaved')->name('jobSaved');
    Route::resource('freelancerProposal', 'Freelancer\ProposalController', ['except' => ['store']]);
    Route::post('/createProposal/{id}', 'Freelancer\ProposalController@createProposal')->name('createProposal');
    Route::post('/storeProposal/{job_id}', 'Freelancer\ProposalController@storeProposal')->name('storeProposal');


    Route::get('/goBack', 'Freelancer\SearchController@goBack')->name('goBack');
    Route::get('/goBackProposals', 'Freelancer\ProposalController@goBackProposals')->name('goBackProposals');
    
    Route::get('/jobSearch', 'Freelancer\SearchController@search')->name('jobSearch');
    Route::get('/jobSearchFilter', 'Freelancer\SearchController@searchFilters')->name('jobSearchFilter');
    Route::get('/jobShow/{id}', 'Freelancer\SearchController@jobShow')->name('jobShow');
    
    Route::get('/contractsFinish/{user_id}', 'Freelancer\JobController@contractsFinish')->name('contractsFinish');
    Route::get('contractsNow/{user_id}', 'Freelancer\JobController@contractsNow')->name('contractsNow');
    Route::get('/downloadFileFreelancer/{file_name}', 'Freelancer\SearchController@downloadFileFreelancer')->name('downloadFileFreelancer');
    Route::get('/earnings/{user_id}', 'Freelancer\JobController@earnings')->name('earnings');
});

// Profile Freelancer ajax calls
Route::post('/updateTitle', 'Freelancer\ProfileController@updateTitle');
Route::post('/updateOverview', 'Freelancer\ProfileController@updateOverview');

// Client pages
Route::prefix('client')->group(function() {
    Route::resource('jobs', 'Client\JobController');
    Route::get('clientProfile/{id}', 'Client\ProfileController@clientProfile')->name('clientProfile');
    Route::get('/showProposal/{freelancer_id}', 'Client\JobController@showProposal')->name('showProposal');
    Route::get('goBackProposal/{id}', 'Client\JobController@goBackProposal')->name('goBackProposal');
    Route::get('/goBackJobs', 'Client\JobController@goBackJobs')->name('goBackJobs');
    Route::resource('freelancerSearch', 'Client\SearchFreelancerController');
    Route::post('/freelancerSearch', 'Client\SearchFreelancerController@searchFilter')->name('freelancerSearchFilter');
    
    Route::post('/searchInviteFreelancers', 'Client\SearchFreelancerController@searchInviteFreelancers')->name('searchInviteFreelancers');
    Route::get('myFreelancers/{user_id}', 'Client\SearchFreelancerController@myFreelancers')->name('myFreelancers');
    Route::get('workProgress/{user_id}', 'Client\JobController@workProgress')->name('workProgress');
    Route::get('contracts/{user_id}', 'Client\JobController@contracts')->name('contracts');
    Route::get('/downloadFileClient/{file_name}', 'Client\JobController@downloadFileClient')->name('downloadFileClient');
    Route::get('inviteFreelancers/{job_id}', 'Client\JobController@inviteFreelancers')->name('inviteFreelancers');
    Route::get('inviteFreelancer/{user_id}/{job_id}', 'Client\SearchFreelancerController@inviteFreelancer')->name('inviteFreelancer');
    Route::get('contractsFinishFreelancer/{user_id}', 'Client\SearchFreelancerController@contractsFinishFreelancer')->name('contractsFinishFreelancer');
    Route::get('createInvitation/{user_id}/{job_id}', 'Client\InviteFreelancerController@createInvitation')->name('createInvitation');
    Route::post('saveInvitation/{user_id}/{job_id}', 'Client\InviteFreelancerController@saveInvitation')->name('saveInvitation');
});

// Messages
Route::get('newMessage', 'MessagesController@newMessage')->name('newMessage');
Route::post('sendNewMessage', 'MessagesController@sendNewMessage');
Route::post('/sendMessage', 'MessagesController@sendMessage');
Route::get('/messages', 'MessagesController@messages')->name('messages');
Route::post('/messageProposal/{proposal_id}', 'MessagesController@messageProposal')->name('messageProposal');
Route::get('/getMessages', 'MessagesController@getMessages')->name('getMessages');
Route::get('/getMessagesId/{id}', 'MessagesController@getMessagesId')->name('getMessagesId');
Route::post('/startContract', 'MessagesController@startContract');
Route::post('/finishContract', 'MessagesController@finishContract');
Route::post('/leaveReviewClient', 'MessagesController@leaveReviewClient')->name('leaveReviewClient');
Route::post('/leaveReviewFreelancer', 'MessagesController@leaveReviewFreelancer')->name('leaveReviewFreelancer');
Route::post('/leaveTip', 'MessagesController@leaveTip')->name('leaveTip');
