@extends('main')

@section('title', '| Add category')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                		<div class="col-md-10">
							<h1>Add category</h1>
						</div>
                	</div>
				</div><br><br>
				<div class="form-group">
					<div class="row">
						<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 pull-left">
		                    {!! Form::open(['route' => 'categories.store', 'data-parsley-validate' => '', 'files' => true]) !!}
		                        {{ Form::label('title', 'Insert:') }}
		                        {{ Form::text('title', null, array('placeholder'=>'Insert a category','class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}
		                        {{ Form::submit('Create Category', array('class' => 'btn btn-success btn-md', 'style' => 'margin-top: 20px;')) }}
		                    {!! Form::close() !!}<br>
						</div>
					</div>
				</div><br><br>
			</div>
		</div>
	</div>
</div>
@endsection
