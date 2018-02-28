@extends('layouts.app')

@section('title')
	Wani | Post
@endsection

@section('web-title')
	<a class="web-title"  href="{{ url('/posts') }}">Wani<span style="color: #EB5458">.</span></a>
@endsection

@section('header')
	<div id="header-carousel" class="carousel slide" data-ride="carousel">

		<div class="carousel-inner" role="listbox">
				@php
					$count = 0;
					$iadmin = 0;
				@endphp
			@foreach($postadmin as $pomin)
	
				@php
					$file = $pomin->featured_img;
					$lengkap = explode(" ",$file);
				@endphp
				@foreach($pomin->tags as $tag)
					
				    <div class="item {{ $count == 0 ? 'active' : ''  }}">

				      <img class="d-block w-100" src="{{asset('storage/gambar_post/'.$lengkap[0])}}" alt="First slide" style="width: 100%">
				      <div class="caption">
				      	
				      		<span class="header-admin-tag">{{$tag->name}}</span>
				      
				      	<h1 class="title">{{ str_limit(strip_tags($pomin->title), 25) }}</h1>
				      	<p class="content">{{ str_limit(strip_tags($pomin->content), 200) }}</p>
				      	<div class="profile">
				      		<img src="/upload/avatars/{{$pomin->user->avatar}}" alt="" class="foto-index">
							<span class="name">{{$pomin->user->name}}</span>
				      	</div>
				      	<a href="/posts/{{$pomin->slug}}" class="readmore">Lihat selengkapnya</a>
				      </div>
				    </div>

				@endforeach
		
				@php
					$count++;
				@endphp
		    @endforeach
		</div>

		@php
			$totalheader = count($postadmin);
		@endphp	
	@if($totalheader > 0)
	  <a class="left carousel-control" href="#header-carousel" role="button" data-slide="prev">
          <i class="fa fa-angle-left"></i>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#header-carousel" role="button" data-slide="next">
          <i class="fa fa-angle-right"></i>
          <span class="sr-only">Next</span>
        </a>
    @endif
</div>

@endsection


@section('content')


	@if (session('status'))
	    <div class="alert alert-success">
	        {{ session('status') }}
	    </div>
	@endif

<body>


<div class="container container-thumbnails-index">

	
	
	<div class="letestadminpost post-type">
		<h3 class="rowpost-index">Kiriman Admin</h3>

		@foreach($posts as $post)
			@if($post->user->role == '1' )
						
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
					@php
						if(++$iadmin == 11 ) break;
					@endphp		
					
			@endif
			
		@endforeach

		<div class="thumbnail thumbnail-index">
			<div class="spesifik">
				<span class="spesifik-caption">Lihat dan baca karya admin lainnya </span> <br> <br>
				<a href="posts/all/admin" class="spesifik-btn">Lihat selengkapnya</a>
			</div>	
			
		</div>	
		
	</div>

	<div class="clear"></div>
	<div class="trendingpost-index">
		@foreach($posts as $post)
			
		@endforeach
	</div>


	<div class="latestpost-index post-type">
		<h3 class="rowpost-index">Kiriman Terakhir</h3>
	@foreach($posts as $post)
		@if($post->user->role == '0')
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
			@php
				if(++$iadmin == 17 ) break;
			@endphp		
		
		@endif
	
		
	@endforeach
		<div class="thumbnail thumbnail-index">
			<div class="spesifik">
				<span class="spesifik-caption">Lihat dan baca karya lainnya  </span><br><br>
				<a href="posts/all/nandadmin" class="spesifik-btn">Lihat selengkapnya</a>
			</div>	
			
		</div>	
	</div>
	

</div>

@endsection

</body>