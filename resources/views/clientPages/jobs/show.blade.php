@extends('main')

@section('title', '| Client Show Job Page')

@section('content')
<div class="container">
	<a href="{{route('goBackJobs')}}"><h5><span class="glyphicon glyphicon-menu-left"></span> <strong>Back to jobs list</strong></h5></a>
    <div class="row">
        <div class="col-md-9 mainUser">
            <div class="panel panel-default">
                <div class="panel-body">
        			<div class="row">
        				<div class="col-md-12 col-sm-12">
        					<div class="col-md-8 col-sm-8 padding-left">
						  		<br><h3 class="list-group-item-heading"><strong>{{ $job->title }}</strong></h3><br><br>
						  		<span class="label label-default label-skill">{{$job->categoryName}}</span>    Posted {{ date( 'M j, Y h', strtotime($job->created_at)) }} <br>
					    		<br><h4 class="list-group-item-text">{{ strip_tags($job->description) }}</h4>
						    </div>
						    <div class="col-md-3 col-sm-3 pull-right">
						    	<br><br><br><br>
						    	<h4>&#36;{{ $job->paymentAmount }}</h4>
						    	<h4>{{ $job->paymentName}}</h4><hr>
						    	<h4>{{$job->levelName}} Level</h4>
						    </div>
        				</div>
					</div><hr>
					<div class="row">
						<div class="col-md-12 col-sm-12 padding-left">
							<h4><strong>Skills and Expertise</strong></h4><br>
							@if(count($job_skills) > 0)
								<div class="row padding-left">
									@foreach($job_skills as $skill)
										<span class="label label-info label-skill">{{ $skill->skillName }}</span>
									@endforeach
								</div>
							@else
								<h4>No skills</h4>
							@endif
						</div>	
					</div><hr>
                </div>
        	</div><br><br>
        	<div class="panel panel-default">
        	    <div class="panel-heading">
        	    	<div class="row padding-left">
        				<div class="col-md-6">
        		            <h2>Submitted Proposal</h2>
        		        </div>
        		    </div><br>
        	    </div>
        	    <div class="panel-body">
        	    	<div class="row padding-left">
        	    		<div class="col-md-4 col-sm-4 mainUser">
        	    			<h5><strong>DATE INITIATED</strong></h5>
        	    		</div>
        	    		<div class="col-md-8 col-sm-8 mainUser">
        	    			<h5><strong>FREELANCER</strong></h5>
        	    		</div>
        	    	</div><br><hr>
        	    	@foreach($freelancer_proposals as $freelancer)
	                	<div class="row padding-left">
	                		<div class="col-md-4 col-sm-4 mainUser">
	                			<h5>{{ date('M j, Y', strtotime($freelancer->created_at)) }}</h5>
	                		</div>
	                		<div class="col-md-8 col-sm-8 mainUser">
	                			<a href="{{route('showProposal', $freelancer->id)}}"><h5><strong>{{$freelancer->firstName}} {{$freelancer->lastName}}</strong></h5></a>
	                		</div>
	                	</div><br><hr>
	                @endforeach
        	    </div>
        	</div><br><br>
    	</div>
    	<div class="col-md-3 col-sm-12 mainUser">
    		<div class="panel panel-default">
                <div class="panel-body">
					<div class="col-md-10 col-sm-11"><br>
						{{-- @if($proposal == 0)
							{!! Form::open(['route' => ['createProposal', $job->id], 'method' => 'POST']) !!}
								{!! Form::button('<strong>Submit a Proposal</strong>', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn-block')) !!}
				            {!! Form::close() !!}<br><br>
				        @elseif($proposal == 1)
							<h4>Proposal submitted</h4>
						@endif
							
						@if($job_saved == 0)
							{!! Form::open(['route' => ['saveJob', $job->id], 'method' => 'POST']) !!}
								{!! Form::button('<span class="glyphicon glyphicon-heart-empty"></span>&nbsp;&nbsp;&nbsp;<strong>Save Job</strong>', array('type' => 'submit', 'class' => 'btn btn-default btn-lg btn-block')) !!}
			            	{!! Form::close() !!}
						@elseif($job_saved == 1)
							{!! Form::open(['route' => ['unsaveJob', $job->id], 'method' => 'POST']) !!}
								{!! Form::button('<span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Saved</strong>', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn-block')) !!}
			            	{!! Form::close() !!}
    					@endif --}}

						<br><hr>
					  	<h5><strong>About the Client</strong></h5><br>
					  	<h5><strong>{{$job->firstName}}</strong></h5>
					  	<h5><span class="glyphicon glyphicon-map-marker"> {{ $job->country }}, {{$job->location}}</span></h5><br>
					  	<h5><strong>Nr Freelancers</strong></h5>
					  	<h5><strong>{{$job->nrFreelancers}}</strong></h5>
					</div>
                </div>
        	</div>
    	</div>
	</div>
@endsection





{{-- @extends('main')

@section('title', '| View Job')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Jobs</div>

                <div class="panel-body">
                	@foreach($jobs as $job)
                		<h3>Job id: {{ $job->id }}</h3>
						<h3><strong>{{ $job->title }}</strong></h3>
						<hr>
						<h3>Description: {{ substr(strip_tags($job->description), 0, 50) }}{{ strlen(strip_tags($job->description)) > 50 ? "..." : "" }}</h3>
						<hr>
						<h3>Created at: {{ $job->created_at }}</h3>
						<hr>
						<h3>Category: {{ $job->categoryName }}</h3>
						<hr>
						<h3>Project Type: {{ $job->paymentName }}</h3>
						<hr>
						<h3>Country: {{ $job->country }}</h3>
						<hr>
						<h3>Price: &#36; {{ $job->paymentAmount }} </h3>
						<h3>Payment type: {{ $job->paymentName }}</h3>
						<hr>
						<h3>Complexity: {{ $job->complexityName }}</h3>
						<hr>
						<h3>Level: {{ $job->levelName }}</h3>
						<hr>
						<div class="tags">
							@foreach($jobs2->skills as $skill)
								<span class="label label-info">{{ $skill->skillName }}</span>
							@endforeach
						</div>
						<h3></h3>
					@endforeach
				</div>
			</div>
		</div>
    </div>
</div>
@endsection --}}
