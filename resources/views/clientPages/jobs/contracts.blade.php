@extends('main')

@section('title', '| Show Contracts Client')

@section('content')
<div class="container">
	<h2 class="padding-left">My Contracts</h2><br>
	<div class="row">
        <div class="col-md-12 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row padding-left">
        				<div class="col-md-6">
				            @if( $contracts->total() == 1)
								<h3><span class="glyphicon glyphicon-check badge"></span> {{ $contracts->total() }} contract finished</h3>
							@elseif( $contracts->total() > 1)
								<h3><span class="glyphicon glyphicon-check badge"></span> {{ $contracts->total() }} contracts finished</h3>
							@elseif( $contracts->total() == 0)
								<h2>No Contracts</h2>
							@endif
				        </div>
				    </div>
                </div>
                <div class="panel-body">
                	@foreach($contracts as $contract)
	                	<div class="row padding-left">
	                		<div class="col-md-8 col-sm-8 mainUser">
	                			<a href="#"{{-- data-toggle="modal" data-target="#jobTitle" --}}><h4 id="jobTitle">{{ $contract->title}}</h4></a>
	                			<h4><b>{{ $contract->firstName}} {{ $contract->lastName}}</b></h4>
	                			<h5>{{ date('M j, Y', strtotime($contract->startTime)) }} - {{ date('M j, Y', strtotime($contract->endTime)) }} </h5>
	                		</div>
	                		<div class="col-md-4 col-sm-4 mainUser">
	                			<h4><b>${{ $contract->paymentAmount}}</b> Budget</h4>
	                			<h4>Completed {{ date('M j, Y', strtotime($contract->endTime)) }}</h4><br>
	                			@php
									$rate = "$contract->rateClient"
								@endphp
	                			<h4>Feedback &nbsp;&nbsp;&nbsp;
	                			@for ($i = 1; $i <=$rate; $i++)
									<span class="glyphicon glyphicon-star star_review_color"></span>
	                			@endfor
	                			</h4>
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
