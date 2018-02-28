@extends('layouts.app')

@section('title')
	Manage Post | Admin
@endsection

@section('content')

	<div class="container">
		<div class="cari-user">
			<form action="/managepost" method="get">
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
						<td>
							{{$posts->user->name}}
							@if($posts->user->role == '1')
								<span class="showketadmin">Admin</span>
							@endif
						</td>
						<td>{{$posts->created_at}}</td>
						<td><a href="/posts/{{$posts->slug}}">Visit</a>
							<form action="/managepost/{{$posts->id}}" method="post"  style="float: left;">
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