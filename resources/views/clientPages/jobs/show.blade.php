@extends('main')

@section('title', '| Client Show Job Page')

@section('content')
<div class="container"> 
	<a href="{{route('goBackJobs')}}"><h5 class="color-link"><span class="glyphicon glyphicon-menu-left"></span> <strong>Back to jobs list</strong></h5></a>
    <div class="row">
        <div class="col-md-9 mainUser">
            <div class="panel panel-default">
                <div class="panel-body">
        			<div class="row">
        				<div class="col-md-12 col-sm-12">
        					<div class="col-md-8 col-sm-8 padding-left">
						  		<br><h3 class="list-group-item-heading"><strong>{{ $job->title }}</strong></h3><br><br>
						  		<span class="label label-default label-skill">{{$job->categoryName}}</span>    Posted <b>{{ date( 'M j, Y', strtotime($job->created_at)) }}</b> <br><br>
					    		<br><h4 class="list-group-item-text">{!! $job->description!!}</h4>
					    		<br>
					    		@if(count($uploads))
						    		<h4><b>Attachments ({{ count($uploads) }})</b></h4>
									@foreach($uploads as $upload)
										@php 
											{{ $fileName = "$upload->fileName"; }}
										@endphp
										<a href="{{ route('downloadFileClient', $fileName) }}"><span class="glyphicon glyphicon-paperclip color-link">&nbsp;</span><b class="color-link">{{ $upload->fileName }}</b></a><br>
									@endforeach
								@endif
						    </div>
						    <div class="col-md-3 col-sm-3 pull-right">
						    	<br><br><br><br>
						    	<h4><b>&#36;{{ $job->paymentAmount }}</b></h4>
						    	<h4>{{ $job->paymentName}}</h4><hr>
						    	<h4>{{$job->levelName}}</h4>
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
        	</div>
        	<div class="panel panel-default">
        	    <div class="panel-heading">
        	    	<div class="row padding-left">
        				<div class="col-md-6">
        		            <h2>Submitted Proposals</h2>
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
        	    	@if(count($freelancer_proposals))
	        	    	@foreach($freelancer_proposals as $freelancer)
		                	<div class="row padding-left">
		                		<div class="col-md-4 col-sm-4 mainUser">
		                			<h5>{{ date('M j, Y', strtotime($freelancer->created_at)) }}</h5>
		                		</div>
		                		<div class="col-md-8 col-sm-8 mainUser">
		                			<a href="{{route('showProposal', $freelancer->id)}}"><h5 class="color-link"><strong>{{$freelancer->firstName}} {{$freelancer->lastName}}</strong></h5></a>
		                		</div>
		                	</div><br><hr>
		                @endforeach
		            @else
		            	<h4 class="center-text"><b>No Proposals</b></h4>
		            @endif
        	    </div>
        	</div>
        	<div class="panel panel-default">
        	    <div class="panel-heading">
        	    	<div class="row padding-left">
        				<div class="col-md-6">
        		            <h2>Invitations Send</h2>
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
        	    	@if(count($freelancer_invitations))
	        	    	@foreach($freelancer_invitations as $freelancer)
		                	<div class="row padding-left">
		                		<div class="col-md-4 col-sm-4 mainUser">
		                			<h5>{{ date('M j, Y', strtotime($freelancer->created_at)) }}</h5>
		                		</div>
		                		<div class="col-md-8 col-sm-8 mainUser">
		                			<a href="{{route('showProposal', $freelancer->id)}}"><h5 class="color-link"><strong>{{$freelancer->firstName}} {{$freelancer->lastName}}</strong></h5></a>
		                		</div>
		                	</div><br><hr>
		                @endforeach
		            @else
		            	<h4 class="center-text"><b>No Invitations</b></h4>
		            @endif
        	    </div>
        	</div><br><br>
    	</div>
    	<div class="col-md-3 col-sm-12 mainUser">
    		<div class="panel panel-default">
                <div class="panel-body">
					<div class="col-md-10 col-sm-11">
						<div class="row"><br>
							{!! Html::linkRoute('inviteFreelancers', 'Invite Freelancers', array($job->id), array('class' => 'btn btn-success btn-block')) !!}
							<br>
							{!! Html::linkRoute('jobs.edit', 'Edit', array($job->id), array('class' => 'btn btn-info btn-block')) !!}
							<br>
							{!! Form::open(['route' => ['jobs.destroy', $job->id],'method' => 'DELETE'] ) !!}
								{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}
							{!! Form::close() !!}
						</div>
						<br><hr>
					  	<h4><strong>Other informations</strong></h4><br>
					  	<h5><strong>Nr Freelancers: </strong>{{$job->nrFreelancers}}</strong></h5>
					  	<h5><strong>Duration: </strong>{{$job->durationName}}</h5>
					  	<h5><strong>Category: </strong>{{$job->categoryName}}</h5>
					  	<h5><strong>Complexity: </strong>{{$job->complexityName}}</h5>
					</div>
                </div>
        	</div>
    	</div>
	</div>
@endsection

