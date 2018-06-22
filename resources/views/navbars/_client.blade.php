<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

  <ul class="nav navbar-nav space_nav"> 
    <li class="dropdown space_nav_options">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>JOBS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="{{ route('jobs.index') }}">My Jobs</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('workProgress', Session::get('AuthUser')) }}">Work in progress</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('contracts', Session::get('AuthUser')) }}">Contracts</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('jobs.create') }}">Post a Job</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('clientProfile', Session::get('AuthUser')) }}">Profile</a></li> 
      </ul> 
    </li>
    <li class="dropdown space_nav_options">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>FREELANCERS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="{{ route('myFreelancers', Session::get('AuthUser')) }}">My Freelancers</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('freelancerSearch.index') }}">Find Freelancers</a></li>
        {{-- <li role="separator" class="divider"></li>
         <li><a href="#">Work Diary</a></li> --}}
      </ul>
    </li>
    {{-- <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>RAPORTS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="#">Overview</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Weekly Timesheet</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Contracts History</a></li>
      </ul>
    </li> --}}
    <li class="space_nav_options"><a href="{{ route('messages') }}"><strong>MESSAGES</strong></a></li>
    <li id="glyphicon-comment"><h4><a href="#" style="display: none"><i class="glyphicon glyphicon-comment color-link"></i></a></h4></li>
  </ul>
  {{-- <form class="navbar-form navbar-left">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form> --}}
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      {{-- <h4><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell"></span></a></h4> --}}
    </li>