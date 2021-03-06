@extends('main')

@section('title', '| Blocked Clients Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
        				<div class="col-md-12">
		                	<form method="GET" action="{{ route("blockedClientsFilter") }}">
				            	{{ csrf_field() }}
								<div class="input-group col-md-6 col-sm-6 padding-left mainUser">
				                    <input type="text" name="search" class="form-control" aria-label="..." placeholder="Search for Clients">
				                    <div class="input-group-btn">
				                        <button type="submit" class="btn btn-default">Submit</button>
				                    </div>
				            	</div>
				                
				                <br><br>
				            
				            	<div class="row padding-left">
				            		@if($clients->total() === 1)
					            	<h4><span class="badge">{{ $clients->total() }}</span> Client found</h4>
					            	
					            	@else
					            		<h4><span class="badge">{{ $clients->total() }}</span> Clients found</h4>
					            	@endif
				            	</div>
					        </form>
				    	</div>
                	</div>
                </div>
                <div class="panel-body">
                	<div class="list-group">
                		@if($clients->total() == 0)
		                	<div class="list-group center-title">
		                		<span class="list-group-item-text">
		                			<div class="col-sm-12">
		                				<h3 class="list-group-item-text"><strong>No clients blocked</strong></h3>
		                			</div>
		                		</span><br><br><br>
			                </div>
			            @else
	                		@foreach ($clients as $client)
	                			<div class="list-group">
				                    <a href="{{ route('showBlockedClient', $client->id)}}" class="list-group-item"><br>
				                		<span class="list-group-item-text">
				                    		<div class="row">
				                    			<div class="col-sm-2">
				                    				<img src="{{ asset('images/profile/' . $client->image) }}" alt="" class="image-radius-admin" height="110px" width="110px" />
				                    			</div>
				                    			<div class="col-sm-5">
				                    				<h4 class="list-group-item-text"><strong>{{$client->firstName}} {{$client->lastName}}</strong></h4><br>
				                    			</div>
				                    			<div class="col-sm-5">
				            						<h5><b><span class="glyphicon glyphicon-map-marker"></span> {{ $client->location }}, {{$client->country}}</b></h5>
				            					</div>
				                    		</div>
				                		</span><br>
				                  	</a>
				                </div>
							@endforeach
							<div class="text-center">
								{!! $clients->links(); !!}
							</div>
						@endif
					</div>
                </div>
        	</div>
    	</div>
	</div>
@endsection
