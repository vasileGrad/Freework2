@extends('main')

@section('title', '| View Job')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Jobs</div>

                <div class="panel-body">
                	@foreach($jobs as $job)
						<h3><strong>{{ $job->title }}</strong></h3>
						<hr>
						<h3>Description: {{ substr(strip_tags($job->description), 0, 50) }}{{ strlen(strip_tags($job->description)) > 50 ? "..." : "" }}</h3>
						<hr>
						<h3>Created at: {{ $job->created_at }}</h3>
						<hr>
						<h3>Category: {{ $job->categoryName }}</h3>
						<hr>
						<h3>Project Type: {{ $job->paymentName }}</h3>
						<hr>
						<h3>Country: {{ $job->country }}</h3>
						<hr>
						<h3>Price: &#36; {{ $job->paymentAmount }} </h3>
						<h3>Payment type: {{ $job->paymentName }}</h3>
						<hr>
						<h3>Complexity: {{ $job->complexityName }}</h3>
						<hr>
						<h3>Level: {{ $job->levelName }}</h3>
						<hr>
						<div class="tags">
							@foreach($jobs2->skills as $skill)
								<span class="label label-info">{{ $skill->skillName }}</span>
							@endforeach
						</div>
						<h3></h3>
					@endforeach
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
                <div class="panel-heading">Jobs</div>
                	<div class="panel-body">
                		<a href="#" class="btn btn-success btn-lg active" role="button">Submit a Proposal</a><br><br>

                		{!! Form::open(['route' => ['jobSaved.store', $job->id], 'method' => 'POST']) !!}
						    {!! Form::submit('Save Job', array('class' => 'btn btn-success btn-lg active')) !!}
                		{!! Form::close() !!}

                		<br>
                		<!-- Button trigger modal -->
                		<br>
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
						  Launch demo modal
						</button>

						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-3" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
						      </div>
						      <div class="modal-body">
						        {{ $job->title}}
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						        <button type="button" class="btn btn-primary">Save changes</button>
						      </div>
						    </div>
						  </div>
						</div>

                		@foreach($jobs as $job)

                		@endforeach
                	</div>
           	</div>
		</div>
    </div>
</div>
@endsection



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">
	$.ajaxSetup({
	    headers: {
	    	'X-CSRF-TOKEN': $('meta[name=_token]').attr('content')
	        //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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

</script>