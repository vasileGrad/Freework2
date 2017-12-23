@extends('main')

@section('title', '| Freelancer Job Search Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
        				<div class="col-md-6">
		                	<form method="POST" action="{{ route("jobSearch") }}">
				            	{{ csrf_field() }}
				                <div class="input-group">
				                    <input type="text" name="search" class="form-control" aria-label="..." placeholder="Search for Jobs">
				                    <div class="input-group-btn">
				                        <button type="submit" class="btn btn-default">Submit</button>
				                    </div>
				                </div><br><br>
				            </form>
				            @if (count($jobs) === 1)
				            	<h4><span class="badge">{{ count($jobs) }}</span> Job found</h4>
				            	
				            @else
				            	<h4><span class="badge">{{ count($jobs) }}</span> Jobs found</h4>
				            @endif
				        </div>
				        <div class="col-md-4">
				        	<button type="submit" class="btn btn-success">Filters</button>
				        </div>
				    </div>
                </div>
                <div class="panel-body">
                	<div class="list-group">
                		@foreach ($jobs as $job)
                			<div class="row">
							  	<a href="{{ route('jobShow', $job->id)}}" class="list-group-item">
							  		<span>
								  		<h4 class="list-group-item-heading"><strong>{{$job->title}}</strong>
								    	<button type="button" class="btn btn-sm btn-circle pull-right glyphicon glyphicon-heart-empty"></button></h4><br>
							  		</span>
							    	
							    	<h4 class="list-group-item-text"><strong>{{$job->paymentName}}</strong> - {{$job->levelName}} - Budget: &#36;{{ $job->paymentAmount }} - Posted: {{ $job->created_at }}</h4><br>
							    	<h4 class="list-group-item-text">{{ substr(strip_tags($job->description), 0, 30) }}{{ strlen(strip_tags($job->description)) > 30 ? "..." : ""}}</h4><br>
							    	<small>
							    		<h5 class="list-group-item-text"><strong>Client: {!! $job->firstName !!}</strong> <span class="glyphicon glyphicon-map-marker">{!! $job->country !!}</span></h5>
							    	</small><br>
							  	</a>
							</div>
						@endforeach
					</div>
                </div>
        	</div>
    	</div>
    
	</div>
@endsection
