@extends('layouts.app')
@section('title')
  {{$user->username}} | Profile
@endsection

@section('content')
 @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<style>
  .konfirp , .bkonfirp{
    font-size: 17px;
    margin-left: 1px;
    margin-top: 10px;
  }
  .konfirp{
    color: green;
    
  }
  .bkonfirp{
    color: red;
  }
</style>
<div class="container container-profile">
  
  <div class="row row-1">
    <div class="col-md-4 col-sm-4 col-xs-12 profile-kiri col-profile">
        <div class="col-md-12 well well-kiri">
           <div class="avatar">
 
                <img src="/upload/avatars/{{$user->avatar}}" style="margin-top: 15px;width: 120px;height: 120px;  object-fit: cover;border-radius: 50%;" alt="">
           </div>
    
            <div class="data">
              <div class="bio" style="margin-top: 60px">
                <h3 class="nama">{{$user->name}}  
                  @if(Auth::user() == $user )
                  <a href="/profile/{{$user->id}}/edit"><i class="fa fa-cog" aria-hidden="true" style="font-size: 16px;"></i></a>
                  @endif
                </h3>
     
              </div>
              <p class="job">{{$user->job}}</p>
              <div class="bio-2">
                <h5>Bio : </h5>
                <p>{{$user->quote}}</p>
              </div>
              <div class="data-2">
                <div class="col-xs-4 bagi-2">{{ $user->posts->count()  }} <br>Kiriman</div>
               
                <div class="col-xs-4 bagi-2">
                    @php
                      $arraytotal = array();

                        foreach($user->posts as $postt){
                           
                           $arraytotal[] = $postt->likes->count();
                        }
                      $total = array_sum($arraytotal);

                    @endphp
                {{$total}} <br> Love
                </div>
                 <div class="col-xs-4 bagi-2">
                    @php
                        $atbk = array();
                        foreach($user->posts as $post){
                          if( $post->approve == '1' ){
                              $atbk[] = count($post);
                          }
                        }
                        echo count($atbk)
                    @endphp
                    <br>Centang
                </div>
              </div>
            </div>
      </div>
     
    </div><!-- COL -->
    <div class="col-md-8 col-sm-8 col-xs-12 profile-kanan col-profile">
       @foreach($user->posts->reverse() as $posts)
      <div class="col-md-12 well well-kanan">
          @php
            $jumlahpost = count($user->posts);
          @endphp
           @if($jumlahpost <= 0)
                <h4 style="text-align: center;">Belum terdapat kiriman</h4>
          @endif
        
    
             @if($jumlahpost > 0 )
              <a href="/posts/{{$posts->slug}}">
                <div class="box-post-profile">

                    <div class="caption" >
                         <h2 class="title" style="float: left;">{{$posts->title}}  
                            <span>
                              <i class="fa fa-check  {{ $posts->approve == '1' ?  'konfirp' : 'bkonfirp'  }} " title=" {{ $posts->approve == '1' ?  'Sudah dikonfirmasi' : 'Belum dikonfirmasi'  }} "></i>
                            </span>
                          </h2>
                          <div class="clear"></div> <br>
                         <p class="tgl">{{$posts->created_at->diffForHumans()}}</p>
                         <p>{{str_limit(strip_tags($posts->content), 160)}}</p>
                         <div class="data" style="float: left;">
                            @if($posts->tag != null)
                              <span class="tag">{{$posts->tag}}</span>
                            @else
                              @foreach($posts->tags as $tag)
                                <span class="tag">{{$tag->name}}</span>
                              @endforeach
                            @endif
                            
                         </div>
                          <div class="clear"></div>
                    </div>
                </div>
                @php
                  $img = explode(" ",$posts->featured_img);
                  $angka = 0;
                @endphp

                <div class="gambar">
                    @foreach($img as $image)
                      <img src="{{asset('storage/gambar_post/'.$image)}}" alt="">

                      @php
                        $angka++;
                          if($angka >= 4){
                      @endphp
                          <div class="box-img-sisa">
                            <span>
                            + {{ count($img) - 4 }}
                            </span>
                          </div>
                      @php
                             break;
                          }
                         

                      @endphp
                    @endforeach
                </div>
              </a>
              @endif
              <div class="clear"></div>
          
      </div>
      @endforeach
    </div><!-- COL -->
  </div>
</div><!-- CONTAINER -->
  
@endsection
