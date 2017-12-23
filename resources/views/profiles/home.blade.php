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

            <form method="POST" action="{{ route("jobSearch") }}">
            {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" name="search" class="form-control" aria-label="..." placeholder="Search for Jobs">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div><br><br>
            </form>
            
            <div class="panel panel-default">
                <div class="panel-heading">FREELANCER Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in as FREELANCER!
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
