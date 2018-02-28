@extends('layouts.app')

@section('content')


@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if($comment->isOwner())
<div class="container">
    <div class="row">
		@if($comment->post->approve == '0')
		<div class="col-md-12" style="margin-bottom: 10px">
			<h2 style="text-align: center;">Kiriman Belum di konfirmasi admin</h2>
		</div>
		@endif
		<div class="col-md-5 col-sm-12">
			<div class="jumbotron jumbotron-single-2" style="padding: 0"> 

					@php
						$file = $comment->post->featured_img;
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
							@foreach($comment->post->tags as $tag)
								{{$tag->name}}
							@endforeach
						</div>
					</div>

					<div class="like_wrapper">
						<i class="fa fa-heart {{$comment->post->is_liked() ? 'love-danger love-unlike' : 'love-primary love-like'}}" data-model-id="{{$comment->post->id}}" data-type="1">
						</i>
			
						<div class="total_like keterangan record" >
							<b><span class="like_number">{{$comment->post->likes->count()}}</span></b>
							LIKES
						</div>

					</div>
					
					
				</div>
			</div>
		</div><!-- COL -->
		<div class="col-md-7 col-sm-12">

			<div class="jumbotron jumbotron-single" style="padding: 30px"> 
					<h2 class="title">{{$comment->post->title}}</h2>
					<div class="profile-single">

						<a href="/profile/{{$comment->post->user->id}}"><img src="/upload/avatars/{{$comment->post->user->avatar}}" alt="" class="foto-single"></a>
						<div class="caption">
							{{$comment->post->user->name}}
							, {{$comment->post->created_at->format('d M Y')}}
						</div>

					</div>
					<div class="clear"></div>

					<div class="p-cont">{!! nl2br($comment->post->content) !!}</div>
					@if(Auth::guest())
					  
					@elseif($comment->post->isOwner() || Auth::user()->role == '1')
					<p class="opsi-single">
						@if($comment->post->isOwner())
						<a href="/posts/{{$comment->post->id}}/edit" title="Edit"class="single-edit" style="margin-right: 10px"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						@endif
						<form action="/posts/{{$comment->post->id}}" method="POST">
							<input type="submit"  title="Hapus" class="single-del" style="font-family: FontAwesome" value="&#xf014;">
							{{ csrf_field() }}
							<input type="hidden" name="_method" value="DELETE">
						</form>
					</p>
				
					@endif

				</div><!-- JUMBOTRON -->

				<span class="jumkom-single">Edit Komentar</span>
				<div class="clear"></div>
				

				@if(Auth::guest())
					<a href="/login" class="btn-guest-single btn btn-geser warnapinkgrad">Ingin berkomentar? Login dulu </a>

				@else
					<div class="komentar komentar-single">
								<div class="komentar-akun">
									<img src="/upload/avatars/{{$comment->user->avatar}}" alt="" class="img-circle" width="60px" style="float: left;">

									<div class="data">
										<p class="nama"><a href="/profile/{{$comment->user_id}}">{{$comment->user->name}}</a></p>
									<div class="komentar-control" style="display: block;">
										<form action="/posts-comment/{{$comment->id}}" class="form-koment form-inline" method="POST" style="width: 100%;margin-top: 5px">
										<div class="form-group">
											<input type="text"  name="subject" class="form-control komentar-form" class='form-control'  value="{{ (old('subject')) ? old('subject') : $comment->subject }}">
										</div>
										{{csrf_field()}}
										
										
										<input type="submit" class="btn btn-primary" value="Edit">
										
										<input type="hidden" name="_method" value="PUT">
									
									</form>
									<div class="clear"></div>
										<p class="tanggal" style="margin-top: 10px">{{$comment->created_at->format('d M Y')}}</p>
									</div>
									<div class="clear"></div>
								</div>
								
								<div class="clear"></div>
					
					</div><!-- KOMENTAR -->
					<div class="clear"></div>
					
				@endif


			</div><!-- COL -->

       
    </div><!-- ROW -->

</div><!-- CONTAINER -->
@else 
	<style>
	 @import url('https://fonts.googleapis.com/css?family=Oswald|Yanone+Kaffeesatz|Yanone+Kaffeesatz|Francois+One|Satisfy|Teko|Montez|Boogaloo|Barlow+Semi+Condensed|Jura|Open+Sans+Condensed:300');
        
	.kotak-404{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%,-50%);
		width: 100%;
	}
	.kotak-404 .title{
		font-family: 'Boogaloo', cursive;
		color: #2C2C2C;
		font-size: 125px;
	}
	.kotak-404 p{
		
		font-size: 60px;
		word-spacing: 5px;
		color:#474747;
		text-align: center;

	}


</style>

	<div class="kotak-404">
		<div class="title"  style="text-align: center;">Wani<span style="color: #EB5458">.</span></div>
		<p>Halaman Tidak Ada</p>
	</div>
@endif

@endsection
