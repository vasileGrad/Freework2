@extends('main')

@section('title', '| Search for Skill Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
        				<div class="col-md-10 col-offset-md-4 col-sm-10 col-offset-sm-4"><br>
		                	<form method="GET" action="{{ route("findSkill") }}">
				            	{{ csrf_field() }}
								<div class="input-group col-md-12 col-offset-md-4 col-sm-12 col-offset-sm-4">
				                    <input type="text" name="search" class="form-control" aria-label="..." placeholder="Search for Skill">
				                    <div class="input-group-btn">
				                       <button type="submit" class="btn btn-default"><strong>Search</strong></button>
				                    </div>
				            	</div>
				                <br><br>
				            </form>
				    	</div>
                	</div>
                </div>
                @if($skills->count() == 0)
                	<div class="list-group center-title">
                		<span class="list-group-item-text">
                			<div class="col-sm-12">
                				<h3 class="list-group-item-text"><strong>Skill not found</strong></h3>
                			</div>
                		</span><br><br><br>
	                </div>
	            @else
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
		        @endif
	            <div class="text-center">
					{!! $skills->links(); !!}
				</div>
        	</div>
    	</div>
    </div>
</div>
@endsection