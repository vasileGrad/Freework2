@extends('main')

@section('title', '| View Job')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Jobs</div>

                <div class="panel-body">
                	@foreach($jobs as $job)
                		<h3>Job id: {{ $job->id }}</h3>
						<h3><strong>{{ $job->title }}</strong></h3>
						<hr>
						<h3>Description: {{ $job->description }}</h3>
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
@endsection
