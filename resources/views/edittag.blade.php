@extends('layouts.app')

@section('title')
	Manage Tag | Admin
@endsection

@section('content')

	<div class="container">

		@if(session('pesan'))
			<div class="alert alert-success">
				<p>{{ session('pesan')}}</p>
			</div>
		@endif
		<div class="cari-user">
			<h4>Edit Tag {{$tags->name}}</h4>

		</div>
		
		<div class="row">
			<table class="table table-manageuser">
			  <thead>
			    <tr>
			      <th scope="col">Id</th>
			      <th scope="col">Nama tag lawas</th>
			      <th scope="col">Nama tag Baru</th>
				
			      <th scope="col" colspan="2">Opsi</th>
			    </tr>
			  </thead>
			 
				<tbody>
					<tr>
						<td>{{$tags->id}}</td>
						<td>{{$tags->name}}</td>
						<form action="" method="post">
							<td>
								<input type="text" class="form-control" name="gantitag" style="outline: none">
							</td>
							<td>
								{{ csrf_field() }}
								<input type="submit" value="edit">
							</td>
						</form>		
					</tr>
				</tbody>
			
		</div>
		
	</div>
@endsection