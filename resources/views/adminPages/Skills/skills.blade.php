@extends('main')

@section('title', '| Show skills Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mainUser">
            <div class="panel panel-default">
            	<div class="panel-heading">
                	<div class="row">
                		<div class="col-md-6 col-sm-6 col-xs-6 pull-left">
							<h1>Skills</h1>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 pull-right">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<br><a class="btn btn-primary btn-md" href="{{ route('skills.create') }}" role="button"><strong>Add skill</strong></a>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<br><a class="btn btn-info btn-md" href="{{ route('showSkills') }}" role="button"><strong>Find skill</strong></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				@foreach ($skills as $skill)
	                <div class="list-group center-title">
	                    <a href=" {{ route('skills.show', $skill->id)}}" class="list-group-item">
                    		<span class="list-group-item-text">
                    			<div class="col-sm-12">
                    				<h3 class="list-group-item-text"><strong>{{$skill->skillName}}</strong></h3>
                    			</div>
                    		</span><br><br><br>
	                  	</a>
	                </div>
	            @endforeach
	            <div class="text-center">
					{!! $skills->links(); !!}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection