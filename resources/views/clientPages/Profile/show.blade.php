@extends('main')

@section('title', '| Client Profile')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
			<div class="panel panel-default">
			    <div class="panel-heading"><h3 class="padding-left">Profile</h3>
			</div>
		    <div class="panel-body" id="items"> 
		    	<div class="row padding-left">
		    		<div class="col-md-3 col-sm-3">
		    			<img src="{{ asset('images/profile/' . $client->image) }}" alt="" class="image-radius-freelancer" height="120" width="120"/>
		    		</div>
		    		<div class="col-md-6 col-sm-6">
		    			<h2><b>{{ $client->firstName }} {{ $client->lastName }}<b></h2>
						<h5><span class="glyphicon glyphicon-map-marker"></span><b> {{ $client->location }}, {{ $client->country }}<b></h5>
		    		</div>
		    		<div class="col-md-3 col-sm-3">
		    		</div>
		    		<div class="col-md-12 col-sm-12">
		    			
		    			<hr>
		    		</div>
		    		<div class="col-md-4 col-sm-4">
		    			<h4><b>&#36;{{ $client->totalSpending }}<b></h4>
		    			<h4>Total spent</h4>
		    		</div>
		    		<div class="col-md-4 col-sm-4">
		    			<h4><b>{{ $contractsNow }}<b></h4>
		    			<h4>Contracts in progress</h4>
		    		</div>
		    		<div class="col-md-4 col-sm-4">
		    			<h4><b>{{ $client->countJobs }}<b></h4>
		    			<h4>Contracts done</h4>
		    		</div>
		    	</div>
		    </div>

		    <!-- Modal for title-->
			<div class="modal fade" id="myModal1" tabindex="-3" role="dialog" aria-labelledby="myModalLabel">
			  	<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        		<h4 class="modal-title" id="title">Overview</h4>
			      		</div>
			      		<div class="modal-body">
					      	<div class="bodyTitle">
					      		<label>Job Title</label>
					          	<input type="hidden" id="id">
					          	<p><input type="text" placeholder="Write Item Here" id="addItem" class="form-control"></p>
					      	</div>
					      	<div class="bodyDescription">
							    <div class="form-group">
							    	<br>
							    	<p>Use this space to show clients you have the skills and experience they're looking for.</p>
							    	<br>
							    	<ul>
							    	  <li class="list-style">Describe your strengths and skills</li>
							    	  <li>Highlight projects, accomplishments and education</li>
							    	  <li>Keep it short and make sure error-free</li>
							    	</ul>
							    	<br>
							        <textarea class="form-control" rows="10" id="overview"></textarea><br><br>
							    </div>
							</div>
				  		</div>
				     	<div class="modal-footer">
				        	<button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display: none">Cancel</button>
				        	<button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal"style="display: none">Save changes</button>
				        	<button type="button" class="btn btn-primary" id="saveChanges2" data-dismiss="modal"style="display: none">Save changes</button>
				      	</div>
			    	</div>
			  	</div>
			</div>

		</div>

		<div class="panel panel-default">
		  	<div class="panel-heading">
		  		<div class="row">
		  			<div class="col-md-10 col-sm-10">
		  				<h3 class="padding-left">Contracts History and Feedback</h3>
		  			</div>
		  		</div>
			</div>
		  	<div class="panel-body">
			    @foreach($contracts as $contract)
	            	<div class="row padding-left">
	            		<div class="col-md-9 col-sm-9 mainUser">
	            			<a href="#"><h4 id="jobTitle" class="color-link">{{ $contract->title}}</h4></a>
	            			
	            			<div class="col-md-1 col-sm-1 top-textarea">
	            				<img src="{{ asset('images/profile/' . $contract->freelancerImage) }}" alt="" class="image-radius-freelancer" height="35" width="35"/>
	            			</div>
	            			<div class="col-md-11 col-SM-11 top-textarea">
	            				<h5><b>{{ ucwords($contract->freelancerFirstName)}} {{ ucwords($contract->freelancerLastName)}}</b> said:</h5>
	            				<h5><i>{{ $contract->reviewFreelancer}}</i></h5>
	            				@php
								$rate = "$contract->rateFreelancer"
								@endphp
		            			@for ($i = 1; $i <=$rate; $i++)
									<span class="glyphicon glyphicon-star star_review_color"></span>
		            			@endfor

		            			@for ($i = $rate; $i <5; $i++)
									<span class="glyphicon glyphicon-star-empty star_review_color_empty"></span>
		            			@endfor
		            			<h5 class="inline">&nbsp;&nbsp;&nbsp; {{ date('M j, Y', strtotime($contract->endTime)) }} </h5><br><br>
	            			</div>
	            		</div>
	            		<div class="col-md-3 col-sm-3 mainUser">
	            			<h5><b>${{ $contract->paymentAmount}}</b></h5>
	            			<h5>{{ $contract->paymentName}}</h5>
	            		</div>
	            	</div><br><hr>
	            @endforeach
	            @if(count($contracts) > 1)
	            	<div class="row center-text">
	            		<a href="{{ route('contracts', Session::get('AuthUser')) }}"><h5 class="color-link"><b>See all the contracts</b></h5></a>
	            	</div>
	    		@endif
			</div>
		</div>

	{{-- <!-- Modal for Work History-->
	<div class="modal fade" id="myModal" tabindex="-3" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Edit Job Title</h4>
	      </div>
	      <div class="modal-body">
	        {{ $freelancer->firstName}}
	        {{ substr(strip_tags($freelancer->description), 0, 50) }}{{ strlen(strip_tags($freelancer->description)) > 50 ? "..." : "" }}
	        {{ $freelancer->title}}
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div> --}}
	</div>
</div>
{{ csrf_field() }}
@endsection
	
@section('scripts')
	{{ Html::script('js/freelancerProfile.js') }}
@endsection
