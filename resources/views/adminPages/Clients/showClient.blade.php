@extends('main')

@section('title', '| Show Client Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mainUser">
            <div class="panel panel-default">
                <div class="panel-body">
        			<div class="row">
        				<div class="col-md-12 col-sm-12">
        					<div class="col-md-3 col-sm-3">
				    			<img src="{{ asset('images/profile/' . $client->image) }}" alt="" class="image-radius-freelancer" height="110" width="110"/>
				    		</div>
        					<div class="col-md-6 col-sm-6">
						  		<br><h3 class="list-group-item-heading"><strong>{{ $client->firstName }} {{ $client->lastName }}</strong></h3><br>
						  		@php
						    		$payments = "$client->payments";
						    	@endphp
						    	@if($payments != '')
						    		<h5><b>${{ $payments }} Total spent</b></h5>
						    	@else
						    		<h5><b>No payments</b></h5>
						    	@endif
						    	@php
						    		$contracts = "$client->contracts";
						    	@endphp
						    	@if($contracts != 0)
						    		@if($contracts == 1)
						    			<h5><b>{{ $contracts }} Contract done</b></h5>
						    		@else
						    			<h5><b>{{ $contracts }} Contracts done</b></h5>
						    		@endif
						    	@else
						    		<h5><b>No contracts</b></h5>
						    	@endif
						    	<br>
						    	<h5><b>Member since: </b>{{ date('M j, Y', strtotime($client->created_at)) }}</h5> 
						    </div>
						    <div class="col-md-3 col-sm-3">
						    	<br><h5><span class="glyphicon glyphicon-map-marker"><b>{{$client->location}}</b></span></h5>
						    	<h5>&ensp;&ensp;<b>{{ $client->country }}</b></h5><br>
						    </div>
        				</div>
					</div><hr>
                </div>
        	</div>
    	</div>
    	<div class="col-md-3 col-sm-12 mainUser">
    		<div class="panel panel-default">
                <div class="panel-body">
					<div class="col-md-12 col-sm-6"><br>
						@if($client->statusActiv == 1)
							<form method="POST" action="{{ route('blockClient', $client->id) }}">
				            	{{ csrf_field() }}
				                <button type="submit" class="btn btn-danger btn-block">Block Client</button>
				            </form>
						@elseif($client->statusActiv == 0)
							<form method="POST" action="{{ route('unblockClient', $client->id) }}">
				            	{{ csrf_field() }}
				                <button type="submit" class="btn btn-danger btn-block">Unblock Client</button>
				            </form>
						@endif
						<br><hr>
					</div>
                </div>
        	</div>
    	</div>
	</div>
@endsection