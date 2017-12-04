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
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Post a Job </h2></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

					<h3>Describe the Job</h3><br>

					{!! Form::open(['route' => 'clientPages.store', 'data-parsley-validate' => '', 'files' => true]) !!}
				    	{{ Form::label('title', 'Name your job posting') }}
				    	{{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}

				    	{{ Form::label('description', 'Describe the work to be done', ['class' => 'margin-top-nav'])}}
				    	{{ Form::textarea('body', null, array('class' => 'form-control')) }}
						<hr>
						{{ Form::label('categoryId', 'Choose a Category') }}
						   	<select class="form-control" name="categoryId">
						   		@foreach($categories as $category)
						   			<option value='{{ $category->id }}'>{{ $category->name }}</option>
						   		@endforeach
						   	</select>

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