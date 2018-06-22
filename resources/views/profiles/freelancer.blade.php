@extends('main')

@section('title', '| Freelancer Profile Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <h1>Find Work</h1><br><br><br><br>
            <h4><b>Recent Searches</b></h4><br>
            @foreach($jobSearches as $jobSearch)
                <a href="{{ route('jobSearch') }}?search={{ $jobSearch->jobTitle }}"><h5 class="color-link"><b>{{ $jobSearch->jobTitle }}</b></h5></a>
            @endforeach
            <br>
            <h4><b>My Skills</b></h4><br>
            @if(isset($skills))
                @foreach($skills as $skill)
                    <h5><b>{{ $skill->skillName }}</b></h5>
                @endforeach
            @endif
        </div>

        <div class="col-md-8 mainUser">

            <form method="GET" action="{{ route("jobSearch") }}">
            {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" name="search" class="form-control" aria-label="..." placeholder="Search for Jobs">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div><br><br> 
            </form>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="padding-left">My projects</h3>
                </div><br>

                <div class="panel-body"> 
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <img src="/images/jobSearch.jpg" alt="jobSearch" class="imageSearchJob" width="140" height="140"/>
                    <br><br> 
                    <h3 class="mottoSearchJob">Find projects more quickly and easily</h3>
                    <h3 class="mottoSearchJob">See interesting projects here</h3> 
                    <br><br><br>
                </div>
                <div class="panel-footer">
                    <br><br>
                </div>
            </div>
        </div>

        <div class="col-md-2 mainUserLeft"><br><br><br>
            <a href="{{ route('freelancerProfile', Auth::user()->id) }}"><h4 class="color-link"><b>View Profile</b></h4><br><br></a>
            <h4><b>Proposals</b></h4>
            <a href="{{ route('freelancerProposal.index') }}"><h5 class="color-link"><b>{{ $proposals }} submitted proposals</b></h5></a><br>
            <h4><b>Contracts</b></h4>
            <a href="{{ route('contractsFinish', Auth::user()->id) }}">
            <h5 class="color-link">
                @if($contracts == 1)
                    <b>{{ $contracts }} contract</b>
                @elseif($contracts > 1)
                    <b>{{ $contracts }} contract</b>
                @else
                    <b>No contracts</b>
                @endif
            </h5></a>
        </div>
    </div>
</div>
@endsection
