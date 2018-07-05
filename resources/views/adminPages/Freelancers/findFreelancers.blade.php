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
		                	<form method="GET" action="{{ route('findFreelancerFilter') }}">
				            	{{ csrf_field() }}
								<div class="input-group col-md-6 col-sm-6 padding-left mainUser">
				                    <input type="text" name="search" class="form-control" aria-label="..." placeholder="Search freelancers">
				                    <div class="input-group-btn">
				                        <button type="submit" class="btn btn-default">Submit</button>
				                    </div>
				            	</div>
				                
				                <br><br>
				            	@if(isset($freelancersCount))
						            @if ($freelancersCount == 1)
						            	<h4><span class="badge">{{ $freelancersCount }}</span> Freelancer found</h4>
						            @elseif($freelancersCount >= 1)
						            	<h4><span class="badge">{{ $freelancersCount }}</span> Freelancers found</h4>
						            @endif
						        @endif
					        </form>
				    	</div>
                	</div>
                </div>
                @if($freelancers->total() == 0)
                	<div class="list-group center-title">
                		<span class="list-group-item-text">
                			<div class="col-sm-12">
                				<h3 class="list-group-item-text"><strong>No freelancers found</strong></h3>
                			</div>
                		</span><br><br><br>
	                </div>
	            @else
	                @foreach ($freelancers as $freelancer)
		                <div class="list-group">
		                    <a href="{{ route('showFreelancer', $freelancer->id)}}" class="list-group-item"><br>
	                    		<span class="list-group-item-text">
		                    		<div class="row">
		                    			<div class="col-sm-2">
		                    				<img src="{{ asset('images/profile/' . $freelancer->image) }}" alt="" class="image-radius-admin" height="110px" width="110px" />
		                    			</div>
		                    			<div class="col-sm-5">
		                    				<h4 class="list-group-item-text"><strong>{{$freelancer->firstName}} {{$freelancer->lastName}}</strong></h4><br>
		                    				<p class="list-group-item-text"><strong>{{$freelancer->title}}</strong><p><br>
		                    				<h4>&#36;{{$freelancer->hourlyRate}} / hr</h4>
		                    			</div>
		                    			<div class="col-sm-5">
		                    				<br><p class="list-group-item-text">{{ substr(strip_tags($freelancer->description), 0, 100) }}{{ strlen(strip_tags($freelancer->description)) > 200 ? "..." : ""}}</p><br>
	                						<h5><b><span class="glyphicon glyphicon-map-marker"></span> {{ $freelancer->location }}, {{$freelancer->country}}</b></h5>
	                					</div>

		                    		</div>
	                    		</span><br>
		                  	</a>
		                </div>
		            @endforeach
		            <div class="text-center">
						{!! $freelancers->links(); !!}
					</div>
				@endif
        	</div>
    	</div>
    </div>
</div>
@endsection





