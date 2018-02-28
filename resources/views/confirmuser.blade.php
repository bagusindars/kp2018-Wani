@extends('layouts.app')

@section('title')
	Manage User | Admin
@endsection

@section('content')

	<div class="container">

		@if(session('pesan'))
			<div class="alert alert-success">
				<p>{{ session('pesan')}}</p>
			</div>
		@endif
		<div class="cari-user">
			<form action="/confirmationuser" method="get">
	            <div class="form-group">
	                <button type="submit">
	                   <i class="fa fa-search" aria-hidden="true"></i>
	                </button>  
	                <input type="text" placeholder="Cari username " name="search" value="{{old('search')}}">
	                
	            </div>
       		</form>
		</div>
		
		<div class="row">
			<table class="table table-manageuser">
			  <thead>
			    <tr>
			      <th scope="col">Id</th>
			      <th scope="col">Nama</th>
			      <th scope="col">Username</th>
			      <th scope="col">Email</th>
			      <th scope="col">Dibuat pada</th>
			      <th scope="col" colspan="2">Opsi</th>
			    </tr>
			  </thead>
			  @foreach($user as $users)
				<tbody>
					<tr>
						<td>{{$users->id}}</td>
						<td>{{$users->name}}</td>
						<td>{{$users->username}}</td>
						<td>{{$users->email}}</td>
						<td>{{$users->created_at}}</td>
						<td><form action="/confirmationuser/{{$users->id}}" style="float: left;" method="post">
								
								<input type="submit" name = "confirm" value="Confirm">
								 {{ csrf_field() }}
								<input type="hidden" value="PUT" name="_method">
							</form>
							<form action="/confirmationuser/{{$users->id}}" method="post">
								<input type="submit" value="Hapus">
								{{csrf_field()}}
								<input type="hidden" value="DELETE" name="_method">
							</form>
						</td>		
					</tr>
				</tbody>
			@endforeach
		</div>	
	</div>
@endsection