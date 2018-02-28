
@section('title')
    Wani | Login
@endsection

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
<style>
     @import url('https://fonts.googleapis.com/css?family=Oswald|Yanone+Kaffeesatz|Yanone+Kaffeesatz|Francois+One|Satisfy|Teko|Montez|Boogaloo|Barlow+Semi+Condensed|Jura|Open+Sans+Condensed:300');
</style>
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<body class="login-page">

<div class="container">
    <div class="link-signup">
        <p>Belum Daftar?</p>
        <a href="/register" >Daftar</a>
    </div>
    
</div>

<div class="container container-auth">

    <div class="row">
        <div class="col-md-6 kiri">
            <img src="img/profileback.jpg" alt="">
        </div>
        <div class="col-md-5 col-sm-4 col-xs-12 kanan">
            <div class="panel-auth">
                    <div class="title-form">
                        <h1>Wani<span style="color: #EB5458">.</span></h1>
                        <p>Masuk untuk melihat dan berbagi cerita</p>
                    </div>
                    @if(Session::has('message'))
                        <div class="succes alert alert-succes">
                             {{ Session::get('message')}}
                        </div>
                       
                    @endif

                    @if(session('approve_user'))
                        <div class="alert alert-success">
                            <p>{{ session('approve_user')}}</p>
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                   

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block btn-geser " style="background-color: grey;border:none;font-weight: bold">
                                    Login
                                </button>
                                
                                <a class="btn btn-link" href="{{ route('password.request') }}" style="float: right; margin-top: 10px;color:#636B6F;font-family: 'Oswald', sans-serif; ">
                                    Lupa Password?
                                </a>
                            </div>
                        </div>
                    </form>
               </div>
        </div>
    </div>
</div>

</body>
