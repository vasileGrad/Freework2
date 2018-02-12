@extends('main')

@section('title', '| Profile')

@section('content')


<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
		    <div class="panel-heading"><h3>Profile</h3>
		</div>

	    <div class="panel-body">
	    	<div class="row">
	    		<div class="col-md-2">
	    			<img src="{{ asset('images/profile/' . $freelancer->image) }}" alt="" height="120" width="120" />
	    		</div>
	    		<div class="col-md-6">
	    			<h2><b>{{ $freelancer->firstName }} {{ $freelancer->lastName }}<b></h2>
					<h5><span class="glyphicon glyphicon-map-marker"></span><b> {{ $freelancer->location }}, {{ $freelancer->country }}<b></h5>
	    		</div>
	    		<div class="col-md-12">
	    			<h3><b>{{ $freelancer->title }}<b></h3>
	    			<p>{{ $freelancer->description }}</p>
	    			<hr>
	    		</div>
		    	<div class="col-sm-3">
	    			<h4><b>&#36;{{ $freelancer->hourlyRate }}<b></h4>
	    			<h4>Hourly Rate</h4>
	    		</div>
	    		<div class="col-sm-3">
	    			<h4>Total earned</h4>
	    		</div>
	    		<div class="col-sm-3">
	    			<h4>Jobs</h4>
	    		</div>
	    	</div>
	    </div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading"><h3>Work History and Feedback</h3></div>
	  	<div class="panel-body">
	    Panel content
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Portofolio</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	Panel content
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Skills</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	@foreach($freelancer->skills as $skill)
			<h3><span class="label label-info">{{ $skill->skillName }}</span></h3>
		@endforeach
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Certifications</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	No items to display.
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Tests</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	No items to display.
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Employment History</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	Informations
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Education</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	Degrees and certifications
	  	</div>
	</div>
</div> <!-- end of .col-md-8 -->
</div>
@endsection