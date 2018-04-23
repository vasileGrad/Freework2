@extends('main')

@section('title', '| Search for Clients Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
        				<div class="col-md-12">
		                	<form method="GET" action="{{ route('findClientFilter') }}">
				            	{{ csrf_field() }}
								<div class="input-group col-md-6 col-sm-6 padding-left mainUser">
				                    <input type="text" name="search" class="form-control" aria-label="..." placeholder="Search for Jobs">
				                    <div class="input-group-btn">
				                        <button type="submit" class="btn btn-default">Submit</button>
				                    </div>
				            	</div>
				                
				                <br><br>
				            	@if(isset($clientsCount))
						            @if ($clientsCount == 1)
						            	<h4><span class="badge">{{ $clientsCount }}</span> Client found</h4>
						            @else
						            	<h4><span class="badge">{{ $clientsCount }}</span> Clients found</h4>
						            @endif
						        @endif
					        </form>
				    	</div>
                	</div>
                </div>
                @if($clients->total() == 0)
                	<div class="list-group center-title">
                		<span class="list-group-item-text">
                			<div class="col-sm-12">
                				<h3 class="list-group-item-text"><strong>No clients found</strong></h3><br><br><br><br>
                			</div>
                		</span><br><br><br>
	                </div>
	            @else
	                @foreach ($clients as $client)
		                <div class="list-group">
		                    <a href="{{ route('showClient', $client->id)}}" class="list-group-item"><br>
	                    		<span class="list-group-item-text">
		                    		<div class="row">
		                    			<div class="col-sm-2">
		                    				<img src="{{ asset('images/profile/' . $client->image) }}" alt="" class="image-radius-admin" height="110px" width="110px" />
		                    			</div>
		                    			<div class="col-sm-5">
		                    				<br><h4 class="list-group-item-text"><strong>{{$client->firstName}} {{$client->lastName}}</strong></h4>
		                    			</div>
		                    			<div class="col-sm-5">
	                						<br><h5><b><span class="glyphicon glyphicon-map-marker"></span>{{ $client->location }}, {{ $client->country }}</b></h5>
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
@endsection





