<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
       <link href="https://fonts.googleapis.com/css?family=Fjalla+One|Yanone+Kaffeesatz" rel="stylesheet">
        <!-- Styles -->
        <style>
        @import url('https://fonts.googleapis.com/css?family=Oswald|Yanone+Kaffeesatz|Yanone+Kaffeesatz|Francois+One|Satisfy|Teko|Montez|Boogaloo|Barlow+Semi+Condensed|Jura|Open+Sans+Condensed:300');
        @-webkit-keyframes Gradient {
                0% {
                    background-position: 0% 50%
                }
                50% {
                    background-position: 100% 50%
                }
                100% {
                    background-position: 0% 50%
                }
            }

            @-moz-keyframes Gradient {
                0% {
                    background-position: 0% 50%
                }
                50% {
                    background-position: 100% 50%
                }
                100% {
                    background-position: 0% 50%
                }
            }

            @keyframes Gradient {
                0% {
                    background-position: 0% 50%
                }
                50% {
                    background-position: 100% 50%
                }
                100% {
                    background-position: 0% 50%
                }
            }
            html, body {
               /*background:linear-gradient(to right,#667eea 20%,#764ba2);*/
               background-image: url('img/register.jpg');
                color: #636b6f;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                    -webkit-animation: Gradient 45s ease infinite;
                -moz-animation: Gradient 45s ease infinite;
                animation: Gradient 45s ease infinite;
                background-size: 150% 150%;
                background-position: center;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
    
            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            

            .content {
                text-align: center;
             
                width: 100%;
                height: 100%;
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
            }
            .content .label{
                position: absolute;
                top: 64%;
                left: 50%;
                transform: translate(-50%,-50%);
            }
            .content h1{
                font-size: 90px;
                color: white;
                margin-bottom: -17px;
                font-family: 'Fjalla One', sans-serif;
            }
            .content p{
                color: white;
                font-size: 30px;
                font-family: 'Raleway', sans-serif;
                margin-bottom: 50px;
            }
            .content .btn{
                font-family: 'Yanone Kaffeesatz', sans-serif;
                padding: 7px 30px;
                color: white;
                text-decoration: none;
                border:1px solid white;
                position: relative;
                font-size: 21px;
                font-weight: normal;
            }
            .content .btn:after{
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 0;
                height: 100%;
                z-index: -1;
                background-color: #545051;
                transition: all 0.5s ease-in;
               
            }
            .content .btn:hover:after{
                width: 100%;
            }
            
            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            
            .thumbnail .gambar-t{
                width: 18%;
                float: left;
                
                margin-right: 10px;
            }
            .thumbnail .gambar-t img{
                object-fit: cover;
                height: 100vh;
            }

            .type-poster{
                display: block;
                color: white;
                font-weight: bold;
                text-align: left;
                 font-family: 'Yanone Kaffeesatz', sans-serif;
                 font-size: 30px;
            }
            .clear{
                clear: both;
            }
         
        </style>
    </head>
    <body>
       <!--  <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
            
        </div> -->

        <div class="content">
            <div class="label">
                <div class="navbar-brand" style="font-size: 90px;margin-top: -6px;color: white;font-family: 'Boogaloo', cursive">
                    Wani<span style="color: #EB5458">.</span>
                </div>
                 <p>Wacana Masa Kini. Baca Berita Terbaru, Dimana Saja dan Kapan Saja</p>
                 <br>
                 
                 <div class="div-full" style="width: 950px">
                    <h3 class="type-poster">Dari admin</h3>
                    @php
                        $count = 0;
                    @endphp
                    @foreach($posts as $post)
                        @if($post->user->role == 1)

                            @php
                                $file = $post->featured_img;
                                $img_array = explode(' ',$file);
                                
                            @endphp
                            <div class="thumbnail">
                                <div class="gambar-t">
                                   <img src="{{ asset('storage/gambar_post/'.$img_array[0])}}" alt="" class="img-index" style="width: 100%;height: 35%;">
                                </div>
                            </div>
                           @php
                                if(++$count >= 5 ) break;
                           @endphp

                        @endif
                    @endforeach
                </div>
                    
                <div class="clear"></div>
                
                 <div class="div-full" style="width: 950px">
                    <h3 class="type-poster">Dari publik</h3>
                    @php
                        $count = 0;
                    @endphp
                    @foreach($posts as $post)
                        @if($post->user->role == 0)

                            @php
                                $file = $post->featured_img;
                                $img_array = explode(' ',$file);
                                
                            @endphp
                            <div class="thumbnail">
                                <div class="gambar-t">
                                   <img src="{{ asset('storage/gambar_post/'.$img_array[0])}}" alt="" class="img-index" style="width: 100%;height: 35%;">
                                </div>
                            </div>
                           @php
                                if(++$count >= 5 ) break;
                           @endphp

                        @endif
                    @endforeach
                </div>
        </div>
    </body>
</html>
