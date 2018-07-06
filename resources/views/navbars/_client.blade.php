
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
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      <h4><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell bell-top-margin"></span></a></h4>
      
      <ul class="dropdown-menu" role="menu">
        <li class="notification-style">
          <div class="row">
              <div class="col-md-2">
                <img src="/images/profile/vasile.PNG" class="img-rounded notification-image">
              </div>
              <div class="col-md-10">
                <b class="notification-name">First Name</b> 
                <span class="notification-info">Notificare 1</span><br>
                <small class="notification-color">
                  <span class="glyphicon glyphicon-calendar"></span>
                    Date</small>
              </div>
          </div>
          <hr>
        </li>
      </ul>
    </li>