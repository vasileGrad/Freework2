@extends('main')

@section('title', '| Invite Freelancers Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
        				<div class="col-md-12">
		                	<form method="POST" action="{{ route('searchInviteFreelancers') }}">
		                		<input type="hidden" name="job_id" name="job_id" value="{{$job_id}}">
				            	{{ csrf_field() }}
								<div class="input-group col-md-8 col-sm-8 top-textarea">
				                    <input type="text" name="search" class="form-control" aria-label="..." placeholder="Search for freelancers">
				                    <div class="input-group-btn">
				                        <button type="submit" class="btn btn-default">Submit</button>
				                    </div>
				                	<div class="col-md-4 col-sm-4">
						        		{{-- <button type="button" class="btn btn-success" id="filterButton">Filters</button> --}}
						        	</div>
				            	</div>
				                
				                <br><br>
				            	
					            @if ($freelancers->total() === 1)
					            	<h4><span class="badge">{{ $freelancers->total() }}</span> Freelancer found</h4>
					            @else
					            	<h4><span class="badge">{{ $freelancers->total() }}</span> Freelancers found</h4>
					            @endif

					        	<div class="row filters" style="display: none">
							    	<div class="col-md-12 col-sm-12">
							    		<hr>
							    		<div class="col-md-4 col-sm-4">
							    			<h4><strong>Country</strong></h4>
							    			<input type="text" name="country" class="form-control" placeholder="Search Location" />
							    		</div>
							    		<div class="col-md-4 col-sm-4">
							    			<h4><strong>Skill</strong></h4>
							    			<select class="form-control" name="skill">
							    				@foreach($skills as $skill)
							    					<option value='{{ $skill->id }}'>{{ $skill->skillName }}</option>
							    				@endforeach
							    			</select>
							    		</div>
							    	</div>
					        	</div>
					        	<br>
					        </form>
				    	</div>
                	</div>
                </div>
                @foreach ($freelancers as $freelancer)
	                <div class="list-group"> 
	                    <a href="{{ route('inviteFreelancer', [$freelancer->id, $job_id])}}" class="list-group-item"><br>
                    		<span class="list-group-item-text">
	                    		<div class="row">
	                    			<div class="col-sm-2">
	                    				<img src="{{ asset('images/profile/' . $freelancer->image) }}" alt="" class="image-radius-client" height="110px" width="110px" />
	                    			</div>
	                    			<div class="col-sm-10">
	                    				<h4 class="list-group-item-text"><strong>{{$freelancer->firstName}} {{$freelancer->lastName}}</strong></h4>
	                    				<p class="list-group-item-text"><strong>{{$freelancer->title}}</strong><p>
	                    				<div class="row">
	                    					<div class="col-sm-4">
	                    						<h4>&#36;{{$freelancer->hourlyRate}} / hr</h4>
	                    					</div>
	                    					<div class="col-sm-4">
	                    						
	                    					</div>
	                    					<div class="col-sm-4">
	                    						<h5><b><span class="glyphicon glyphicon-map-marker"></span> {{ $freelancer->location }}, {{ $freelancer->country }}</b></h5>
	                    					</div>
	                    				</div><br>
	                    				<p class="list-group-item-text">{{ substr(strip_tags($freelancer->description), 0, 100) }}{{ strlen(strip_tags($freelancer->description)) > 200 ? "..." : ""}}</p>
	                    			</div>
	                    		</div>
                    		</span><br>
	                  	</a>
	                </div>
	            @endforeach

	            <div class="text-center">
					{!! $freelancers->links(); !!}
				</div>
			</div><br>
    	</div>
    </div>
</div>
@endsection

@section('scripts')
	{{ Html::script('js/filtersButton.js') }}
@endsection





