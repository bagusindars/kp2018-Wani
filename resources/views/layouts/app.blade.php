<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css?family=Oswald|Yanone+Kaffeesatz|Yanone+Kaffeesatz|Francois+One|Satisfy|Teko|Montez|Boogaloo|Barlow+Semi+Condensed|Jura|Open+Sans+Condensed:300');
        
        .username:before{
            content: '@';
        }
       
        ul.tagge li.activess a{
            background-color: transparent;
            color: red;
        }
       
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/medium-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" id="medium-editor-theme">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @yield('web-title')
        <nav class="navbar navbar-default navbar-static-top navbar-app ">
            <div class="container container-app">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" style="background-color: transparent;">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/posts') }}" style="font-size: 50px;margin-top: -6px;color: white;">
                        Wani<span style="color: #EB5458">.</span>
                    </a>
                </div>

                <!-- class="collapse navbar-collapse" id="app-navbar-collapse" -->
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav ">
                       <!--  &nbsp;   -->
                       <li><a href="/posts" class="tombolhome" style="margin-top: -20px;padding: 17px;color: white;{{ request()->path() == 'posts' ? 'background-color: white;color:red;' : ''  }};font-size: 18px">Home</a></li>
                       <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="margin-top: -17px;color: white;font-size: 18px"> Kategori <span class="caret" style="color: white"></span></a>

                           <ul class="dropdown-menu app-dropdown-menu tagge" role="menu" style="width: 500px">

                                @foreach($tagfix as $tag)
                                      
                                                 <li class="{{ request()->segment(3) == $tag ? 'activess' : '' }} col-md-3 col-sm-3"><a href="{{request()->root()}}/posts/filter/{{$tag}}">{{$tag}}</a></li>

                                       
                                @endforeach
                           </ul>
                       </li>
                       <!-- <li><a href="/posts" class="tag-name" class="tag-name" style="color: white">Home</a></li>
                        <li><a href="/posts/filter/teknologi" class="tag-name" style="color: white">Teknologi</a></li>
                       <li><a href="/posts/filter/auto" class="tag-name" style="color: white">Auto</a></li>
                       <li><a href="/posts/filter/travel" class="tag-name" style="color: white">Travel</a></li>
                       <li><a href="/posts/filter/life" class="tag-name" style="color: white">Life</a></li>
                       <li><a href="/posts/filter/olahraga" class="tag-name" style="color: white">Olahraga</a></li> -->
                    </ul>
                    <!-- <div class="container-search">
                         <div class="form-search"> 
                            <form action="/posts" method="get">
                                <div class="form-group">
                                    <button type="submit">
                                       <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>  
                                    <input type="text" placeholder="Search" name="search" value="{{old('search')}}">
                                    
                                </div>
                            </form>
                        </div>
                    </div> -->
                    <!-- Right Side Of Navbar --> 

                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li><a href="/search"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                        @guest
                            <li class="li-auth-zero"><a href="{{ route('login') }}"  class="auth-zero login" style="padding: 5px 20px; color: black">Login</a></li>
                            <li class="li-auth-zero"><a href="{{ route('register') }}"  class="auth-zero reg" style="padding: 5px 20px; color: white">Register</a></li>
                        @else
                            <li class="notif-app"><a href="/notifications"><i class="fa fa-bell-o" aria-hidden="true"></i><span class="notif-jum 
                                @if(Auth::user()->notifications->where('seen', 0)->count() >= 1 )
                                     ada
                                @else
                                    
                                @endif">
                            @php  
                                if(Auth::user()->notifications->where('seen', 0)->count() >= 1 ){
                                    echo Auth::user()->notifications->where('seen', 0)->count();
                                    }
                                else

                            @endphp
                            </span></a>

                            </li>
                            <li class="dropdown dropdown-nav-profile">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position: relative;padding-left: 50px">
                                    
                                    <img src="/upload/avatars/{{Auth::user()->avatar}}" alt="" style="width: 32px;position: absolute;border-radius: 50%;top: 10px;left: 10px">    
                                   
                                    <span class="nama" style="color: white">{{ strtok(Auth::user()->name," ") }} </span><span class="caret" style="color: white"></span>
                                </a>

                                <ul class="dropdown-menu app-dropdown-menu" role="menu">
                                    <li><a href="/profile">Profile</a></li>
                                    @if(Auth::user()->role == '0')

                                    <li><a href="/posts/create/">Buat Post</a></li>
                                    @endif
                                    @if(Auth::user()->role == '1')
                                    <li><a href="/admindashboard">Admin Dashboard</a></li>
                                    <li><a href="/posts/create">Buat Post</a></li>
                                    <li><a href="/manageuser">Manage User</a></li>
                                    <li><a href="/managepost">Manage Post</a></li>

                                    <li><a href="/confirmationpost">Confirm Post</a></li>
                                    <li><a href="/confirmationuser">Confirm User</a></li>
                                    @endif

                                    <li class="logout">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                   
                </div>
            
            </div>
            

           <!--  <div class="container container-tag" data-spy="affix" data-offset-top="305">
                 <ul class="nav navbar-nav collapse navbar-collapse "  id="app-navbar-collapse">
                   <li><a href="/posts/filter/teknologi" class="tag-name" style="color: #2C2C2C">Teknologi</a></li>
                   <li><a href="/posts/filter/auto" class="tag-name" style="color: #2C2C2C">Auto</a></li>
                   <li><a href="/posts/filter/travel" class="tag-name" style="color: #2C2C2C">Travel</a></li>
                   <li><a href="/posts/filter/life" class="tag-name" style="color: #2C2C2C">Life</a></li>
                   <li><a href="/posts/filter/olahraga" class="tag-name" style="color: #2C2C2C">Olahraga</a></li>
                </ul>   
            </div> -->
               
            </div>
        </nav>
        @yield('header')
        

        @yield('content')

      
    </div>

    <!-- Scripts -->
      <script src="{{ asset('js/jquery-3.1.1.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js.map"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
  
    <script src="{{asset('js/medium-editor.js')}}"></script>
    <script src="{{asset('js/sticky.js')}}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <div class="footer2"></div>
</body>
</html>
