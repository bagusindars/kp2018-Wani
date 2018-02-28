@extends('layouts.app')
@section('content');
	@if (session('status'))
	    <div class="alert alert-success">
	        {{ session('status') }}
	    </div>
	@endif
<div class="container container-notif">
	<div class="row">
		<div class="col-lg-12">
			<h3>Notifikasi</h3>
			<ul class="list-group">
				@if($notifications->isEmpty())
				
				@else
					<form action="/notifications/{$notifications->id}" method="post">
						<input type="submit" name="submit" value="Kosongkan Notifikasi">
						{{csrf_field()}}
						<input type="hidden" value="DELETE" name="_method">
					</form>
				@endif

				@if($notifications->isEmpty())
					<li class="list-group-item">
						Tidak ada notifikasi
					</li>
				@else
					@foreach($notifications as $notif)
						<li class="list-group-item">
							<a href="/posts/{{$notif->post->slug}}">
								{{$notif->subject. ' di post ' . $notif->post->title}}
							</a>
						</li>
					@endforeach
				@endif
			</ul>
		</div>
		@php
			$notif_model::where('user_id',$user->id)->where('seen',0)->update(['seen' => 1]);
		@endphp
	</div>
</div>

@endsection

