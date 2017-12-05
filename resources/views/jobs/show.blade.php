@extends('main')

@section('title', '| View Job')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Jobs</div>

                <div class="panel-body">
						<h3><strong>{{ $job->title }}</strong></h3>
						<hr>

						<h2>{{ $job->description }}</h2>
						<h3>The number of Freelancers is {{ $job->nrFreelancers }}</h3>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
