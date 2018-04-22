@extends('main')

@section('title', '| Freelancer Job Saved Page')

@section('content')
<div class="container">
	<h2>My Proposals</h2><br><hr>
	<div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row padding-left">
        				<div class="col-md-6">
				            @if(count($proposals) == 1)
								<h2>{{count($proposals)}} Submitted Proposal</h2>
							@elseif(count($proposals) > 1)
								<h2>{{count($proposals)}} Submitted Proposals</h2>
							@elseif(count($proposals) == 0)
								<h2>No Proposals</h2>
							@endif
				        </div>
				    </div><br>
                </div>
                <div class="panel-body">
                	<div class="row padding-left">
                		<div class="col-md-4 col-sm-4 mainUser">
                			<h5><strong>DATE INITIATED</strong></h5>
                		</div>
                		<div class="col-md-8 col-sm-8 mainUser">
                			<h5><strong>JOB</strong></h5>
                		</div>
                	</div><br><hr>
                	@foreach($proposals as $proposal)
	                	<div class="row padding-left">
	                		<div class="col-md-4 col-sm-4 mainUser">
	                			<h5>{{ date('M j, Y', strtotime($proposal->created_at)) }}</h5>
	                		</div>
	                		<div class="col-md-8 col-sm-8 mainUser">
	                			<a href="{{route('freelancerProposal.show', $proposal->id)}}"><h5 class="color-link"><strong>{{$proposal->title}}</strong></h5></a>
	                		</div>
	                	</div><br><hr>
	                @endforeach
                </div>
            </div><br><br>
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row padding-left">
        				<div class="col-md-6">
				            <h2>Invitations to interview</h2>
				        </div>
				    </div><br>
                </div>
                <div class="panel-body">
                	<div class="row padding-left">
                		<div class="col-md-4 col-sm-4 mainUser">
                			<h5><strong>DATE INITIATED</strong></h5>
                		</div>
                		<div class="col-md-8 col-sm-8 mainUser">
                			<h5><strong>JOB</strong></h5>
                		</div>
                	</div><br><hr>
                	{{-- @foreach($proposals as $proposal)
	                	<div class="row padding-left">
	                		<div class="col-md-4 col-sm-4 mainUser">
	                			<h5>{{ date('M j, Y', strtotime($proposal->created_at)) }}</h5>
	                		</div>
	                		<div class="col-md-8 col-sm-8 mainUser">
	                			<a href="{{route('freelancerProposal.show', $proposal->id)}}"><h5><strong>{{$proposal->title}}</strong></h5></a>
	                		</div>
	                	</div><br><hr>
	                @endforeach --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
