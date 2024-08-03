@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include("includes.message")
            <div class="card">

                <div class="card-header">
         

                @if($image->user->image)
                    <img src="{{ route('user.profileImage', ['filename'=>$image->user->image]) }}" class="avatar circleImage" alt="">
                @endif
                
                {{ $image->user->name." |  @". $image->user->nick}}
                </div>

                <div class="card-body">
                    <img src="{{ route('image', ['filename'=>$image->image_path]) }}" class="imagePost" alt="">
                    <div class="description">
                        <h4>{{$image->user->nick}}</h4>
                        <p>{{$image->description}}</p>
                    </div>
                
                    <div class="likeAndComments">
                    <?php $black_heart = true;?>

                        @foreach($image->likes as $like)
                            @if($like->user_id == Auth::user()->id && $like->image_id == $image->id)

                                
                                <img src="{{asset('img/red-heart.png')}}" data-id="{{$image->id}}" class="like" alt="">
                                <?php $black_heart = false;?>
                            @endif


                        @endforeach
                        @if($black_heart)

                            <img src="{{asset('img/black-heart.png')}}" data-id="{{$image->id}}" class="dislike" alt="">
                        @endif 
                        @if(Auth::user()->id == $image->user_id)  
                        <a href="{{ route('post.updatePage', ['id' => $image->id]) }}" class="btn btn-primary">Editar</a>                     

                        <a href="{{ route('post.delete', ['id'=>$image->id]) }}" class="btn btn-danger">Eliminar</a>                     
                        @endif
                        <h2>Comments ({{count($image->comments)}})</h2>
                    </div>
                    <hr>
                    <div class="formComments">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('postComment') }}">
                            @csrf


                                    <textarea id="content" type="text" class="form-control @error('content') is-invalid @enderror" name="content"   autofocus></textarea>

                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror


                                    <input type="hidden" name="image_id" value="{{$image->id}}">
                            

                            
                                    <input type="submit" class="btn btn-primary" value="Comentar">
                                    
                        </form>
                        
                    </div>

                    @foreach($image->comments as $comment)
                        <div class="description">
                            <hr>
                            
                            <p>{{"@".$comment->user->nick}} <br> {{$comment->content}}</p>
                            @if(Auth::user() && $comment->user->id == Auth::user()->id || $comment->image->user_id == Auth::user()->id)

                            <a href="{{ route('deleteComment', ['id'=>$comment->id]) }}" class="btn btn-danger" >Eliminar</a>

                            @endif
                        </div>
                    @endforeach
                </div>
                
            </div>

        </div>
    </div>
</div>
@endsection