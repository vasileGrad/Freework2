@extends('main')

@section('title', '| Show Job Page')

@section('content')
<div class="container">
	<a href="{{route('goBack')}}"><h4><span class="glyphicon glyphicon-menu-left"></span> <strong>Back to jobs list</strong></h4></a>
    <div class="row">
        <div class="col-md-8 mainUser">
            <div class="panel panel-default">
                <div class="panel-body">
        			<div class="row">
        				<div class="col-md-12 col-sm-12">
        					<div class="col-md-8 col-sm-8 padding-left">
						  		<br><h3 class="list-group-item-heading"><strong>{{$job->title}}</strong></h3><br><br>
						  		<span class="label label-default label-skill">{{$job->categoryName}}</span>    Posted {{ date( 'M j, Y h', strtotime($job->created_at)) }} <br>
					    		<br><h4 class="list-group-item-text">{{ strip_tags($job->description) }}</h4>
					    		<br>
					    		@if(count($uploads))
						    		<h4><b>Attachments ({{ count($uploads) }})</b></h4>
									@foreach($uploads as $upload)
										@php 
											{{ $fileName = "$upload->fileName"; }}
										@endphp
										<a href="{{ route('downloadFileFreelancer', $fileName) }}"><span class="glyphicon glyphicon-paperclip">&nbsp;</span><b>{{ $upload->fileName }}</b></a><br>
									@endforeach
								@endif
						    </div>
						    <div class="col-md-3 col-sm-3 pull-right">
						    	<br><br><br><br>
						    	<h4>&#36;{{ $job->paymentAmount }}</h4>
						    	<h4>{{ $job->paymentName}}</h4><hr>
						    	<h4>{{$job->levelName}} Level</h4>
						    </div>
        				</div>
					</div><hr>
					<div class="row">
						<div class="col-md-12 col-sm-12 padding-left">
							<h4><strong>Skills and Expertise</strong></h4><br>
							@if(count($job_skills) != 0)
								<div class="row padding-left">
									@foreach($job_skills as $skill)
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
    	<div class="col-md-4 col-sm-12 mainUser">
    		<div class="panel panel-default">
                <div class="panel-body">
					<div class="col-md-10 col-sm-11"><br>
						@if($proposal == 0)
							{!! Form::open(['route' => ['createProposal', $job->id], 'method' => 'POST']) !!}
								{!! Form::button('<strong>Submit a Proposal</strong>', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn-block')) !!}
				            {!! Form::close() !!}<br><br>
				        @elseif($proposal == 1)
							<h4>Proposal submitted</h4>
						@endif
							
						@if($job_saved == 0)
							{!! Form::open(['route' => ['saveJob', $job->id], 'method' => 'POST']) !!}
								{!! Form::button('<span class="glyphicon glyphicon-heart-empty"></span>&nbsp;&nbsp;&nbsp;<strong>Save Job</strong>', array('type' => 'submit', 'class' => 'btn btn-default btn-lg btn-block')) !!}
			            	{!! Form::close() !!}
						@elseif($job_saved == 1)
							{!! Form::open(['route' => ['unsaveJob', $job->id], 'method' => 'POST']) !!}
								{!! Form::button('<span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Saved</strong>', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn-block')) !!}
			            	{!! Form::close() !!}
    					@endif

						<br><hr>
					  	<h5><strong>About the Client</strong></h5><br>
					  	<h5><strong>{{$job->firstName}}</strong></h5>
					  	<h5><span class="glyphicon glyphicon-map-marker"> {{ $job->country }}, {{$job->location}}</span></h5><br>
					  	<h5><strong>Nr Freelancers</strong></h5>
					  	<h5><strong>{{$job->nrFreelancers}}</strong></h5>
					</div>
                </div>
        	</div>
    	</div>
	</div>
@endsection

{{--
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">
	$.ajaxSetup({
	    headers: {
	    	'X-CSRF-TOKEN': $('meta[name=_token]').attr('content')
	    }
	});

	$(document).ready(function() {
		$(document).on('click', '.editNew', function(event) {
			var text = $(this).text();
			$('#title').text('Edit Item');
			var text = $.trim(text);
			$('#addItem').val(text);
			$('#delete').show('400');
			$('#saveChanges').show('400');
			$('#addButton').hide('400');
			$('#id').val(id);
			console.log(text);
		});

		$(document).on('click', '#addNew', function(event) {
			$('#title').text('Add New Item');
			$('#addItem').val("");
			$('#delete').hide('400');
			$('#saveChanges').hide('400');
			$('#addButton').show('400');
		});
		
		$('#saveChanges').click(function(event) {
			var text = $("#addItem").val();
			if (text =="") {
				alert('Please type anything for item');
			}else{
				$.post('/updateTitle', {'text': text, '_token': $('input[name="_token"]').val()}, function(data){
				$('#items').load(location.href + ' #items');  //refresh the page
				//console.log(id);
				console.log(data);
				});
			}
		});
	});

</script> --}}