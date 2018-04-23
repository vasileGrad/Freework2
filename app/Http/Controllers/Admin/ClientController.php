<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\User;
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
    	$clientsCount = DB::table('clients')->leftJoin('users', 'clients.user_id', '=', 'users.id')->where([
                ['users.role_id', '=', 3],
                ['users.statusActiv', '!=', 0]
            ])
            ->count();
        $clients = DB::table('clients')->leftJoin('users', 'clients.user_id', '=', 'users.id')
        	->select('users.id','users.firstName','users.lastName','users.location','users.country', 'users.image')
        	->where([
                ['users.role_id', '=', 3],
                ['users.statusActiv', '!=', 0]
            ])
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
                ['users.role_id', '=', 3],
                ['users.statusActiv', '!=', 0]
            ])
            ->orWhere([
                ['users.lastName', 'LIKE', '%'.$keyword.'%'],
                ['users.role_id', '=', 3],
                ['users.statusActiv', '!=', 0]
            ])
            ->orderBy('users.created_at','asc')->paginate(3);

        return view('adminPages.Clients.findClients', compact('clients'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showClient($id)
    {  
        $client = DB::table('users')->leftJoin('clients','users.id','clients.user_id')
                            ->select(DB::raw("(SELECT sum(contracts.paymentAmount) FROM contracts where (contracts.endTime != 'NULL' and contracts.clientId = '$id')) as payments"),
                                DB::raw("(SELECT count(contracts.endTime) FROM contracts where (contracts.endTime != 'NULL' and contracts.clientId = '$id')) as contracts"),
                                'users.id', 'users.firstName', 'users.lastName', 'users.country', 'users.location', 'users.image', 'users.statusActiv', 'users.created_at'
                            )
                            ->where([
                                ['users.id', '=', $id],
                                ['users.role_id', '=', 3],
                                ['users.statusActiv', '=', 1]
                            ])
                            ->first();                                                      
        return view('adminPages.Clients.showClient', compact('client'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showBlockedClient($id)
    {  
        $client = DB::table('users')->leftJoin('clients','users.id','clients.user_id')
                            ->select(DB::raw("(SELECT sum(contracts.paymentAmount) FROM contracts where (contracts.endTime != 'NULL' and contracts.clientId = '$id')) as payments"),
                                DB::raw("(SELECT count(contracts.endTime) FROM contracts where (contracts.endTime != 'NULL' and contracts.clientId = '$id')) as contracts"),
                                'users.id', 'users.firstName', 'users.lastName', 'users.country', 'users.location', 'users.image', 'users.statusActiv', 'users.created_at'
                            )
                            ->where([
                                ['users.id', '=', $id],
                                ['users.statusActiv', '=', 0]
                            ])
                            ->first();                                                        
        return view('adminPages.Clients.showClient', compact('client'));
    }

    /**
     * Block specified client
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blockClient($id)
    {   
        $user = User::find($id);
        $user->statusActiv = 0;
        $user->save();

        // Set flash data with success message
        Session::flash('success', 'This Client was successfully blocked!');
        
        return redirect()->route('findClients');
    }

    /**
     * Unblock specified client
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unblockClient($id)
    {   
        $user = User::find($id);
        $user->statusActiv = 1;
        $user->save();

        // Set flash data with success message
        Session::flash('success', 'This Client was successfully unblocked!');
        // redirect with flash data to posts.show
        return redirect()->route('blockedClients');
    }

    /**
     * Show blocked clients.
     *
     * @return \Illuminate\Http\Response
     */
    public function blockedClients()
    {   
        $clients = DB::table('clients')->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->select('users.id','users.firstName','users.lastName','users.location','users.country', 'users.image')
            ->where([
                ['users.role_id', '=', 3],
                ['users.statusActiv', '=', 0]
            ])
            ->orderBy('clients.id','desc')->paginate(3);

        return view('adminPages.Clients.blockedClients', compact('clients'));
    }

    /**
     * Find specific client.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function blockedClientsFilter(Request $request)
    {
        $search = $request->input('search');
        if($search != '')
            $keyword = $search;
        else
            $keyword = '';
        $clients = DB::table('clients')->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->select('users.id','users.firstName','users.lastName','users.location','users.country', 'users.image')
            ->where([
                ['users.role_id', '=', 3],
                ['users.statusActiv', '=', 0],
                ['users.firstName', 'LIKE', '%'.$keyword.'%']
            ])
            ->orWhere([
                ['users.role_id', '=', 3],
                ['users.statusActiv', '=', 0],
                ['users.lastName', 'LIKE', '%'.$keyword.'%']
            ])
            ->orderBy('clients.id','desc')->paginate(3);

        return view('adminPages.Clients.blockedClients', compact('clients'));
    } 
}
