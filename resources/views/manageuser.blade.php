@extends('layouts.app')

@section('title')
	Manage User | Admin
@endsection

@section('content')

	<div class="container">
		<div class="cari-user">
			<form action="/manageuser" method="get">
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
			      <th scope="col">Total Kiriman</th>
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
						<td>{{$users->posts->count()}}</td>
						<td><a href="/profile/{{$users->id}}">Kunjungi</a>
							<form action="/manageuser/{{$users->id}}" method="post">
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