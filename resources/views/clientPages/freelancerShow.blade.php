@extends('main')

@section('title', '| Profile Freelancer Show')

@section('content')
<div class="container">
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
		    <div class="panel-heading"><h3>Profile</h3>
		</div>
	    <div class="panel-body" id="items">
	    	<div class="row">
	    		<div class="col-md-3">
	    			<img src="{{ asset('images/profile/' . $freelancer->image) }}" alt="" style="border-radius: 50%" height="120" width="120" />
	    		</div>
	    		<div class="col-md-6">
	    			<h2><b>{{ $freelancer->firstName }} {{ $freelancer->lastName }}<b></h2>
					<h5><span class="glyphicon glyphicon-map-marker"></span><b> {{ $freelancer->location }}, {{ $freelancer->country }}<b></h5>
	    		</div>
	    		<div class="col-md-12">
	    			<h3 class="editTitle"><a href="#" data-toggle="modal" data-target="#myModal1"><b>{{ $freelancer->title }} <b><input type="hidden" id="itemId2" value="{{$freelancer->id}}"><i class="fa fa-edit fa-sm"></i></a></h3>

	    			<h4 class="editDescription"><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal1"><h3><i class="fa fa-edit fa-sm"></i></h3></a>{{ $freelancer->description }}<input type="hidden" id="id" value=""></h4>   
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
	  	<div class="panel-heading">
	  		<div class="row">
	  			<div class="col-md-10">
	  				<h3>Work History and Feedback</h3>
	  			</div>
	  			<div class="col-md-2">
	  				<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#myModal"><b>+ Edit<b></button>
	  			</div>
	  		</div>
		</div>
	  	<div class="panel-body">
		    Panel content
		</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Portfolio</h3></h3>
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
</div>
@endsection
