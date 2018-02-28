@extends('layouts.app')

@section('title')
	Wani | Post
@endsection

@section('web-title')
	<a class="web-title"  href="{{ url('/posts') }}">Wani<span style="color: #EB5458">.</span></a>
@endsection


@section('content')

<body>


<div class="container container-thumbnails-index">

	
	
	<div class="letestadminpost post-type">
				
		@php
			$totalpost = count($posts)
		@endphp
	
		@if($totalpost >= 1)
			<div class="col-md-12">
				@if(Request::path() == 'posts/all/admin' )
					<h2 style="text-align: center;padding: 30px;color: black">Kiriman Admin</h2>
				@elseif(Request::path() == 'posts/all/nandadmin')
					<h2 style="text-align: center;padding: 30px;color: black">Kiriman Kamu</h2>
				@endif
			</div>
			@foreach($posts as $post)
				
				<a href="/posts/{{ $post->slug }}">
						@php
							$file = $post->featured_img;
							$img_array = explode(' ',$file);
						@endphp
					<div class="bungkus">
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
									<!-- <div class="score">
										<i class="fa fa-heart" aria-hidden="true"></i>{{$post->likes()->count()}}
										<i class="fa fa-comments" aria-hidden="true"></i>{{$post->comments()->count()}}
										
									</div> -->
									
								</div>
							
						</div><!-- THUMBNAILS -->
					</div>
				</a>
				
			@endforeach

		@else
			<h3 style="text-align: center;background-color: white;width: 100%;padding: 100px">Kiriman kosong</h3>
		@endif

		<div class="row" style=" {{ count($posts) == 0 ? 'display: none' : '' }} ">
			<div class="col-md-12">
				{{$posts->appends($_GET)->links()}}
			</div>	
		</div>

	</div><!-- CONTAINER -->

@endsection

</body>