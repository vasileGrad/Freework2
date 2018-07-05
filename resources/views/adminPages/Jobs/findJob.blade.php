@extends('main')

@section('title', '| Job Search Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
        				<div class="col-md-12">
		                	<form method="GET" action="{{ route("findJobFilter") }}">
				            	{{ csrf_field() }} 
								<div class="input-group col-md-6 col-sm-6 padding-left mainUser">
				                    <input type="text" name="search" class="form-control" aria-label="..." placeholder="Search jobs">
				                    <div class="input-group-btn">
				                        <button type="submit" class="btn btn-default">Submit</button>
				                    </div>
				            	</div>
				                
				                <br><br>
				            
				            	<div class="row padding-left">
				            		@if($jobs->total() === 1)
					            		<h4><span class="badge">{{ $jobs->total() }}</span> Job found</h4>
					            	@else
					            		<h4><span class="badge">{{ $jobs->total() }}</span> Jobs found</h4>
					            	@endif
				            	</div>
					        </form>
				    	</div>
                	</div>
                </div>
                <div class="panel-body">
                	<div class="list-group">
                		 @if($jobs->total() == 0)
		                	<div class="list-group center-title">
		                		<span class="list-group-item-text">
		                			<div class="col-sm-12">
		                				<h3 class="list-group-item-text"><strong>Job not found</strong></h3>
		                			</div>
		                		</span><br><br><br>
			                </div>
			            @else
	                		@foreach ($jobs as $job)
	                			<div class="row">
	                				<div class="col-md-12">
                						<a href="{{ route('showJob', $job->id)}}" class="list-group-item">
                							<div class="row">
            									<div class="col-md-11 col-offset-md-2 col-sm-11 col-offset-sm-2 padding-left">
											  		<span>
												  		<h4 class="list-group-item-heading"><strong>{{$job->title}}</strong>
												    	<button type="button" class="btn btn-sm btn-circle pull-right glyphicon glyphicon-heart-empty"></button></h4><br>
											  		</span>
											    	
											    	<h4 class="list-group-item-text"><strong>{{$job->paymentName}}</strong> - {{$job->levelName}} - Budget: &#36;{{ $job->paymentAmount }} - Posted: {{ $job->created_at }}</h4>
											    	<h4 class="list-group-item-text">{{ substr(strip_tags($job->description), 0, 30) }}{{ strlen(strip_tags($job->description)) > 30 ? "..." : ""}}</h4>
											    	<small>
											    		<h5 class="list-group-item-text"><strong>Client: {!! $job->firstName !!}</strong> <span class="glyphicon glyphicon-map-marker">{!! $job->country !!}</span></h5>
											    	</small>
											    </div>
											</div>
								  		</a>
	                				</div>
								</div>
							@endforeach
							<div class="text-center">
								{!! $jobs->links(); !!}
							</div>
						@endif
					</div>
                </div>
        	</div>
    	</div>
	</div>
@endsection
