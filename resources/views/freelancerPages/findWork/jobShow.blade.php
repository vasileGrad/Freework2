@extends('main')

@section('title', '| Show Job Page')

@section('content')
<div class="container">
	<a href="{{route('goBack')}}"><h4 class="color-link"><span class="glyphicon glyphicon-menu-left"></span> <strong>Back to jobs list</strong></h4></a>
    <div class="row">
        <div class="col-md-8 mainUser">
            <div class="panel panel-default">
                <div class="panel-body">
        			<div class="row"> 
        				<div class="col-md-12 col-sm-12">
        					<div class="col-md-8 col-sm-8 padding-left">
						  		<br><h3 class="list-group-item-heading"><strong>{{$job->title}}</strong></h3><br><br>
						  		<span class="label label-default label-skill">{{$job->categoryName}}</span>    Posted {{ date( 'M j, Y h', strtotime($job->created_at)) }} <br>
					    		<br><h4 class="list-group-item-text">{!! $job->description!!}</h4>
					    		<br>
					    		@if(count($uploads))
						    		<h4><b>Attachments ({{ count($uploads) }})</b></h4>
									@foreach($uploads as $upload)
										@php 
											{{ $fileName = "$upload->fileName"; }}
										@endphp
										<a href="{{ route('downloadFileFreelancer', $fileName) }}"><span class="glyphicon glyphicon-paperclip color-link">&nbsp;</span><b class="color-link">{{ $upload->fileName }}</b></a><br>
									@endforeach
								@endif
						    </div>
						    <div class="col-md-3 col-sm-3 pull-right">
						    	<br><br><br><br>
						    	<h4>&#36;{{ $job->paymentAmount }}</h4>
						    	<h4>{{ $job->paymentName}}</h4><hr>
						    	<h4>{{$job->levelName}}</h4>
						    </div>
        				</div>
					</div><hr>
					<div class="row">
						<div class="col-md-12 col-sm-12 padding-left">
							<h4><strong>Skills and Expertise</strong></h4><br>
							@if(count($job_skills) != 0)
								<div class="row padding-left">
									@foreach($job_skills as $skill)
										<span class="label label-info label-skill label-bottom">{{ $skill->skillName }}</span>
									@endforeach
								</div>
							@else
								<h4>No skills</h4>
							@endif
						</div>	
					</div><hr>
                </div>
        	</div>
    	</div>
    	<div class="col-md-4 col-sm-12 mainUser">
    		<div class="panel panel-default">
                <div class="panel-body">
					<div class="col-md-10 col-sm-11"><br>
						@if($proposalCount == 0)
							{!! Form::open(['route' => ['createProposal', $job->id], 'method' => 'POST']) !!}
								{!! Form::button('<strong>Submit a Proposal</strong>', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn-block')) !!}
				            {!! Form::close() !!}<br><br>
				        @elseif($proposalCount == 1) 
							<h4><b>Proposal submitted</b></h4><br>
						@endif
							
						@if($job_saved == 0)
							{!! Form::open(['route' => ['saveJob', $job->id], 'method' => 'POST']) !!}
								{!! Form::button('<span class="glyphicon glyphicon-heart-empty"></span>&nbsp;&nbsp;&nbsp;<strong>Save Job</strong>', array('type' => 'submit', 'class' => 'btn btn-default btn-lg btn-block')) !!}
			            	{!! Form::close() !!}
						@elseif($job_saved == 1)
							{!! Form::open(['route' => ['unsaveJob', $job->id], 'method' => 'POST']) !!}
								{!! Form::button('<span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Saved</strong>', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn-block')) !!}
			            	{!! Form::close() !!}
    					@endif

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