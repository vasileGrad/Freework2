@extends('main')

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
                			<h5><strong>JOB</strong></h5>
                		</div>
                	</div><br><hr>

                	<div class="row padding-left">
	                		<div class="col-md-4 col-sm-4 mainUser">
	                			<h5>Date</h5>
	                		</div>
	                		<div class="col-md-8 col-sm-8 mainUser">
	                			<a href="#"><h5><strong>Title</strong></h5></a>
	                		</div>
	                	</div><br><hr>
                	{{-- @foreach($proposals as $proposal)
	                	<div class="row padding-left">
	                		<div class="col-md-4 col-sm-4 mainUser">
	                			<h5>{{ date('M j, Y', strtotime($proposal->created_at)) }}</h5>
	                		</div>
	                		<div class="col-md-8 col-sm-8 mainUser">
	                			<a href="{{route('freelancerProposal.show', $proposal->id)}}"><h5><strong>{{$proposal->title}}</strong></h5></a>
	                		</div>
	                	</div><br><hr>
	                @endforeach --}}
                </div>
            </div><br><br>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
                <div class="panel-heading">Jobs</div>
                	<div class="panel-body">
                		<a href="#" class="btn btn-success btn-lg active" role="button">Submit a Proposal</a><br>
                		<a href="#" class="btn btn-success btn-lg active" role="button">Save a Job</a>
                		@foreach($jobs as $job)

                		@endforeach
                	</div>
           	</div>
		</div>
    </div>
</div>
@endsection
