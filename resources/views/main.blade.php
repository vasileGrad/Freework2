<!DOCTYPE html>
<html lang="en">
  <head>
    @include('partials._head')
  </head>

  <!-- Show the body-image if you are on the main page -->
  @if(Auth::check() || Route::current()->getName() != 'main')
    <body>
  @else
    <body class="body-image">
  @endif

    @include('partials._nav')
      
    <!-- Build the main body -->

    <div class="container col-md-12">

      @include('partials._messages')

      @yield('content')

      @include('partials._footer')

    </div> <!-- end of .container -->

        @include('partials._javascript')

        @yield('scripts')
        
        <!-- Scripts -->
        <script src="{{ asset('js/profile.js') }}"></script>
        {{ Html::script('js/hoverDropdownMenu.js') }}

    </body>
</html>

