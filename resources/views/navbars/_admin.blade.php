<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <ul class="nav navbar-nav">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>FREELANCERS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="#">Find Freelancer</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Block Freelancer</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Delete Freelancer</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Edit Profile</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>CLIENTS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="#">Find Client</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Block Client</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Delete Client</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Edit Profile</a></li>
      </ul>
    </li>
    <li class="dropdown">
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
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>JOBS</strong></a>
      <ul class="dropdown-menu">
        <li><a href="#">Block a Job</strong></a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Edit a Job</a></li>
      </ul>
    </li>

    <li class="{{ Request::is('categories/index') ? 'active' : '' }}"><a href="{{route('categories.index')}}"><strong>CATEGORIES</strong></a></li>
    <li class="{{ Request::is('skills/index') ? 'active' : '' }}"><a href="{{route('skills.index')}}"><strong>SKILLS</strong></a></li>
  </ul>
  <form class="navbar-form navbar-left">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <ul class="dropdown-menu">
          
        </ul>
      </li>