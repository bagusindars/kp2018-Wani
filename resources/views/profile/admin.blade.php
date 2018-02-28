@extends('layouts.app')

@section('content')
 @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="container container-admin">
  	<div class="jumbotron jumbotron-admin">

       	<h2>Admin : {{$user->name}} 
			@if(Auth::user() == $user )
	       	 <a href="/profile/{{$user->id}}/edit" title="Edit"><i class="fa fa-cog" aria-hidden="true" style="font-size: 18px;"></i></a>
	       	@endif
       	</h2>

 	</div>
	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a class="nav-link" href="/manageuser">Manage user <span class="data-admin">{{ $countmu }}</span></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="/managepost">Manage Post <span class="data-admin">{{ $countmp }}</span></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="/confirmationpost">Confirmation Post <span class="data-admin">{{ $countcp }}</span></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link disabled" href="/confirmationuser">Confirmation User <span class="data-admin">{{ $countcu }}</span></a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link disabled" href="/managetag">Tag<span class="data-admin">{{ count($tagfix) }}</span></a>
	  </li>
	</ul>
    
    <br>
	
	@if(Session::has('berhasil'))
		<div class="alert alert-success">{{ Session::get('berhasil') }}</div>
	@endif
   	<div class="container">
   		<h5>Buat Tag Baru</h5>
   		<form action="" method="post">
   			<input type="text" class="form-control" required="" name="namatag">
   			{{ csrf_field() }}
   			<input type="submit" value="buat" class="btn-block btn btn-geser tsgrad" style="margin-top: 5px;color: white">
   		</form>
   	</div>

</div><!-- CONTAINER -->

@endsection
