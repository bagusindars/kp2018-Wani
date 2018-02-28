@extends('layouts.app')

@section('title')
	Manage Post | Admin
@endsection

@section('content')
	
	<div class="container">
		
		@if(session('pesan'))
			<div class="alert alert-success">
				<p>{{ session('pesan')}}</p>
			</div>
		@endif
		<div class="cari-user">
		<form action="/confirmationpost" method="get">
	            <div class="form-group">
	                <button type="submit">
	                   <i class="fa fa-search" aria-hidden="true"></i>
	                </button>  
	                <input type="text" placeholder="Cari username " name="search" value="{{old('search')}}">
	                
	            </div>
       		</form>
       		</div>
		<div class="row">
			<table class="table table-managepost">
			  <thead>
			    <tr>
			      <th scope="col">Id</th>
			      <th scope="col">Judul</th>
			      <th scope="col">Content</th>
			      <th scope="col">Pembuat</th>
			      <th scope="col">Dibuat pada</th>
			      <th scope="col" colspan="2">Opsi</th>
			    </tr>
			  </thead>
			  @foreach($post as $posts)
				<tbody>
					<tr>
						<td>{{$posts->id}}</td>
						<td>{{$posts->title}}</td>
						<td>{{ str_limit(strip_tags($posts->content), 40) }}</td>
						<td>{{$posts->user->name}}</td>
						<td>{{$posts->created_at}}</td>
						<td><a href="/posts/{{$posts->slug}}">Preview</a>
							<form action="/confirmationpost/{{$posts->id}}" method="post"  style="float: left; margin-right: 5px">
								
								<input type="submit" name = "confirm" value="Confirm">
								 {{ csrf_field() }}
								<input type="hidden" value="PUT" name="_method">
							</form>
							<form action="/confirmationpost/{{$posts->id}}" method="post">
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