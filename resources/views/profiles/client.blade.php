@extends('main')

@section('title', '| Client Profile Page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="padding-left">My Freelancers</h3>
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <br><img src="/images/searchFreelancers.jpg" alt="jobSearch" class="imageSearchJob" width="140" height="140"/>
                    <br><br>
                    <h3 class="mottoSearchJob">Find freelancers more quickly and easily</h3>
                    <h3 class="mottoSearchJob">See interesting people here</h3> 
                    <br><br><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
