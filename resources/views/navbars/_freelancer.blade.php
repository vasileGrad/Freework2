
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <ul class="nav navbar-nav space_nav">
    <li class="dropdown space_nav_options">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>FIND WORK</strong></a>
      <ul class="dropdown-menu">
        <li><a href="{{ route('freelancer.dashboard') }}">Find Work</a></li> 
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('jobSaved') }}">Saved Jobs</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('freelancerProposal.index') }}">Proposals</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('freelancerProfile', Auth::user()->id) }}">Profile</a></li>
        {{-- <li role="separator" class="divider"></li>
        <li><a href="#">My Stats</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Tests</a></li> --}}
      </ul>
    </li>
    <li class="dropdown space_nav_options">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>MY JOBS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="{{ route('contractsNow', Auth::user()->id) }}">Contracts in progress</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('contractsFinish', Auth::user()->id) }}">Finished Contracts</a></li>
        {{-- <li role="separator" class="divider"></li>
        <li><a href="{{ route('earnings', Auth::user()->id) }}">Business Reports</a></li> --}}
      </ul>
    </li>
    {{-- <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>RAPORTS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="#">Overview</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Earnings by Client</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Weekly Timesheet</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Connets History</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Transaction History</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Tests</a></li>
      </ul>
    </li> --}} 
    <li class="space_nav_options"><a href="{{ route('messages') }}"><strong>MESSAGES</strong></a></li>
    <li id="glyphicon-comment"><h4><a href="{{ url('messages') }}" style="display: none"><i class="glyphicon glyphicon-comment color-link"></i></a></h4></li>
  </ul>
  
  {{-- <form class="navbar-form navbar-left">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form> --}}

  {{-- <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      <h4><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell" style="margin-top: 6px"></span></a></h4>
      <h4>Notificare 1</h4>
      <h4>Notificare 2</h4>
      <h4>Notificare 3</h4>
    </li> --}}

  <ul class="nav navbar-nav navbar-right">
    {{-- <li class="dropdown">
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
    </li> --}}
