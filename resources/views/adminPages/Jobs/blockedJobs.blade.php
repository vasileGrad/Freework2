@extends('main')

@section('title', '| Find Blocked Jobs Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
		                @if(count($jobs) == 0)
		                	<div class="list-group center-title">
		                		<span class="list-group-item-text">
		                			<div class="col-sm-12">
		                				<h3 class="list-group-item-text"><strong>We don't have blocked jobs</strong></h3>
		                			</div>
		                		</span><br><br><br>
			                </div>
			            @else
			                @foreach ($jobs as $job)
				                <div class="list-group center-title">
				                    <a href=" {{-- {{ route('categories.show', $category->id)}} --}}" class="list-group-item">
			                    		<span class="list-group-item-text">
			                    			<div class="col-sm-12">
			                    				<h3 class="list-group-item-text"><strong>{{$job->title}}</strong></h3>
			                    			</div>
			                    		</span><br><br><br>
				                  	</a>
				                </div>
				            @endforeach
				        @endif
                	</div>
                
	            <div class="text-center">
					{!! $jobs->links(); !!}
				</div>
        	</div>
    	</div>
    </div>
</div>
@endsection