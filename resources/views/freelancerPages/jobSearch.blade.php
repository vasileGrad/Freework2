@extends('main')

@section('title', '| Freelancer Job Search Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
        				<div class="col-md-12">
		                	<form method="POST" action="{{ route("jobSearchFilter") }}">
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
				            
					            @if (count($jobs) === 1)
					            	<h4><span class="badge">{{ count($jobs) }}</span> Job found</h4>
					            	
					            @else
					            	<h4><span class="badge">{{ count($jobs) }}</span> Jobs found</h4>
					            @endif

					        	<div class="row filters" style="display: none">
							    	<div class="col-md-12">
							    		<hr>
							    		<div class="col-md-4 col-sm-4 form-group">
											<h4><strong>Job Type</strong></h4>
											  <input type="radio" name="job_type" value="Any" checked> Any Job Type<br>
											  <input type="radio" name="job_type" value="Hourly"> Hourly ({{$hourly}})<br>
											  <input type="radio" name="job_type" value="Fixed price"> Fixed Price ({{$fixed_price}})<br>
							    		</div>
							    		<div class="col-md-4 col-sm-4 form-group">
							    			<h4><strong>Experience Level</strong></h4>
											  <input type="radio" name="experience_level" value="Any" checked> Any Experience Level<br>
											  <input type="radio" name="experience_level" value="Entry Level"> Entry Level ({{$entry_level}})<br>
											  <input type="radio" name="experience_level" value="Intermediate"> Intermediate ({{$intermediate}})<br>
											  <input type="radio" name="experience_level" value="Expert"> Expert ({{$expert}})<br>
							    		</div>
							    		<div class="col-md-4 col-sm-4 form-group">
											<h4><strong>Client History</strong></h4>
											  <input type="radio" name="nr_proposals" value="any" checked> Any Number of Proposals<br>
											  <input type="radio" name="nr_proposals" value="Less_then_5"> Less than 5<br>
											  <input type="radio" name="nr_proposals" value="Nr_5_to_10"> 5 to 10<br>
											  <input type="radio" name="nr_proposals" value="Nr_15_to_20"> 15 to 20<br><input type="radio" name="nr_proposals" value="Nr_20_to_50"> 20 to 50<br><br>
							    		</div>
							    		<div class="col-md-4 col-sm-4 form-group">
											<h4><strong>Number of Proposals</strong></h4>
											  <input type="radio" name="client_history" value="Any" checked> Any Client History<br>
											  <input type="radio" name="client_history" value="No_hires"> No Hires<br>
											  <input type="radio" name="client_history" value="Nr_1_9_hires"> 1-9 Hires<br>
											  <input type="radio" name="client_history" value="More_10_hires"> 10+ Hires<br>
							    		</div>
							    		<div class="col-md-4 col-sm-4 form-group">
											<h4><strong>Budget</strong></h4>
											  <input type="radio" name="budget" value="Any" checked> Any Budget<br>
											  <input type="radio" name="budget" value="Less_than_100"> Less than $100 ({{$less_100}})<br>
											  <input type="radio" name="budget" value="Budget_100_500"> $100 - $500 ({{$between_100_500}})<br>
											  <input type="radio" name="budget" value="Budget_500_1k"> $500 - $1k ({{$between_500_1k}})<br>
											  <input type="radio" name="budget" value="Budget_1k_5k"> $1k - $5k ({{$between_1k_5k}})<br>
											  <input type="radio" name="budget" value="More_than_5k"> $5k+ ({{$more_5k}})<br>
							    		</div>
							    		<div class="col-md-4 col-sm-4 form-group">
											<h4><strong>Project Length</strong></h4>
											  <input type="radio" name="project_length" value="Any" checked> Any Project Length<br>
											  <input type="radio" name="project_length" value="Less than 1 week"> Less than 1 week ({{$less_one_week}})<br>
											  <input type="radio" name="project_length" value="Less than 1 month"> Less than 1 month ({{$less_one_month}})<br>
											  <input type="radio" name="project_length" value="1 to 3 months"> 1 to 3 months ({{$one_three_months}})<br>
											  <input type="radio" name="project_length" value="3 to 6 months"> 3 to 6 months ({{$three_six_months}})<br>
											  <input type="radio" name="project_length" value="More than 6 months"> More than 6 months ({{$more_six_months}})<br><br>
							    		</div><hr>
							    	</div>
					        	</div>
					        </form>
				    	</div>
                	</div>
                </div>
                <div class="panel-body">
                	<div class="list-group">
                		@foreach ($jobs as $job)
                			<div class="row">
							  	<a href="{{ route('jobShow', $job->id)}}" class="list-group-item">
							  	{{-- <a href="{{ route('showJob.show', $job->id)}}" class="list-group-item"> --}}
							  		<span>
								  		<h4 class="list-group-item-heading"><strong>{{$job->title}}</strong>
								    	<button type="button" class="btn btn-sm btn-circle pull-right glyphicon glyphicon-heart-empty"></button></h4><br>
							  		</span>
							    	
							    	<h4 class="list-group-item-text"><strong>{{$job->paymentName}}</strong> - {{$job->levelName}} - Budget: &#36;{{ $job->paymentAmount }} - Posted: {{ $job->created_at }}</h4><br>
							    	<h4 class="list-group-item-text">{{ substr(strip_tags($job->description), 0, 30) }}{{ strlen(strip_tags($job->description)) > 30 ? "..." : ""}}</h4><br>
							    	<small>
							    		<h5 class="list-group-item-text"><strong>Client: {!! $job->firstName !!}</strong> <span class="glyphicon glyphicon-map-marker">{!! $job->country !!}</span></h5>
							    	</small><br>
							  	</a>
							</div>
						@endforeach
					</div>
                </div>
        	</div>
    	</div>
	</div>
@endsection

@section('scripts')
	{{ Html::script('js/filtersButton.js') }}
@endsection


{{-- <!--Radio group-->
	<div class="form-check2">
	    <input name="102" type="radio" class="with-gap" id="radio106" checked>
	    <label for="radio106">Any Experience Level</label>
	</div>

	<div class="form-check2">
	    <input name="102" type="radio" class="with-gap" id="radio107">
	    <label for="radio107">Entry Level</label>
	</div>

	<div class="form-check2">
	    <input name="102" type="radio" class="with-gap" id="radio108">
	    <label for="radio108">Intermediate</label>
	</div>
	<div class="form-check2">
	    <input name="102" type="radio" class="with-gap" id="radio108">
	    <label for="radio108">Expert</label>
	</div>
<!--Radio group--> --}}
