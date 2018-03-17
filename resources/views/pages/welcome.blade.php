@extends('main')

@section('title', '| Homepage')

@section('content')

        <div class="row">
            
        </div> <!-- end of header .row -->

        <div class="row">
                
            <div class="col-md-4 home-page-buttons">
                <h1><b>Get more done with freelancers</b></h1>
                <p><b>Quickly find top freelancers with a variety of skills<b></p><br><br>
                <a href="{{ route('client.login') }}"><button type="button" class="btn btn-default btn-lg">Hire</button></a>
                <a href="{{ route('freelancer.login') }}"><button type="button" class="btn btn-default btn-lg">Work</button></a>
                <a href="{{ route('admin.login') }}"><button type="button" class="btn btn-default btn-lg">Administrate</button></a>
            </div>
        </div>
@endsection

    