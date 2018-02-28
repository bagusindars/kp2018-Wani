@extends('layouts.app')

@section('content')


@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="container">
	@if($posts->isOwner())
	<form action="/posts/{{$posts->id}}" method="POST" enctype="multipart/form-data">
    	<div class="row">
	      <div class="col-md-5 col-sm-12">
	      	<div class="panel">
	      		<div class="panel-body">
		      		<div class="form-group" style="overflow: hidden;">
						@php
							$img = $posts->featured_img;
							$imgfix = explode(" ",$img);
							$arraystart = -1;
						@endphp
						@foreach($imgfix as $imgg)
							<img src="{{asset('storage/gambar_post/'.$imgg)}}" alt="Gambar Post" style="width: 100%">
							
							 @php
								$arraystart++;
							 @endphp
							  <input type="hidden"  name="gmbr_lama[{{$arraystart}}]" value="gmbr_lama_{{$arraystart}}" />
							  {{csrf_field()}}
	       					
	       					
	       						<input type="submit" name="delete_{{$arraystart}}" value="Hapus" class="btn-block" style="background-color: #DD5044;padding: 10px 30px;border:none;color: white;margin-bottom: 30px">
	       				
							
						@endforeach
						<br> <br>
						<div id="filediv">
							<input name="featured_img[]" type="file" id="file" />
						</div> <br> <br>
			    		<input type="button" id="add_more" class="btn btn-primary btn-block" value="Add More Files"/><br><br>
					</div>
				</div>
	      	</div>
	      </div>
		<div class="col-md-7 col-sm-12">
	      	<div class="panel">
	      		<div class="panel-body">
		      		<div class="form-group">
						<input type="text" class="form-control" name="title" placeholder="Judul Karya" value="{{ (old('title')) ? old('title') : $posts->title }}">
					</div>
					<div class="form-group">
						<textarea name="content" class='form-control editable medium-editor-textarea'  rows="10" style="overflow-y: scroll;height: 300px">{{ (old('content')) ? old('content') : $posts->content }}</textarea>
					</div>
					<div class="form-group">
						<label for="">Tag</label>
						<select name="tags[]" id="tag_select" class="form-control" required="">
							@if($posts->tag != null)
								@foreach($tags as $tag)
									<option value="{{$tag->id}}">{{$tag->name}}</option>
								@endforeach
							@else
								@foreach($tags as $tag)
									<option value="{{$tag->id}}" {{ $tag->id == $tagmilik  ? 'selected' : '' }} >{{$tag->name}}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group tag_bebas" style="display: none" >
							<input type="text" name="tag_bebas" placeholder="Buat tag mu sendiri" disabled="" required="" class="form-control input-tagbebas">
							<input type="checkbox" name="centangtag" class="centangtag">

							<label for="">Ga jadi</label>
						</div>
					{{csrf_field()}}
					
					<input type="submit" class="btn btn-primary btn-block" value="Edit" name="submitedit">
					<input type="hidden" name="_method" value="PUT">
				</div>
	      	</div><!-- PANEL -->
	      </div><!-- COL -->
		
    	</div><!-- ROW -->
    	</form>
		@else 
			<span style="font-size: 30px;position: absolute;top: 45%;left: 50%;transform: translate(-50%,-50%);">Konten tidak ada</span>
		@endif
		@if(count($errors)>0)
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
	    @endif

</div>
<script src="{{ asset('js/jquery-3.1.1.js') }}"></script>
<script>
	$(document).ready(function(){
		@if(empty($tagmilik))
			$('.tag_bebas').show();
			$('.tag_bebas .input-tagbebas').prop('disabled',false);
			$('.tag_bebas .input-tagbebas').val('{{$posts->tag}}');
			$('#tag_select').attr('disabled',true);
			$('#tag_select').val(7);
			
	            $('.tag_bebas').show();
	            $(this).attr('disabled',true);
	            $('.input-tagbebas').prop('disabled',false);
	            $('.centangtag').on('change',function(){
	                if($('.centangtag:checked')){
	                    $('#tag_select').removeAttr('disabled');
	                    $('.tag_bebas').hide(); 
	                    $('.centangtag').prop('checked',false);
	                    $('.tag_bebas').prop('disabled',true);
	                    $('.input-tagbebas').prop('disabled',true);
	                    $('#tag_select').val('');
	                }else{
	                   
	                }
	            })
	      
		@endif
	})

</script>

@endsection
