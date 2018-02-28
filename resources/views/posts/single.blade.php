@extends('layouts.app')

@section('title')
	Wani | {{$posts->title}}
@endsection
@section('content')


@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif


<div class="container container-single">

	@if(session('pesan'))
		<div class="alert alert-success">
			<p>{{ session('pesan')}}</p>
		</div>
	@endif
	<div class="row">
		@if($posts->approve == '0')
		<div class="col-md-12" style="margin-bottom: 10px">
			<h2 style="text-align: center;">Kiriman Belum di konfirmasi admin</h2>
		</div>
		@endif
		<div class="col-md-5 col-sm-12">
			<div class="jumbotron jumbotron-single-2" style="padding: 0"> 

					@php
						$file = $posts->featured_img;
						$lengkap = explode(" ",$file);
						$count = '0';
					@endphp
		
					<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">

						<div class="carousel-inner" role="listbox">
							
							@foreach($lengkap as $jadi)
								@php
									$count++;
								@endphp
						    <div class="item {{ $count == 1 ? 'active' : '' }}" >
						    	<a data-disable-external-check="false" href="{{asset('storage/gambar_post/'.$jadi)}}" data-toggle="lightbox" data-max-width="600" data-gallery="example-gallery" class="img-responsive">
						    		 <img class="d-block w-100" src="{{asset('storage/gambar_post/'.$jadi)}}" alt="First slide" >
						    	</a>
						    </div>
						    @endforeach
						</div>

					@if(count($lengkap) > 1)
					  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	                      <i class="fa fa-angle-left"></i>
	                      <span class="sr-only">Previous</span>
	                    </a>
	                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	                      <i class="fa fa-angle-right"></i>
	                      <span class="sr-only">Next</span>
	                    </a>
	                @endif
					</div>
				
				<div class="data-post">
					<div class="keterangan">
						<div class="tag">
							<span>Tagged :</span> 
							@if($posts->tag != null)
								{{$posts->tag}}
							@else
								@foreach($posts->tags as $tag)
									{{$tag->name}}
								@endforeach
							@endif
						</div>
					</div>

					<div class="like_wrapper">
						<i class="fa fa-heart {{$posts->is_liked() ? 'love-danger love-unlike' : 'love-primary love-like'}}" data-model-id="{{$posts->id}}" data-type="1">
						</i>
			
						<div class="total_like keterangan record" >
							<b><span class="like_number">{{$posts->likes->count()}}</span></b>
							LIKES
						</div>

					</div>
					
					
				</div>
			</div>

	
		</div><!-- COL -->

		<div class="col-md-7 col-sm-12" style="margin-bottom: 30px">

			<div class="jumbotron jumbotron-single" style="padding: 30px"> 
					<h2 class="title">{{$posts->title}}</h2>
					<div class="profile-single">

						<a href="/profile/{{$posts->user->id}}"><img src="/upload/avatars/{{$posts->user->avatar}}" alt="" class="foto-single"></a>
						<div class="caption">
							{{$posts->user->name}}
							, {{$posts->created_at->format('d M Y')}}
						</div>

					</div>
					<div class="clear"></div>

					<div class="p-cont">{!! nl2br($posts->content) !!}</div>
					@if(Auth::guest())
					  
					@elseif($posts->isOwner() || Auth::user()->role == '1')
					<p class="opsi-single">
						@if($posts->isOwner())
						<a href="/posts/{{$posts->id}}/edit" title="Edit"class="single-edit" style="margin-right: 10px"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						@endif
						<form action="/posts/{{$posts->id}}" method="POST">
							<input type="submit"  title="Hapus" class="single-del" style="font-family: FontAwesome" value="&#xf014;">
							{{ csrf_field() }}
							<input type="hidden" name="_method" value="DELETE">
						</form>
					</p>
				
					@endif

				</div><!-- JUMBOTRON -->

				<span class="jumkom-single">{{$posts->comments->count()}} Komentar</span>
				<div class="clear"></div>
				@foreach($posts->comments as $comment)

					<div class="komentar komentar-single">
							<div class="komentar-akun">
								<img src="/upload/avatars/{{$comment->user->avatar}}" alt="" class="img-circle" width="60px" style="float: left;">
								<div class="data">
									<p class="nama"><a href="/profile/{{$comment->user_id}}">{{$comment->user->name}}</a></p>
									<p class="subject" style="letter-spacing: -1px">{{$comment->subject }}</p>
									<p class="tanggal">{{$comment->created_at->format('d M Y')}}</p>
								</div>
								
							</div>
							@if($comment->isOwner())
							<div class="komentar-control">
							
								<a href="/posts-comment/{{$comment->id}}/edit" class="single-edit se2"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							
								<form action="/posts-comment/{{$comment->id}}" method="POST">
									<input type="submit" class="single-del" style="font-family: FontAwesome" value="&#xf014;">
									{{ csrf_field() }}
									<input type="hidden" name="_method" value="DELETE">
								</form>
							</div>
								
							@endif
							<div class="clear"></div>
							<hr>
				</div><!-- KOMENTAR -->
							<div class="clear"></div>
				@endforeach

				@if(Auth::guest())
					<a href="/login" class="btn-guest-single btn btn-geser tsgrad">Ingin berkomentar? Login dulu </a>
				
				@else
				
				<form method="POST" action="/posts-comment/{{$posts->id}}" class="form-koment form-inline" s>
					
						<input type="text" id="komentar-form" required placeholder="Masukan Komentar ..." class="form-control komentar-form" name="subject" value="{{old('subject')}}">
				
						{{csrf_field()}}
						<span class="input-group-btn" >
								<input type="submit" value="&#xf105;" class="btn btn-komentar" style="font-family: FontAwesome;"> 	
						</span>
					
					
				</form>
			
				
				@endif


			</div><!-- COL -->

	</div><!-- ROW -->
			
</div><!-- CONTAINER -->




@endsection


