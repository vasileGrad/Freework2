@extends('main')

@section('title', '| Show Contracts in progress for Client')

@section('content')
<div class="container">
	<h2 class="padding-left">Contracts in progress</h2><br>
	<div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row padding-left">
        				<div class="col-md-6">
				            @if( $contracts->total() == 1)
								<h3><span class="glyphicon glyphicon-check badge"></span> {{ $contracts->total() }} contract</h3>
							@elseif( $contracts->total() > 1)
								<h3><span class="glyphicon glyphicon-check badge"></span> {{ $contracts->total() }} contracts</h3>
							@elseif( $contracts->total() == 0)
								<h2>No Contracts</h2>
							@endif
				        </div>
				    </div>
                </div>
                <div class="panel-body">
                	@foreach($contracts as $contract)
	                	<div class="row padding-left">
	                		<div class="col-md-1 col-sm-2 mainUser">
	                			<img src="{{ asset('images/profile/' . $contract->image) }}" alt="" style="border-radius: 50%" height="90" width="90" />
	                		</div>  
	                		<div class="col-md-7 col-sm-6 mainUser">
	                			<div class="row padding-left">
		                			<h4><b><a href="{{ route('jobs.show', $contract->jobId)}}">{{ $contract->title}}</h4></a>
		                			<h4><b><a href="{{ route('freelancerSearch.show', $contract->userId)}}">{{ucwords($contract->firstName)}} {{ucwords($contract->lastName)}}</a></b></h4>
		                			<h5>{{ date('M j, Y', strtotime($contract->startTime)) }} - <b>In progress</b> </h5>
		                		</div>
	                		</div>
	                		<div class="col-md-4 col-sm-4 mainUser">
	                			<h4><b>${{ $contract->paymentAmount}}</b> Budget</h4>
	                			<h4>Started: &nbsp;&nbsp;{{ date('M j, Y', strtotime($contract->startTime)) }}</h4><br>
	                		</div>
	                	</div><br><hr>
	                @endforeach
		            <div class="text-center">
						{!! $contracts->links(); !!}
					</div>
                </div>
            </div><br><br>
        </div>
    </div>
</div>
@endsection
