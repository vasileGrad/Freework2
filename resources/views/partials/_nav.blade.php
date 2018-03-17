<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" 
        @if (Auth::guard('freelancer')->check()) 
          href="{{ route('home') }}" 
        @elseif (Auth::guard('client')->check())) 
          href="{{ route('client.dashboard') }}" 
        @elseif (Auth::guard('admin')->check())) 
          href="{{ route('admin.dashboard') }}" 
        @elseif (!Auth::check()) 
          href="{{ route('main') }}" 
        @endif>
      <img src="/images/Freework_logo.png" class="freework-img" /></a>
    </div>

    @if (Auth::check()) 

        @if (Auth::guard('freelancer')->check())

            @include('navbars._user')

        @elseif (Auth::guard('client')->check())

            @include('navbars._client')

        @elseif (Auth::guard('admin')->check())

            @include('navbars._admin')

        @endif

        <li class="dropdown">
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

    @endif

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

    

{{-- @section('scripts')
  {{ Html::script('js/hoverDropdownMenu.js') }}
@endsection --}}
