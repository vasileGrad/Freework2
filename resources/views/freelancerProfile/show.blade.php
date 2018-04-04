@extends('main')

@section('title', '| Profile')

@section('content')
<div class="container">
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
		    <div class="panel-heading"><h3>Profile</h3>
		</div>
	    <div class="panel-body" id="items"> 
	    	<div class="row">
	    		<div class="col-md-3">
	    			<img src="{{ asset('images/profile/' . $freelancer->image) }}" alt="" class="image-radius-freelancer" height="120" width="120"/>
	    		</div>
	    		<div class="col-md-6">
	    			<h2><b>{{ $freelancer->firstName }} {{ $freelancer->lastName }}<b></h2>
					<h5><span class="glyphicon glyphicon-map-marker"></span><b> {{ $freelancer->location }}, {{ $freelancer->country }}<b></h5>
	    		</div>
	    		<div class="col-md-12">
	    			<h3 class="editTitle"><a href="#" data-toggle="modal" data-target="#myModal1"><b>{{ $freelancer->title }} <b><input type="hidden" id="itemId2" value="{{$freelancer->id}}"><i class="glyphicon glyphicon-edit"></i></a></h3><br>

	    			<h4 class="editDescription"><a href="#" class="pull-right" data-toggle="modal" data-target="#myModal1"><h3><i class="glyphicon glyphicon-edit"></i></h3></a>{{ $freelancer->description }}<input type="hidden" id="id" value=""></h4><br> 
	    			<hr>
	    		</div>
		    	<div class="col-sm-3">
	    			<h4><b>&#36;{{ $freelancer->hourlyRate }}<b></h4>
	    			<h4>Hourly Rate</h4>
	    		</div>
	    		<div class="col-sm-3">
	    			<h4>Total earned</h4>
	    		</div>
	    		<div class="col-sm-3">
	    			<h4>Jobs</h4>
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
			        	<button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display: none">Delete</button>
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
	  			<div class="col-md-10">
	  				<h3>Work History and Feedback</h3>
	  			</div>
	  			<div class="col-md-2">
	  				<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#myModal"><b>+ Edit<b></button>
	  			</div>
	  		</div>
		</div>
	  	<div class="panel-body">
		    Panel content
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


	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Portfolio</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	Panel content
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Skills</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	@foreach($freelancer->skills as $skill)
			<h3><span class="label label-info">{{ $skill->skillName }}</span></h3>
		@endforeach
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Certifications</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	No items to display.
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Tests</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	No items to display.
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Employment History</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	Informations
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	    	<h3 class="panel-title"><h3>Education</h3></h3>
	  	</div>
	  	<div class="panel-body">
	    	Degrees and certifications
	  	</div>
	</div>
</div> <!-- end of .col-md-8 -->
</div>
</div>
{{ csrf_field() }}
@endsection

	
@section('scripts')
	{{ Html::script('js/freelancerProfile.js') }}
@endsection

	{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
	
	{{-- This was the problem with the menu and the shifting left  --}}

	{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> --}}

{{-- <script type="text/javascript">
	$.ajaxSetup({
	    headers: {
	    	'X-CSRF-TOKEN': $('meta[name=_token]').attr('content')
	        //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(document).ready(function() {
		$(document).on('click', '.editTitle', function(event) {
			var text = $(this).text();
			$('#title').text('Edit Job Title');
			var text = $.trim(text);
			$('#addItem').val(text);
			$('.bodyTitle').show();
			$('.bodyDescription').hide();
			$('#delete').show('400');
			$('#saveChanges').show('400');
			$('#saveChanges2').hide();
			console.log(text);
		});

		$(document).on('click', '.editDescription', function(event) {
			var text2 = $(this).text();
			console.log(text2);
			$('#title').text('Overview');
			$('#overview').val(text2);
			$('.bodyTitle').hide();
			$('.bodyDescription').show();
			$('#delete').show('400');
			$('#saveChanges2').show('400');
			$('#saveChanges').hide();
		});

		/*$('#delete').click(function(event) {
			var id = $("#id").val();
			$.post('delete', {'id': id, '_token': $('input[name="_token"]').val()}, function(data){
			$('#items').load(location.href + ' #items');  //refresh the page
			//console.log(id);
			console.log(data);
			});
		});*/

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

		$('#saveChanges2').click(function(event) {
			var text2 = $("#overview").val();
			if (text2 =="") {
				alert('Please type anything for item');
			}else{
				$.post('/updateOverview', {'text': text2, '_token': $('input[name="_token"]').val()}, function(data){
				$('#items').load(location.href + ' #items');  //refresh the page
				//console.log(id);
				console.log(data);
				});
			}
		});
	});

</script>

@endsection --}}