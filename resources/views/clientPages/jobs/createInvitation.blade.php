@extends('main')

@section('title', '| Create Invitation')

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
    <div class="row">
        <div class="col-md-11 col-offset-md-1 col-sm-11 col-offset-sm-1 mainUser">
            <div class="panel panel-default">
            	<div class="panel-heading"><h2 class="padding-left">Create Invitation</h2></div>
                <div class="panel-body">
        			<div class="row">
						{!! Form::open(['route' => ['saveInvitation', $freelancer->id, $job_id], 'data-parsley-validate' => '', 'method' => 'POST']) !!}
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
											{!! Form::button('<strong>Submit Invitation</strong>', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn-block')) !!}
											{!! Form::close() !!}
										</div>
										<div class="col-md-5 col-offset-md-1 col-sm-5 col-offset-sm-2">
											{!! Html::linkRoute('inviteFreelancer', 'Cancel', array($id, $job_id), array('class' => 'btn btn-success btn-lg btn-block')) !!}
										</div>
									</div>
								</div>
							</div>
						{!! Form::close(); !!}
						</div><br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection