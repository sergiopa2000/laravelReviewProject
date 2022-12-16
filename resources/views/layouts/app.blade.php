<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>laravel - dwes - {{ $table ?? 'users'}}</title>
        <link rel="stylesheet" href="{{ url('assets/css/reset.css') }}" type="text/css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ url('assets/home-plugins/themify-icons/themify-icons.css') }}">
        <!-- Main Stylesheet -->
        <link rel="preload" href="https://fonts.gstatic.com/s/opensans/v18/mem8YaGs126MiZpBA-UFWJ0bbck.woff2" style="font-display: optional;">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:600%7cOpen&#43;Sans&amp;display=swap" media="screen">
        
        <link rel="stylesheet" href="{{ url('assets/home-plugins/slick/slick.css') }}">
        <link rel="stylesheet" href="{{ url('assets/css/home.css') }}">
        <link rel="stylesheet" href="{{ url('assets/css/app.css')}}" type="text/css"/>
        @yield('styles')
    </head>
    <body>
        <header class="sticky-top bg-white border-bottom border-default">
           <div class="container">
        
              <nav class="navbar navbar-expand-lg navbar-white">
                 <a class="navbar-brand" href="{{ url('/') }}">
                    MyReviews
                 </a>
                 <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navigation">
                    <i class="ti-menu"></i>
                 </button>
        
                 <div class="collapse navbar-collapse text-center" id="navigation">
                    <ul class="navbar-nav ml-auto">
                       <li class="nav-item dropdown">
                          <a class="nav-link" href="{{ url('/') }}">
                             Home
                          </a>
                       </li>
                       @if(Auth::user())
                       <li class="nav-item">
                          <a class="nav-link" href="{{ url(Auth::user()->name) }}"><i class="ti-user ml-1"></i> Profile 
                          </a>
                       </li>
                       @endif
                       @if(Auth::user() && Auth::user()->isAdmin == 1)
                       <li class="nav-item">
                          <a class="nav-link" href="{{ url('admin/user') }}">Admin</a>
                       </li>
                       @endif
                       @if(Auth::user())
                            <form action="{{ url('logout') }}" method="post" class="logout-button">
                                @csrf
                                <li class="nav-item {{$activeUser ?? ''}}">
                                    <button class="btn btn-primary" type="submit">Logout</button>
                                </li>
                            </form>
                        @else
                        <li class="nav-item">
                            <a href="{{ url('login') }}" class="nav-link nav-login">Log in <i class="ti-shift-right"></i> </a>
                        </li>
                        @endif
                    </ul>
                    @yield('navItems')
                 </div>
              </nav>
           </div>
        </header>
        @yield('modalContent')
        <main role="main">
            <div class="container" id="start" style="height:100%;">
                @yield('content')
            </div>
        </main>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
       <!-- JS Plugins -->
       <script src="{{ url('assets/home-plugins/jQuery/jquery.min.js') }}"></script>
       <script src="{{ url('assets/home-plugins/bootstrap/bootstrap.min.js') }}" async></script>
       <script src="{{ url('assets/home-plugins/slick/slick.min.js') }}"></script>
    
       <!-- Main Script -->
       <script src="{{ url('assets/home-plugins/script.js') }}"></script>
        @yield('scripts')
    </body>
</html>