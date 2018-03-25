@extends('main')

@section('title', '| Freelancer Job Saved Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Jobs Saved</h1><br>
                	<h5>Keep track of jobs you're interested in. Once a job is closed, it will automatically be removed from your list. </h5>
                	<div class="row">
        				<div class="col-md-6">
				            @if (count($jobs) === 1)
				            	<h4><span class="badge">{{ count($jobs) }}</span> Job found</h4>
				            @else
				            	<h4><span class="badge">{{ count($jobs) }}</span> Jobs found</h4>
				            @endif
				        </div>
				    </div>
                </div>
                <div class="panel-body">
                	<div class="list-group">
                		@foreach ($jobs as $job)
                			<div class="row">
							  	<a href="{{ route('jobShow', $job->id)}}" class="list-group-item">
							  		<p class="list-group-item-heading"><strong>{{$job->title}}</strong></p><br>
							  		<p class="list-group-item-text"><strong>{{$job->paymentName}}</strong> - Budget: &#36;{{ $job->paymentAmount }} - Posted: {{ $job->created_at }}</p><br>
							  		<p class="list-group-item-text">{{ substr(strip_tags($job->description), 0, 20) }}{{ strlen(strip_tags($job->description)) > 20 ? "..." : ""}}</p><br>
							  		<h5 class="list-group-item-text"><strong>Client: {!! $job->firstName !!}</strong> <span class="glyphicon glyphicon-map-marker">{!! $job->country !!}</span></h5>
							  	</a>
							</div>
						@endforeach
						<div class="text-center">
							{!! $jobs->links(); !!}
						</div>
					</div>
                </div>
        	</div>
    	</div>
    
	</div>
@endsection
