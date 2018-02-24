<!-- Collect the nav links, forms, and other content for toggling -->
<style>
        /* Scrollbar styles for Messenger*/
        #myScroll::-webkit-scrollbar {
            width: 15px;
            height: 15px;
        }
        #myScroll::-webkit-scrollbar-track {
            border: 1px solid #a4a4a5;
            border-radius: 2px;
        }
        #myScroll::-webkit-scrollbar-thumb {
            background: gray;  
            border-radius: 10px;
        }
        #myScroll::-webkit-scrollbar-thumb:hover {
            background: #b1b2b5; 
    </style>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <ul class="nav navbar-nav">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>FIND WORK</strong></a>
      <ul class="dropdown-menu">
        <li><a href="{{ route('home') }}">Find Work</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('jobSaved') }}">Saved Jobs</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Proposals</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('freelancerProfile.show', Auth::user()->id) }}">Profile</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">My Stats</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Tests</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>MY JOBJ</strong></a>
      <ul class="dropdown-menu">
        <li><a href="#">My Jobs</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">All Contracts</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Work Diary</a></li>
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
    <li><a href="{{ url('messages') }}"><strong>MESSAGE</strong></a></li>
    <li id="glyphicon-comment" style="display: none"><h4><a href="{{ url('messages') }}"><i class="glyphicon glyphicon-comment"></i></a></h4></li>
  </ul>
  <form class="navbar-form navbar-left">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      <h4><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell"></span></a></h4>
    </li>