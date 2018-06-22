@extends('main')

@section('title', '| Edit category')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                		<div class="col-md-10">
							<h1>Edit category</h1>
						</div>
                	</div>
				</div><br><br>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							{!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'PUT']) !!}
							<div class="col-md-6 col-sm-6">
								{{ Form::label('title', "Category:") }}
								{{ Form::text('categoryName', null, ["class" => 'form-control']) }}
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="row"><br>
									<div class="col-md-6 col-sm-6">
										{!! Html::linkRoute('categories.show', 'Cancel', array($category->id), array('class' => 'btn btn-danger btn-block')) !!}
									</div>
									<div class="col-md-6 col-sm-6">
										{{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) }}
									</div>
								</div>
							</div>
						{!! Form::close() !!}
						</div>
					</div>
				</div><br><br>
			</div>
		</div>
	</div>
</div>
@endsection
