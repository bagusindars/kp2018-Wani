@extends('layouts.app')


@section('content')


@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="container">

	<form action="/posts" method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-5">
				<div class="panel panel-create create-img">
					<div class="panel-body ">
						<div class="form-group" id="input_file">
				            <div id="filediv"><input name="featured_img[]" type="file" id="file"/></div><br><br>

				    		<input type="button" style="margin-top: 20px" id="add_more" class="btn btn-block btn-primary" value="Tambah Gambar"/><br>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-7">
				<div class="panel panel-create create-text">
					<div class="panel-heading">Buat dan bagikan karyamu sekarang juga</div>
					<div class="panel-body ">
						<div class="form-group">
							<input type="text" class="form-control" required name="title" placeholder="Judul Karya" value="{{old('title')}}">
						</div>
						<div class="form-group ">
							<textarea name="content" required class='form-control editable medium-editor-textarea'  rows="10" style="height: 400px;overflow: scroll;" >{{old('content')}}</textarea>
						</div>
						<div class="form-group">
							<label for="">Tag</label>
							<select name="tags[]" id="tag_select" class="form-control" required="">
								@foreach($tags as $tag)
									
									<option value="{{$tag->id}}">{{$tag->name}}</option>
									
								@endforeach
							</select>
						</div>
						<div class="form-group tag_bebas" style="display: none" >
							<input type="text" name="tag_bebas" placeholder="Buat tag mu sendiri" disabled="" required="" class="form-control input-tagbebas">
							<input type="checkbox" name="centangtag" class="centangtag">

							<label for="">Ga jadi</label>
						</div>
						{{csrf_field()}}
						<input type="submit" class="btn btn-block btn-primary" value="Buat">

					</div>
				</div>
			</div>
		</div><!-- ROW -->
    </form>
   	
   	<div class="col-md-12">
   		@if(count($errors)>0)
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
	 	@endif
	
		@if(session('error_img'))
			
			<div class="alert alert-danger">{{session('error_img')}}</div>
		@endif
   	</div>
</div>


   
    

@endsection

