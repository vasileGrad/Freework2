@extends('main')

@section('title', '| Show category')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                		<div class="col-md-10">
							<h1>Show category</h1>
						</div>
                	</div>
				</div><br><br>
					<div class="form-group">
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<div class="col-md-6 col-sm-6">
									<h1>{{$category->categoryName}}</h1>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="row"><br>
										<div class="col-md-6 col-sm-6">
											{!! Html::linkRoute('categories.edit', 'Edit', array($category->id), array('class' => 'btn btn-primary btn-block')) !!}
										</div>
										<div class="col-md-6 col-sm-6">
											{!! Form::open(['route' => ['categories.destroy', $category->id],'method' => 'DELETE'] ) !!}
												{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}
											{!! Form::close() !!}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<br><br>
			</div>
		</div>
	</div>
</div>
@endsection
