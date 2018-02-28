@extends('layouts.app')

@section('title')
	Wani | Post
@endsection




@section('content')

<body>


<div class="container container-thumbnails-index">

	<div class="search-center">
			<form action="/search" method="get">
	            <div class="form-group">
	                <input type="text" class="form-control" placeholder="Keyword"  name="search" value="{{ Request::input('search') }}">
					<button type="submit" class="form-control">
	                   <i class="fa fa-search" aria-hidden="true"></i>
	                </button>  
	            </div>
       		</form>
		</div>
	
	<div class="letestadminpost post-type">

		<ul class="nav nav-tabs ul-search-tab">
			<li class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdowna">Opsi <i class="fa fa-angle-down" aria-hidden="true"></i></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#post" data-toggle="tab">Kiriman</a></li>
					<li><a href="#akun" data-toggle="tab">Akun</a></li>
				</ul>
			</li>
		</ul>
		<div class="clear"></div>
		@php
			$totalpost = count($posts)
		@endphp
	
<div class="tab-content">
		
	<div class="tab-pane fade in active" id="post">	
		@if($totalpost >= 1)

			@foreach($posts as $post)
				
				<a href="/posts/{{ $post->slug }}">
						@php
							$file = $post->featured_img;
							$img_array = explode(' ',$file);
						@endphp
					<div class="bungkus" id="bungkus">
						<div class="thumbnail thumbnail-index">
							
							
								<div class="gambar">
									<img src="{{ asset('storage/gambar_post/'.$img_array[0])}}" alt="" class="img-index" style="width: 100%;height: 35%;">
									@if($post->tag != null)
											<span style="font-weight: bold;color: white;" class="tag tag-border">{{$post->tag}} </span>
									@else
										@foreach ($post->tags as $tag)
											<span style="font-weight: bold;color: white;" class="tag tag-border">{{$tag->name}} </span>
										
										@endforeach
									@endif
								</div>
								

								<div class="keterangan-index">
									<h4 class="title-index" title="{{$post->title}}">{{ str_limit(strip_tags($post->title),20) }}</h4><span>
										@if(count($img_array) > 1)
										<p><i class="fa fa-clone" aria-hidden="true" title="Gambar post > 1"></i></p>
										@endif
									</span>
									<!-- <p style="color: #525252;margin-bottom: 20px">{{ str_limit(strip_tags($post->content), 40) }}</p> -->
								
									<div class="avatar">
										<img src="/upload/avatars/{{$post->user->avatar}}" alt="" class="foto-index">
										<span class="name">{{$post->user->name}}</span>
									</div>
									<span class="date">
										<i class="fa fa-calendar-o" aria-hidden="true"></i>
										{{$post->created_at->diffForHumans()}}
									</span>
									
								</div>
							
						</div><!-- THUMBNAILS -->
					</div>
				</a>
				
			@endforeach
		
		@else
			<h3 style="text-align: center;background-color: white;width: 100%;padding: 50px;">Kiriman kosong</h3>
		@endif
		
		<div class="col-md-12" style=" {{ count($posts) == 0 ? 'display:none' : '' }} ">
			{{$posts->appends($_GET)->links()}}
		</div>
			
	</div>

	<div class="tab-pane fade" id="akun">
			@php 
				$iadmin = 0;
			@endphp
			@foreach($users as $user)
			<div class="valid-search-akun">
			
					<img src="/upload/avatars/{{$user->avatar}}" alt="" class="img-search">
					<div class="bio">
						<h4 class="nama">{{$user->name}}</h4>
						<p class="job">{{$user->job}}</p>
						<a href="/profile/{{$user->id}}" >Kunjungi</a>
					</div>
					<div class="post">
						@foreach($user->posts->reverse() as $postt)
							@php
								$file = $postt->featured_img;
								$hasil = explode(" ",$file);
							@endphp
							@if($postt->approve == 1)
							<a href="/posts/{{$postt->slug}}">
								<div class="img-post-box" style="margin-top: 20px;margin-left: 20px;margin-right: 0px;float: left;width: 20%; height: 150px;">
									<img src="{{ asset('storage/gambar_post/'.$hasil[0])}}" alt="" class="post-img-search" style="width: 100%;height: 100%;object-fit: cover;">
								</div>
							</a>
							@endif	
							@php
								if(++$iadmin == 3 ) break;
							@endphp
						@endforeach

					</div>
			</div>
			<div class="clear"></div>
			@endforeach
			
			@if(count($users) == 0)
				<h3 style="text-align: center;background-color: white;width: 100%;padding: 50px;">Akun tidak terdaftar</h3>
			@endif

			<div class="col-md-12" style=" {{ count($users) == 0 ? 'display:none' : '' }} ">
				{{$users->appends($_GET)->links()}}
			</div>
	</div>

</div><!-- TAB CONTENT -->


</div><!-- CONTAINER -->

@endsection

</body>