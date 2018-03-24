@extends('main')

@section('title', '| Search for freelancer Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
        				<div class="col-md-12">
		                	<form method="POST" action="{{ route("freelancerSearchFilter") }}">
				            	{{ csrf_field() }}
								<div class="input-group col-md-8 col-sm-8">
				                    <input type="text" name="search" class="form-control" aria-label="..." placeholder="Search for Jobs">
				                    <div class="input-group-btn">
				                        <button type="submit" class="btn btn-default">Submit</button>
				                    </div>
				                	<div class="col-md-4 col-sm-4">
						        		<button type="button" class="btn btn-success" id="filterButton">Filters</button>
						        	</div>
				            	</div>
				                
				                <br><br>
				            
					            @if ($freelancersCount == 1)
					            	<h4><span class="badge">{{ $freelancersCount }}</span> Freelancer found</h4>
					            @else
					            	<h4><span class="badge">{{ $freelancersCount }}</span> Freelancers found</h4>
					            @endif

					        	<div class="row filters" style="display: none">
							    	<div class="col-md-12 col-sm-12">
							    		<hr>
							    		<div class="col-md-4 col-sm-4 form-group">
											<h4><strong>Earned Amount</strong></h4>
											  <input type="radio" name="earn_amount" value="Any" checked> Any amount earned<br>
											  <input type="radio" name="earn_amount" value="Hourly"> $1+ earned ()<br>
											  <input type="radio" name="earn_amount" value="Fixed price"> $100+ earned ()<br>
											  <input type="radio" name="earn_amount" value="Fixed price"> $1k+ earned ()<br>
											  <input type="radio" name="earn_amount" value="Fixed price"> $10k+ earned ()<br>
											  <input type="radio" name="earn_amount" value="Fixed price"> No earnings yet ()<br>
							    		</div>
							    		<div class="col-md-4 col-sm-4 form-group">
							    			<h4><strong>Hourly Rate</strong></h4>
											  <input type="radio" name="hourly_rate" value="Any" checked> Any hourly rate<br>
											  <input type="radio" name="hourly_rate" value="Entry Level"> $10 and below ()<br>
											  <input type="radio" name="hourly_rate" value="Intermediate"> $10 - $30 ()<br>
											  <input type="radio" name="hourly_rate" value="Expert"> $30 - $60 ()<br>
											  <input type="radio" name="hourly_rate" value="Expert"> $60 and above ()<br>
							    		</div>
							    		<div class="col-md-4 col-sm-4 form-group">
											<h4><strong>Freelancer Level</strong></h4>
											  <input type="radio" name="freelancer_level" value="Any" checked> Any Freelancer Level<br>
											  <input type="radio" name="freelancer_level" value="No_hires"> Entry Level<br>
											  <input type="radio" name="freelancer_level" value="Nr_1_9_hires"> Intermediate<br>
											  <input type="radio" name="freelancer_level" value="More_10_hires"> Expert<br><br><br><br>
							    		</div>
							    		<div class="col-md-4 col-sm-4">
											<h4><strong>English level</strong></h4>
											  <input type="radio" name="english_level" value="any" checked> Any level<br>
											  <input type="radio" name="english_level" value="Less_then_5"> Basic<br>
											  <input type="radio" name="english_level" value="Nr_5_to_10"> Conversational<br>
											  <input type="radio" name="english_level" value="Nr_15_to_20"> Fluent<br><input type="radio" name="nr_proposals" value="Nr_20_to_50"> Native or bilingual<br><br>
							    		</div>
							    		<div class="col-md-3 col-sm-3">
							    			<h4><strong>Country</strong></h4>
							    			<input type="text" name="country" class="form-control" placeholder="Search Location" />
							    		</div>
							    		<div class="col-md-3 col-sm-3">
							    			<h4><strong>Skill</strong></h4>
							    			<select class="form-control" name="skill">
							    				@foreach($skills as $skill)
							    					<option value='{{ $skill->id }}'>{{ $skill->skillName }}</option>
							    				@endforeach
							    			</select>
							    		</div>
							    		<hr>
							    	</div>
					        	</div>
					        </form>
				    	</div>
                	</div>
                </div>
                @foreach ($freelancers as $freelancer)
	                <div class="list-group">
	                    <a href=" {{ route('freelancerSearch.show', $freelancer->id)}}" class="list-group-item"><br>
                    		<span class="list-group-item-text">
	                    		<div class="row">
	                    			<div class="col-sm-2">
	                    				<img src="{{ asset('images/profile/' . $freelancer->image) }}" alt="" style="border-radius: 50%" height="110px" width="110px" />
	                    			</div>
	                    			<div class="col-sm-8">
	                    				<h4 class="list-group-item-text"><strong>{{$freelancer->firstName}} {{$freelancer->lastName}}</strong></h4>
	                    				<p class="list-group-item-text"><strong>{{$freelancer->title}}</strong><p>
	                    				<div class="row">
	                    					<div class="col-sm-4">
	                    						<h4>&#36;{{$freelancer->hourlyRate}} / hr</h4>
	                    					</div>
	                    					<div class="col-sm-4">
	                    						<h4>&#36; XXX / earned</h4>
	                    					</div>
	                    					<div class="col-sm-4">
	                    						<h5><b><span class="glyphicon glyphicon-map-marker"></span> {{ $freelancer->country }}</b></h5>
	                    					</div>
	                    				</div>
	                    				<p class="list-group-item-text">{{ substr(strip_tags($freelancer->description), 0, 100) }}{{ strlen(strip_tags($freelancer->description)) > 200 ? "..." : ""}}</p>
	                    			</div>
	                    			<div class="col-sm-2">
	                    				<h3>hello</h3>
	                    			</div>
	                    		</div>
                    		</span><br>
	                  	</a>
	                </div>
	            @endforeach
	            <div class="text-center">
					{!! $freelancers->links(); !!}
				</div>
					</div>
                </div>
        	</div>
    	</div>
    </div>
</div>
@endsection


@section('scripts')
	{{ Html::script('js/filtersButton.js') }}
@endsection





