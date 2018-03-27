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
        <li><a href="{{ route('freelancerProposal.index') }}">Proposals</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('freelancerProfile.show', Auth::user()->id) }}">Profile</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">My Stats</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Tests</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>MY JOBS</strong></a>
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
    <li><a href="{{ route('messages') }}"><strong>MESSAGE</strong></a></li>
    <li id="glyphicon-comment" style="display: none"><h4><a href="{{ url('messages') }}"><i class="glyphicon glyphicon-comment"></i></a></h4></li>
  </ul>
  <form class="navbar-form navbar-left">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  {{-- <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      <h4><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell" style="margin-top: 6px"></span></a></h4>
      <h4>Notificare 1</h4>
      <h4>Notificare 2</h4>
      <h4>Notificare 3</h4>
    </li> --}}

    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <h4><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell" style="margin-top: 6px;margin-right:40px;"></span></a></h4>
        <ul class="dropdown-menu" role="menu">
          <li style="background-color:#E4E9F2;width:400px">
            <div class="row">
                <div class="col-md-2">
                    <img src="/images/profile/vasile.PNG" style="width:50px; padding:5px; background:#fff; border:1px solid #eee" class="img-rounded">
                </div>
                <div class="col-md-10">
                    <b style="color:green; font-size:90%">First Name</b> <span style="color:#000; font-size:90%">Notificare 1</span><br>
                    <small style="color:#90949C">
                        <span class="glyphicon glyphicon-calendar"></span>
                        Date</small>
                </div>
            </div>
            <hr>
          </li>
          
        </ul>
      </li>


  {{-- <li class="dropdown">
          <a href="#" class="dropdown-toggle dropdown-logout" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->firstName}} {{Auth::user()->lastName}}<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
              <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </li>
 --}}