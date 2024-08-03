<div class="card">

        <div class="card-header">
           

                @if($image->user->image)
                    <img src="{{ route('user.profileImage', ['filename'=>$image->user->image]) }}" class="avatar circleImage" alt="">
                @endif
                
               <a href="{{route('user.profile', ['user_id'=> $image->user->id])}}"> {{$image->user->name." |  @". $image->user->nick}}</a>
        </div>

        <div class="card-body">
                    <img src="{{ route('image', ['filename'=>$image->image_path]) }}" class="imagePost" alt="">
                <div class="description">
                    <h5>{{"@".$image->user->nick}}</h5>
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
            <span class="likes">{{count($image->likes)}}</span>
            <a href="{{ route('image.detail', ['id'=> $image->id]) }}" class="btn btn-warning btn-comments">Comments ({{count($image->comments)}})</a>
        </div>
    </div>
                
</div>