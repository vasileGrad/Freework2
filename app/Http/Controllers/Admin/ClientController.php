<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Find specific freelancers.
     *
     * @return \Illuminate\Http\Response
     */
    public function findClients()
    {
    	$clientsCount = DB::table('clients')->leftJoin('users', 'clients.user_id', '=', 'users.id')->where('users.role_id', '=', 3)
            ->count();
        $clients = DB::table('clients')->leftJoin('users', 'clients.user_id', '=', 'users.id')
        	->select('users.id','users.firstName','users.lastName','users.location','users.country', 'users.image')
        	->where('users.role_id', '=', 3)
            ->orderBy('users.created_at','asc')->paginate(3);

        //dd([$clientsCount,$clients]);
        return view('adminPages.Clients.findClients', compact('clientsCount','clients'));
    }

    /**
     * Find specific freelancer.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findClientFilter(Request $request)
    {
    	$search = $request->input('search');
        if($search != null)
            $keyword = $search;
        else
            $keyword = '';

        $clients = DB::table('clients')->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->select('users.id','users.firstName','users.lastName','users.location','users.country', 'users.image')
            ->where([
                ['users.firstName', 'LIKE', '%'.$keyword.'%'],
                ['users.role_id', '=', 3]
            ])
            ->orWhere([
                ['users.lastName', 'LIKE', '%'.$keyword.'%'],
                ['users.role_id', '=', 3]
            ])
            ->orderBy('users.created_at','asc')->paginate(3);

        return view('adminPages.Clients.findClients', compact('clients'));
    }

    
}
