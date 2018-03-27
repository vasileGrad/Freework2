@extends('main')

@section('title', '| All Jobs')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-1">
			<h1>All Jobs</h1>
		</div><br>

		<div class="col-md-2 col-md-offset-10">
			<a href="{{ route('jobs.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">New Job</a><br><br>
		</div>
	</div> <!-- end of .row -->

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<th></th>
					<th>Title</th>
					<th>Description</th>
					<th>Freelancers</th>
					<th>Expected duration</th>
					<th>Category</th>
					<th>Complexity</th>
					<th>Level</th>
					<th>Payment Type</th>
					<th>Budget</th>
					<th>Created At</th>
					<th></th>
				</thead>

				<tbody>
					
					@foreach ($jobs as $job)
						<tr>
							<th></th>
							<td>{{ $job->title }}</td>
							<td>{{ substr(strip_tags($job->description), 0, 50) }}{{ strlen(strip_tags($job->description)) > 50 ? "..." : "" }}</td>
							<td>{{ $job->nrFreelancers }}</td>
							<th>{{ $job->durationName }}</th>
							<th>{{ $job->categoryName }}</th>
							<th>{{ $job->complexityName }}</th>
							<th>{{ $job->levelName }}</th>
							<td>{{ $job->paymentName }}</td>
							<td>{{ $job->paymentAmount }}</td>
							<td>{{ date('M j, Y', strtotime($job->created_at)) }}</td>
							<td><a href="{{ route('jobs.show', $job->id) }}" class="btn btn-info btn-sm">View</a> <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-default btn-sm">Edit</a></td>
						</tr>
					@endforeach

				</tbody>
			</table>
			
			{{-- <div class="text-center">
				{!! $jobs->links(); !!}
			</div> --}}
		</div>
	</div>


@stop