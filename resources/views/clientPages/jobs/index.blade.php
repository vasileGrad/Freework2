@extends('main')

@section('title', '| Jobs in progress')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row padding-left">
        				<div class="col-md-9 top-textarea">
				            @if( $jobs->total() == 1)
								<h3><span class="glyphicon glyphicon-check badge"></span> {{ $jobs->total() }} job available</h3>
							@elseif( $jobs->total() > 1)
								<h3><span class="glyphicon glyphicon-check badge"></span> {{ $jobs->total() }} jobs available</h3>
							@elseif( $jobs->total() == 0)
								<h2>No jobs available</h2>
							@endif
				        </div>
				        <div class="col-md-3 padding-right">
				        	<a href="{{ route('jobs.create') }}" class="btn btn-lg btn-block btn-info btn-h1-spacing top-textarea">New Job</a><br><br>
				        </div>
				    </div> 
                </div>
            		@foreach ($jobs as $job)
            		<div class="list-group">
					  	<a href="{{ route('jobs.show', $job->id)}}" class="list-group-item">
					  	<div class="row">
						  	<span>
                    			<div class="col-md-8 col-sm-8">
                    				<h4 class="list-group-item-heading padding-left top-textarea"><strong>{{$job->title}}</strong></h4>
				  			    	
				  			    	<h4 class="list-group-item-text padding-left"><strong>{{$job->paymentName}}</strong> - {{$job->levelName}} - Budget: <b>&#36;{{ $job->paymentAmount }}</b> - Posted: {{ date( 'M j, Y', strtotime($job->created_at)) }}</h4><br>
				  			    	<h4 class="list-group-item-text padding-left">{{ substr(strip_tags($job->description), 0, 30) }}{{ strlen(strip_tags($job->description)) > 30 ? "..." : ""}}</h4><br>
                    			</div>
                    			<div class="col-md-4 col-sm-4">
                    				<h4 class="list-group-item-heading padding-left top-textarea">Category: <strong>{{$job->categoryName}}</strong></h4>
                    				<h4 class="list-group-item-heading padding-left">Complexity: <strong>{{$job->complexityName}}</strong></h4>
                    				<h4 class="list-group-item-heading padding-left">Freelancers: <strong>{{$job->nrFreelancers}}</strong></h4>
                    			</div>
                			</span><br>
                		</div>
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


{{-- 

	<td><a href="{{ route('jobs.show', $job->id) }}" class="btn btn-info btn-sm">View</a> <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-default btn-sm">Edit</a></td>
			
@stop --}}