@extends('main')

@section('title', '| Homepage')

@section('content')
        <div class="row">
            <div class="col-md-4 home-page-buttons">
                <h1><b>Get more done with freelancers</b></h1>
                <p><b>Quickly find top freelancers with a variety of skills<b></p><br><br>
                <a href="{{ route('client.login') }}"><button type="button" class="btn btn-default btn-lg">Hire</button></a>
                <a href="{{ route('freelancer.login') }}"><button type="button" class="btn btn-default btn-lg">Work</button></a>
                <a href="{{ route('admin.login') }}"><button type="button" class="btn btn-default btn-lg">Administrate</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">   
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
        </div>
        <div class="row">   
            <div class="col-md-12">   
                <h1><strong>Join Our Growing Freelance Community</strong></h1>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-10 col-offset-md-1">  
                <ul>    
                    @foreach($freelancerProfiles as $freelancerProfile)
                        <div class="col-md-3 col-sm-3 col-xs-3">
                          <li class="thumbnail imageHomePage">
                            <img src="/images/profile/{{$freelancerProfile->image}}" alt="{{$freelancerProfile->image}}" class="imageHomePage"/>
                            <div class="titleProfile"><h4><strong>{{ $freelancerProfile->title}}</strong></h4></div> 
                            <div class="nameProfile"><h5>{{ $freelancerProfile->firstName}}</h5></div>
                          </li>
                        </div>
                    @endforeach
                </ul> 
            </div>
        </div> 
@endsection

    