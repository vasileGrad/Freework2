@extends('main')

@section('title', '| Show Proposal Job Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 col-offset-md-1 col-sm-9">
        	<a href="{{route('goBackProposals')}}"><h5><span class="glyphicon glyphicon-menu-left"></span> <strong> Back to proposals list</strong></h5></a><br>
			<h2>{{$job->title}}</h2><br>
			<h4><span class="label label-default label-skill">{{$job->categoryName}}</span> &nbsp;&nbsp;Posted {{ date('M j, Y', strtotime($job->created_at)) }}</h4><br>
			<div class="row">
				@if($job->paymentName == 'Hourly')
					<div class="col-md-4 col-sm-4">
						<span class="glyphicon glyphicon-time"></span> <strong>{{$job->paymentName}} Job</strong><br>
						<strong>&nbsp;&nbsp;&nbsp;&nbsp;{{$job->durationName}}</strong><br><br>
					</div>
					<div class="col-md-4 col-sm-4">
						<span class="glyphicon glyphicon-usd"></span> <strong>{{$job->levelName}}</strong><br><br>
					</div>
				@elseif($job->paymentName == 'Fixed price')
					<div class="col-md-4 col-sm-4">
						<span class="glyphicon glyphicon-tags"></span>  <strong>{{$job->paymentName}}</strong><br><br>
					</div>
					<div class="col-md-4 col-sm-4">
						<span class="glyphicon glyphicon-usd"></span> <strong>{{$job->payment_amount}}</strong><br>
						<strong>&nbsp;&nbsp;&nbsp;&nbsp;Budget</strong>
					</div>
					<div class="col-md-4 col-sm-4">
						<span class="glyphicon glyphicon-usd"></span><span class="glyphicon glyphicon-usd"></span> <strong>{{$job->levelName}}</strong><br><br>
					</div>
				@endif
			</div><br><br>
            <div class="panel panel-default">
                <div class="panel-body">
        			<div class="row">
        				<div class="col-md-12 col-sm-12 padding-left">
					  		<br><h3 class="list-group-item-heading"><strong>Details</strong></h3><br><br>
					  		<h4 class="list-group-item-text">{{ strip_tags($job->description) }}</h4><br>
        				</div>
					</div><hr>
					<div class="row">
						<div class="col-md-12 col-sm-12 padding-left">
							@if(count($job_skills) != 0)
								<div class="row padding-left">
								<p><strong>Skills required: </strong></p>
									@foreach($job_skills as $skill)
										<span class="label label-info label-skill">{{ $skill->skillName }}</span>&nbsp;&nbsp;
									@endforeach
								</div>
							@else
								<h4>No skills</h4>
							@endif
						</div>	
					</div><br>
                </div>
        	</div>
        	<div class="panel panel-default">
                <div class="panel-body">
        			<div class="row">
        				<div class="col-md-12 col-sm-12 padding-left">
					  		<br><h3 class="list-group-item-heading"><strong>Cover Letter</strong></h3><br><br>
					  		<h4 class="list-group-item-text">{!! $job->freelancer_comment !!}</h4><br>
        				</div>
					</div>
                </div>
        	</div>
    	</div>
    	<div class="col-md-3 col-sm-3 top-proposal">
			<div class="col-md-12 col-sm-12"><br>
				<h5><strong>Submitted Proposals</strong></h5><br>
				<h5><strong>Your proposed terms:</strong></h5><br>
				@if($job->paymentName == 'Hourly')
					<h5>Rate: ${{$job->payment_amount}}/hr</h5>
				@elseif($job->paymentName == 'Fixed price')
					<h5>Budget: ${{$job->payment_amount}}</h5>
				@endif
				<br><hr>
			  	<h5><strong>About the Client</strong></h5><br>
			  	<h5><span class="glyphicon glyphicon-map-marker"><strong>{{ $client->country }}</strong></span></h5>
			  	<h6>&nbsp;&nbsp;&nbsp;&nbsp;{{$client->location}}</h6><br>
			  	@if ($count_jobs == 1)
			  		<h5>{{$count_jobs}} Job Posted</h5><br>
			  	@elseif($count_jobs > 1)
			  		<h5>{{$count_jobs}} Jobs Posted</h5><br>
			  	@endif 
			  	<small>Member since: {{ date('M j, Y', strtotime($client->created_at)) }}</small><br><hr>
			  	<h5><strong>Activity for this job</strong></h5><br>
			  	@if ($proposals_job == 1)
			  		<h5>{{$proposals_job}} proposal</h5>
			  	@elseif ($proposals_job > 1)
			  		<h5>{{$proposals_job}} proposals</h5>
			  	@endif
			  	<h5> interviews</h5>
			</div>
    	</div>
	</div>
</div>
@endsection