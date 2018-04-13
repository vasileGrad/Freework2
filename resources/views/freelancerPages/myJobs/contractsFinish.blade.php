@extends('main')

@section('title', '| Show Contracts Freelancer')

@section('content')
<div class="container">
	<h2 class="padding-left">My Contracts</h2><br>
	<div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row padding-left">
        				<div class="col-md-6">
				            @if( $contracts->total() == 1)
								<h3><span class="glyphicon glyphicon-check badge"></span> {{ $contracts->total() }} contract found</h3>
							@elseif( $contracts->total() > 1)
								<h3><span class="glyphicon glyphicon-check badge"></span> {{ $contracts->total() }} contracts found</h3>
							@elseif( $contracts->total() == 0)
								<h2>No Contracts</h2>
							@endif
				        </div>
				    </div>
                </div>
                <div class="panel-body">
                	@foreach($contracts as $contract)
	                	<div class="row padding-left">
	                		<div class="col-md-8 col-sm-8 mainUser">
	                			<a href="#"{{-- data-toggle="modal" data-target="#jobTitle" --}}><h4 id="jobTitle">{{ $contract->title}}</h4></a>
	                			<h4><b>{{ $contract->firstName}} {{ $contract->lastName}}</b></h4>
	                			<h5>{{ date('M j, Y', strtotime($contract->startTime)) }} - {{ date('M j, Y', strtotime($contract->endTime)) }} </h5>
	                		</div>
	                		<div class="col-md-4 col-sm-4 mainUser">
	                			<h4><b>${{ $contract->paymentAmount}}</b> Budget</h4>
	                			<h4>Completed {{ date('M j, Y', strtotime($contract->endTime)) }}</h4><br>
	                			@php
									$rate = "$contract->rateClient"
								@endphp
	                			<h4>Feedback &nbsp;&nbsp;&nbsp;
	                			@for ($i = 1; $i <=$rate; $i++)
									<span class="glyphicon glyphicon-star star_review_color"></span>
	                			@endfor
	                			</h4>
	                		</div>

	                		<!-- Modal showing Job information-->
		                	<div class="modal fade" id="jobTitle" tabindex="-3" role="dialog" aria-labelledby="myModalLabel">
		                	    <div class="modal-dialog modal-lg" role="document">
		                	        <div class="modal-content">
		                	            <div class="modal-header">
		                	            	<div class="col-md-8 col-sm-8 mainUser">
		                	            		<h4 class="modal-title" id="title">{{ $contract->title }}</h4>
		                	            	</div>
		                	            	<div class="col-md-4 col-sm-4 mainUser">
		                	            	<img src="{{ asset('images/profile/' . $contract->image) }}" alt="" class="image-radius-freelancer" height="70" width="70"/>
		                	            	</div>
		                	                
		                	            </div>
		                	            <div class="modal-body">
		                	                <div class="bodyTitle">
		                	                    <div class="form-group">
		                	                        <label for="Rate It">{{ $contract->title}}</label>
		                	                        
		                	                        <select v-model="rateClient" name="rating" id="rate" class="form-control" >
		                	                            <option value="5"> 5 </option>
		                	                            <option value="4"> 4 </option>
		                	                            <option value="3"> 3 </option>
		                	                            <option value="2"> 2 </option>
		                	                            <option value="1"> 1 </option>
		                	                        </select>
		                	                    </div>

		                	                    <div class="form-group">
		                	                        <label for="Tell us more">What was it like working with this Freelancer?</label>
		                	                        <textarea rows="4" class="form-control" id="review" v-model="reviewClient">
		                	                        </textarea>
		                	                    </div>
		                	                </div>
		                	            </div>
		                	            <div class="modal-footer">
		                	                <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal">Cancel</button>
		                	                <button type="button" class="btn btn-primary" id="sendFeedback" data-dismiss="modal" @click="leaveReviewClient()">Send Feedback</button>
		                	            </div>
		                	        </div>
		                	    </div>
		                	</div>
	                	</div><br><hr>
	                @endforeach
		            <div class="text-center">
						{!! $contracts->links(); !!}
					</div>
                </div>
            </div><br><br>
        </div>
    </div>
</div>
@endsection
