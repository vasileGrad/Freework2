@extends('main')

@section('title', '| Post a Job')

@section('content')

@section('stylesheets')

	{!! Html::style('css/parsley.css') !!}
	{!! Html::style('css/select2.min.css') !!}
	<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

	<script>
		tinymce.init({
			selector: 'textarea',
			plugins: 'link code lists image',
			menubar: false
		});
	</script>

@endsection
<div class="container"><br><br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Post a Job</h2></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

					<h3>Describe the Job</h3><br>


					{!! Form::open(['route' => 'jobs.store', 'data-parsley-validate' => '', 'files' => true]) !!}
				    	{{ Form::label('title', 'Name your job posting') }}
				    	{{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}
				    	<hr>
				    	{{ Form::label('description', 'Describe the work to be done', ['class' => 'margin-top-nav'])}}
				    	{{ Form::textarea('description', null, array('class' => 'form-control')) }}
						<hr>
						{{ Form::label('categoryId', 'Choose a Category') }}
						   	<select class="form-control" name="categoryId">
						   		@foreach($categories as $category)
						   			<option value='{{ $category->id }}'>{{ $category->categoryName }}</option>
						   		@endforeach
						   	</select>
						<hr>
						{{ Form::label('complexityId', 'Choose a Complexity') }}
						   	<select class="form-control" name="complexityId">
						   		@foreach($complexities as $complexity)
						   			<option value='{{ $complexity->id }}'>{{ $complexity->complexityName }}</option>
						   		@endforeach
						   	</select>
						<hr>
						{{ Form::label('expectedDurationId', 'Choose the expected duration') }}
						   	<select class="form-control" name="expectedDurationId">
						   		@foreach($durations as $duration)
						   			<option value='{{ $duration->id }}'>{{ $duration->durationName }}</option>
						   		@endforeach
						   	</select>
						<hr>
						{{ Form::label('paymentTypeId', 'How would you like to pay?') }}
						   	<select class="form-control" name="paymentTypeId">
						   		@foreach($payments as $payment)
						   			<option value='{{ $payment->id }}'>{{ $payment->paymentName }}</option>
						   		@endforeach
						   	</select>
						<hr>
						{{ Form::label('levelId', 'Desired Experience Level') }}
						   	<select class="form-control" name="levelId">
						   		@foreach($levels as $level)
						   			<option value='{{ $level->id }}'>{{ $level->levelName }}</option>
						   		@endforeach
						   	</select>
						<hr>
						{{ Form::label('skills', 'Skills:') }}
						   	<select class="form-control select2-multi" name="skills[]" multiple="multiple" required autofocus>
						   		@foreach($skills as $skill)
						   			<option value='{{ $skill->id }}'>{{ $skill->skillName }}</option>
						   		@endforeach
						   	</select>
						<hr>
						{{ Form::label('nrFreelancers', 'Ho many freelancers do you need to hire for this job?') }}
				    	{{ Form::text('nrFreelancers', null, array('class' => 'form-control', 'required' => '', 'numeric', 'min' => '1', 'max' => '10')) }}
				    	<hr>
				    	{{ Form::label('paymentAmount', 'Estimated Budget') }}
				    	{{ Form::text('paymentAmount', null, array('class' => 'form-control', 'required' => '', 'numeric', 'min' => '5', 'max' => '1000000')) }}

						<div class="col-md-6 col-md-offset-3">
					    	{{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top: 20px;')) }}
					    </div>
					{!! Form::close() !!}
			    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

	{!! Html::script('js/parsley.min.js') !!}
	{!! Html::script('js/select2.min.js') !!}

	<script type="text/javascript">
		$('.select2-multi').select2();
	</script>

@endsection