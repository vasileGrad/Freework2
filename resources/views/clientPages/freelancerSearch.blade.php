@extends('main')

@section('title', '| Search for freelancer Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row"><br>
        				<div class="col-md-8">
		                	<form method="POST" action="{{-- {{ route('clientPages.freelancerSearch') }} --}}">
				            	{{ csrf_field() }}
				                <div class="input-group">
				                    <input type="text" name="search" class="form-control input-lg" aria-label="..." placeholder="Search for Freelancers"><br>
				                    <div class="input-group-btn">
				                       <button type="submit" class="btn btn-default btn-lg"><i class="fa fa-search fa-lg"></i></button>
				                    </div>
				                </div><br><br>
				            </form>
				        </div>
				        <div class="col-md-4">
				        	<button type="submit" class="btn btn-success btn-lg" id="filterButton">Filters</button>
				        </div>
				    </div>
				    <div class="row filters" style="display: none">
				    	<div class="col-md-8">
				    		<hr>
				    		<h2>jadlkj;lakjf;ljk</h2>
				    		<h2>jadlkj;lakjf;ljk</h2>
				    		<h2>jadlkj;lakjf;ljk</h2>
				    		<h2>jadlkj;lakjf;ljk</h2>
				    		<hr>
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
	{{ Html::script('js/filterButtonFreelancer.js') }}
@endsection

	{{-- <script type="text/javascript">
	// I solved the problem with the menu :) 

	$('#filterButton').click(function(){
	    $('.filters').toggle();
	});

	$(document).on('click', '#filterButton', function(event) {
		$('.filters').toggle();
	})
	</script>
@endsection --}}

{{-- 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">

	$(document).ready(function() {
		$(document).on('click', '#filterButton', function(event) {
			$('.filters').toggle();
		});
	});

</script> --}}



