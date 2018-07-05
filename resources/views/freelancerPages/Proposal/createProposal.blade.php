@extends('main')

@section('title', '| Create Proposal Page')

@section('stylesheets')

	{!! Html::style('css/parsley.css') !!}
	<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

	<script>
		tinymce.init({
			selector: 'textarea',
			plugins: 'link code lists image',
			menubar: false
		});
	</script> 

@endsection

@section('content')
<div class="container">
	<h2>Submit a proposal</h2>
    <div class="row">
        <div class="col-md-11 col-offset-md-1 col-sm-11 col-offset-sm-1 mainUser">
            <div class="panel panel-default">
            	<div class="panel-heading"><h2>Job Details</h2></div>
                <div class="panel-body">
        			<div class="row">
        				<div class="col-md-9 col-sm-9">
        					<h4><strong>{{ $job->title }}</strong></h4><br>
							<h4>{!! $job->description !!}</h4><br>
        				</div>
        				<div class="col-md-3 col-sm-3">
        					<span class="glyphicon glyphicon-usd"></span> {{$job->levelName}}<br><br>
        					<span class="glyphicon glyphicon-time"></span> {{$job->paymentName}}<br><br>
        					<span class="glyphicon glyphicon-calendar"></span> {{$job->durationName}}
        					<p>&nbsp;&nbsp;&nbsp;&nbsp;Project length</p>
        				</div>
						
					</div>
				</div>
			</div><br>
			<div class="panel panel-default mainUser">
				{!! Form::open(['route' => ['storeProposal', $job->id], 'data-parsley-validate' => '', 'method' => 'POST']) !!}
	                <div class="panel-body">
	        			<div class="row"> 
	        				<div class="col-md-12 col-sm-12">
		        				{{ Form::label('body', 'Cover Letter', ['class' => 'margin-top-nav'])}}<br><br>
		        				{{ Form::textarea('body', null, array('class' => 'form-control','required' => '', 'minlength' => '5', 'maxlength' => '2000')) }}
		        			</div>
						</div>
					</div>
					<div class="panel-footer"><br>
					<div class="row ">
						<div class="col-md-6 col-sm-6">
							<div class="col-md-7 col-offset-md-1 col-sm-7 col-offset-sm-1">
								{!! Form::button('<strong>Submit a Proposal</strong>', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn-block')) !!}
								{!! Form::close() !!}
							</div>
							<div class="col-md-5 col-offset-md-1 col-sm-5 col-offset-sm-2">
								{!! Html::linkRoute('jobShow', 'Cancel', array($job->id), array('class' => 'btn btn-success btn-lg btn-block')) !!}
							</div>
						</div>
					</div>
				</div>
			</div><br>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection