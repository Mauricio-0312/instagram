@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="userdata">
                @if($user->image)

                            <img src="{{ route('user.profileImage', ['filename'=>$user->image]) }}" class="avatar circleImage" alt="">
                @endif
                <div class="data">
                    <h1> {{$user->name}} <h1>
                    <h4>{{"@".$user->nick}}<h4>
                </div>
            </div>
            <div class="clearfix"></div>

        @foreach($user->images as $image)
            @include("includes.image", ["image"=> $image])
        @endforeach   
    
               
        </div>
    </div>
</div>
@endsection