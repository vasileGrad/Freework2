@extends('main')

@section('title', '| Freelancer Job Search Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mainUser">
            <div class="panel panel-default">
                <div class="panel-body">
        			<div class="row">
        				<div class="col-md-12 col-sm-12">
        					<div class="col-md-8 col-sm-8 padding-left">
						  		<br><h3 class="list-group-item-heading"><strong>{{$job->title}}</strong></h3><br><br>
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
							@if(count($job_skills) != 0)
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
    	</div>
    	<div class="col-md-3 col-sm-12 mainUser">
    		<div class="panel panel-default">
                <div class="panel-body">
					<div class="col-md-12 col-sm-6"><br>
						{!! Form::model($job, ['route' => ['blockJob', $job->id], 'method' => 'PUT']) !!}
							{{ Form::submit('Block Job', ['class' => 'btn btn-danger btn-block']) }}
						{!! Form::close() !!}
						<br><hr>
					</div>
				  	<h5><strong>About the Client</strong></h5><br>
				  	<h5><strong>{{$job->firstName}}</strong></h5>
				  	<h5><span class="glyphicon glyphicon-map-marker"> {{ $job->country }}, {{$job->location}}</span></h5>
                </div>
        	</div>
    	</div>
	</div>
@endsection