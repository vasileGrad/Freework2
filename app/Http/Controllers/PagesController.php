<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PagesController extends Controller 
{
    public function getIndex() {
    	$clients = DB::table('clients')->leftJoin('users', 'clients.user_id', '=', 'users.id')
    		->where('users.role_id', '=', 3)
    		->count();

    	$freelancers = DB::table('freelancers')->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
    		->where('users.role_id', '=', 2)
    		->count();

    	$jobs = DB::table('jobs')->count();
        
    	return view('pages.welcome', compact(['clients','freelancers','jobs']));
	}
}
