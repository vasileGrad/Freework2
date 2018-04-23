@extends('main')

@section('title', '| Homepage')

@section('content')
    <div class="col-md-10 col-sm-10 marginPage">
        <div class="col-md-6 col-sm-6 home-page-buttons">
            <h1><b>Get more done with freelancers</b></h1>
            <p><b>Quickly find top freelancers with a variety of skills<b></p><br><br>
            <a href="{{ route('client.login') }}"><button type="button" class="btn btn-default btn-lg">Hire</button></a>
            <a href="{{ route('freelancer.login') }}"><button type="button" class="btn btn-default btn-lg">Work</button></a>
            <a href="{{ route('admin.login') }}"><button type="button" class="btn btn-default btn-lg">Administrate</button></a>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 marginPage"> 
        <div class="col-md-4 col-sm-4">  
            <h2>Clients</h2>
            <h1><strong>{{ $clients }}</strong></h1>
        </div>
        <div class="col-md-4 col-sm-4">  
            <h2>Jobs</h2>
            <h1><strong>{{ $jobs }}</strong></h1>
        </div>
        <div class="col-md-4 col-sm-4">  
            <h2>Freelancers</h2>
            <h1><strong>{{ $freelancers }}</strong></h1>
        </div>
    </div>
    <div class="row">   
        <div class="col-md-8 col-sm-8 marginPage">   
            <h1><strong>Join Our Growing Freelance Community</strong></h1><br>
        </div>
    </div> 
@endsection

    