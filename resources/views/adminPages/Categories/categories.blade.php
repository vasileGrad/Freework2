@extends('main')

@section('title', '| Show Categories Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                		<div class="col-md-6 col-sm-6 col-xs-6 pull-left">
							<h1>Categories</h1>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 pull-right">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<br><a class="btn btn-primary btn-md" href="{{ route('categories.create') }}" role="button"><strong>Add category</strong></a>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<br><a class="btn btn-info btn-md" href="{{ route('showCategories') }}" role="button"><strong>Find category</strong></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				@foreach ($categories as $category)
	                <div class="list-group center-title">
	                    <a href=" {{ route('categories.show', $category->id)}}" class="list-group-item">
                    		<span class="list-group-item-text">
                    			<div class="col-sm-12">
                    				<h3 class="list-group-item-text"><strong>{{$category->categoryName}}</strong></h3>
                    			</div>
                    		</span><br><br><br>
	                  	</a>
	                </div>
	            @endforeach
	            <div class="text-center">
					{!! $categories->links(); !!}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection