@extends('layouts.app')

@section('content')


@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="container container-edprof">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                
				<div class="panel-body">
					<div class="form-group">
						
						<img src="/upload/avatars/{{$user->avatar}}" class="preview_img" alt="" style="width: 150px;border-radius: 50%;display: flex;margin: 0 auto">
					</div>
				@if(Auth::user() == $user)
					<form enctype="multipart/form-data" action="/profile/{{$user->id}}" method="POST">
						<div class="form-group row">
							<label for="name" class="col-md-2 control-label">Nama</label>
							<div class="col-md-10">
								<input type="text" name="name" class="form-control" value="{{old('name')? old('name') : $user->name}}">
							</div>
						</div>
						<div class="form-group row">
							<label for="username" class="col-md-2 control-label">Username</label>
							<div class="col-md-10">
								<input type="text" name="username" class="form-control" value="{{old('username')? old('username') : $user->username}}">
							</div>
						</div>
						<div class="form-group row">
							<label for="email" class="col-md-2 control-label">email</label>
							<div class="col-md-10">
								<input type="text" name="email" class="form-control" value="{{old('email')? old('email') : $user->email}}">
							</div>
						</div>
						<div class="form-group row">
							<label for="job" class="col-md-2 control-label">Pekerjaan</label>
							<div class="col-md-10">
								<input type="text" name="job" class="form-control" value="{{old('job')? old('job') : $user->job}}">
							</div>
						</div>
						<div class="form-group row">
							<label for="password" class="col-md-2 control-label">Password</label>
							<div class="col-md-10">
								<input type="password" name="password" class="form-control">
							</div>
						</div>
						
						<div class="form-group row">
							<label for="Avatar" class="col-md-2 control-label">Avatar</label>
							<div class="col-md-10">
								<input type="file" name="avatar" class="form-control" value="{{old('avatar')? old('avatar') : $user->avatar}}" onchange="readURL(this);">
							</div>
						</div>
			
						<div class="form-group">
							<input class="form-control" type="text" name="quote" placeholder="Bio" value="{{old('quote')? old('quote') : $user->quote}}">
						</div>
				

						<input type="submit" class="btn btn-block" value="Edit" style="font-weight: bold;background-color: #3897F0;color: white">
						{{ csrf_field() }}
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="_method" value="PUT">
						
					</form>
				@else
					<h5>Tautan tidak ada</h5>
				@endif
				</div><!-- PANEL-body -->
				
            </div><!-- PANEL -->
        </div><!-- COL -->

    </div><!-- ROW -->
   
</div>
@endsection
