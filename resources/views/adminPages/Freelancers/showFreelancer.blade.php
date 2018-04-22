@extends('main')

@section('title', '| Show Freelancer Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mainUser">
            <div class="panel panel-default">
                <div class="panel-body">
        			<div class="row">
        				<div class="col-md-12 col-sm-12">
        					<div class="col-md-3 col-sm-3">
				    			<img src="{{ asset('images/profile/' . $freelancer->image) }}" alt="" class="image-radius-freelancer" height="110" width="110"/>
				    		</div>
        					<div class="col-md-6 col-sm-6">
						  		<br><h3 class="list-group-item-heading"><strong>{{ $freelancer->firstName }} {{ $freelancer->lastName }}</strong></h3><br>
						  		<h4><b>{{ $freelancer->title }}</b></h4>
						  		<h5><b>${{ $freelancer->hourlyRate }}/hour</b></h5><br>
						  		@php
						    		$earnings = "$freelancer->earnings";
						    	@endphp
						    	@if($earnings != '')
						    		<h5><b>${{ $earnings }} Total earnings</b></h5>
						    	@else
						    		<h5><b>No earnings</b></h5>
						    	@endif
						    </div>
						    <div class="col-md-3 col-sm-3">
						    	<br><h5><span class="glyphicon glyphicon-map-marker"><b>{{$freelancer->location}}</b></span></h5>
						    	<h5>&ensp;&ensp;<b>{{ $freelancer->country }}</b></h5><br>
						    	<h5>&ensp;&ensp;<b>{{ $freelancer->levelName }}</b></h5>
						    </div>
        				</div>
					</div><hr>
					<div class="row">
						<div class="col-md-12 col-sm-12 padding-left">
							<h4><strong>Skills of the freelancer</strong></h4><br>
							@if(!$freelancer_skills)
								<div class="row padding-left">
									@foreach($freelancer_skills as $skill)
										<span class="label label-info label-skill">{{ $skill->skillName }}</span>
									@endforeach
								</div>
							@else
								<h4>No skills</h4>
							@endif
						</div>	
					</div><hr>
                </div>
        	</div>
    	</div>
    	<div class="col-md-3 col-sm-12 mainUser">
    		<div class="panel panel-default">
                <div class="panel-body">
					<div class="col-md-12 col-sm-6"><br>
						@if($freelancer->statusActiv == 1)
							<form method="POST" action="{{ route('blockFreelancer', $freelancer->id) }}">
				            	{{ csrf_field() }}
				                <button type="submit" class="btn btn-danger btn-block">Block Freelancer</button>
				            </form>
						@elseif($freelancer->statusActiv == 0)
							<form method="POST" action="{{ route('unblockFreelancer', $freelancer->id) }}">
				            	{{ csrf_field() }}
				                <button type="submit" class="btn btn-danger btn-block">Unblock Freelancer</button>
				            </form>
						@endif
						<br><hr>
					</div>
                </div>
        	</div>
    	</div>
	</div>
@endsection