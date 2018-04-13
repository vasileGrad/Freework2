@extends('main')

@section('title', '| Freelancer Profile Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <h1>Find Work</h1><br><br>
            <a href="#"><h4>Recommended</h4></a><br><br>
            <h4><b>Recent Searches</b></h4><br><br>
            <h4><b>My Categories</b></h4><br><br>
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
                    <h3 class="padding-left">My jobs</h3>
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

        <div class="col-md-2 mainUserLeft">
            <h4><b>My Profile</b></h4><br><br>
            <h4><b>Visibility</b></h4><br><br>
            <h4><b>Availability</b></h4><br><br>
            <h4><b>Proposals</b></h4><br><br>
        </div>
    </div>
</div>
@endsection
