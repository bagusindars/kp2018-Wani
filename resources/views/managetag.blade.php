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
			<form action="/managetag" method="get">
	            <div class="form-group">
	                <button type="submit">
	                   <i class="fa fa-search" aria-hidden="true"></i>
	                </button>  
	                <input type="text" placeholder="Cari tag " name="search" value="{{old('search')}}">
	                
	            </div>
       		</form>

		</div>
		
		<div class="row">
			<table class="table table-manageuser">
			  <thead>
			    <tr>
			      <th scope="col">Id</th>
			      <th scope="col">Nama tag</th>
			
			      <th scope="col" colspan="2">Opsi</th>
			    </tr>
			  </thead>
			  @foreach($tag as $tags)
				<tbody>
					<tr>
						<td>{{$tags->id}}</td>
						<td>{{$tags->name}}</td>
					
						<td>
							<a href="managetag/{{$tags->id}}/edit">Edit tag</a>
							<form action="/managetag/{{$tags->id}}" method="post">
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