<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <ul class="nav navbar-nav">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>JOBS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="{{ route('jobs.index') }}">My Jobs</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">All Job Posting</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Contracts</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('jobs.create') }}">Post a Job</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Profile</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>FREELANCERS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="#">My Freelancers</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('freelancerSearch.index') }}">Find Freelancers</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Work Diary</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>RAPORTS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="#">Overview</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Weekly Timesheet</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Contracts History</a></li>
      </ul>
    </li>
    <li><a href="#"><strong>MESSAGE</strong></a></li>
    <li id="glyphicon-comment" style="display: none"><h4><a href="#"><i class="glyphicon glyphicon-comment"></i></a></h4></li>
  </ul>
  <form class="navbar-form navbar-left">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell"></span></a>
    </li>