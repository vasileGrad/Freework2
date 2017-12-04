@extends('main')

@section('title', '| View Job')

@section('content')

<div class="container"><br><br>
    <div class="row">

		<h1>Job posted!!!!</h1>
		<h1>{!! $job->title !!}</h1>
		<br>
		<h3>The number of Freelancers is {!! $job->nrFreelancers !!}</h3>

    </div>
</div>
@endsection
