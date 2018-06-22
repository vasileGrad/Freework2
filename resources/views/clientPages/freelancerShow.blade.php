@extends('main')

@section('title', '| Profile Freelancer Show')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
			<div class="panel panel-default">
			    <div class="panel-heading">
			    	<h3 class="padding-left">Profile</h3>
				</div>
			    <div class="panel-body" id="items"> 
			    	<div class="row padding-left">
			    		<div class="col-md-3 col-sm-3">
			    			<img src="{{ asset('images/profile/' . $freelancer->image) }}" alt="" class="image-radius-freelancer" height="120" width="120"/>
			    		</div>
			    		<div class="col-md-6 col-sm-6">
			    			<h2><b>{{ $freelancer->firstName }} {{ $freelancer->lastName }}<b></h2>
							<h5 class="editLocation"><span class="glyphicon glyphicon-map-marker"></span> <a href="#" data-toggle="modal" data-target="#myModalLocation"><b> {{ $freelancer->location }}, {{ $freelancer->country }} <b></a></h5>
			    		</div>
			    		<div class="col-md-3 col-sm-3">
		    				<img src="/images/trophy.png" alt="trophy" class="imageSearchJob" width="60" height="60"/>	
		    			 	<h3 class="center-text valueFreelancer"><b>{{ $valueFreelancer}}</b></h3>
			    		</div>
			    		<div class="col-md-12 col-sm-12">
			    			<h3 class="editTitle"><b>{{ $freelancer->title }}</b></h3><br> 

			    			<h4 class="editDescription"><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal1"><h3></i></h3></a>{{ $freelancer->description }}<input type="hidden" id="id" value=""></h4><br> 
			    			<hr>
			    		</div>
				    	<div class="col-md-4 col-sm-4">
			    			<h4><b>&#36;{{ $freelancer->hourlyRate }}<b></h4>
			    			<h4>Hourly Rate</h4>
			    		</div>
			    		<div class="col-md-4 col-sm-4">
			    			@if($freelancer->totalEarnings)
			    				<h4><b>&#36;{{ $freelancer->totalEarnings }}<b></h4>
			    				<h4>Total earned</h4>
			    			@else
			    				<h4><b>&#36; 0<b></h4>
			    				<h4>Total earned</h4>
			    			@endif
			    		</div>
			    		<div class="col-md-4 col-sm-4">
			    			<h4><b>{{ $freelancer->countJobs }}<b></h4>
			    			<h4>Jobs</h4>
			    		</div>
			    	</div>
			    </div>
			</div>

			<div class="panel panel-default">
			  	<div class="panel-heading">
			  		<div class="row">
			  			<div class="col-md-10 col-sm-10">
			  				<h3 class="padding-left">Work History and Feedback</h3>
			  			</div>
			  		</div>
				</div>
			  	<div class="panel-body">
			  		@if(count($contracts) > 0)
					    @foreach($contracts as $contract)
			            	<div class="row padding-left">
			            		<div class="col-md-9 col-sm-9 mainUser">
			            			<a href="#"{{-- data-toggle="modal" data-target="#jobTitle" --}}><h4 id="jobTitle">{{ $contract->title}}</h4></a>
			            			@php
										$rate = "$contract->rateClient"
									@endphp
			            			@for ($i = 1; $i <=$rate; $i++)
										<span class="glyphicon glyphicon-star star_review_color"></span>
			            			@endfor

			            			@for ($i = $rate; $i <5; $i++)
										<span class="glyphicon glyphicon-star-empty star_review_color_empty"></span>
			            			@endfor
			            			<h5 class="inline">&nbsp;&nbsp;&nbsp; {{ date('M j, Y', strtotime($contract->endTime)) }} </h5><br><br>
			            			<h5><i>{{ $contract->reviewClient}}</i></h5>
			            		</div>
			            		<div class="col-md-3 col-sm-3 mainUser">
			            			<h5><b>${{ $contract->paymentAmount}}</b></h5>
			            			<h5>{{ $contract->paymentName}}</h5>
			            		</div>
			            	</div><br><hr>
			            @endforeach
			        @else
			        	<h3 class="center-text"><b>No Contracts</b></h3>
			       	@endif
		            @if(count($contracts) > 1)
		            	<div class="row center-text">
		            		<a href="{{ route('contractsFinishFreelancer', $freelancer->id) }}"><h5 class="color-link"><b>See all the contracts</b></h5></a>
		            	</div>
		    		@endif
				</div>
			</div>

			<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><h3 class="padding-left">Skills</h3></h3>
			  	</div>
			  	<div class="panel-body">
			  		@if(!is_null($skills))
				    	@foreach($skills as $skill)
							<h3 class="inline padding-left"><span class="label label-info label-bottom">{{ $skill->skillName }}</span></h3>&nbsp;&nbsp;
						@endforeach
					@else
						<h3 class="center-text">No Skills</h3>
					@endif
			  	</div><br>
			</div>
		</div> <!-- end of .col-md-8 -->
	</div>
</div>
{{ csrf_field() }}
@endsection
