
@section('title')
    Wani | Register
@endsection


<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
<style>
     @import url('https://fonts.googleapis.com/css?family=Oswald|Yanone+Kaffeesatz|Yanone+Kaffeesatz|Francois+One|Satisfy|Teko|Montez|Boogaloo|Barlow+Semi+Condensed|Jura|Open+Sans+Condensed:300');
</style>
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<body class="register-page">
    
<div class="container">
    <div class="link-login">
        <p>Sudah Daftar?</p>
        <a href="/login">Masuk</a>
    </div>
    
</div>

<div class="container container-auth">
    <div class="row">
         <div class="col-md-6 kiri">
            <img src="img/register.jpg" alt="">
        </div>
        <div class="col-md-5 col-sm-4 col-xs-12  kanan">
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
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="name" placeholder="Name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="username" placeholder="Username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            
                            <div class="col-md-12">
                                <input id="email" placeholder="Email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="password" placeholder="Password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-12">
                                <input id="password-confirm" placeholder="Re-type Password" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block btn-primary btn-geser" style="background-color: grey">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>


</body>