@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h2>Gente</h2>
        <form method="GET" id="formSearch" class="row" action="{{ route('people') }}">
            <div class="form-group col-6">
                <input type="text" id="search" class="form-control">

            </div>
            <div class="form-group col-3">

                <input  type="submit" value="Buscar" class="searchPeople btn btn-success col">
            </div>
        </form>
        @foreach($users as $user)
            <div class="userdata">
                @if($user->image)

                            <img src="{{ route('user.profileImage', ['filename'=>$user->image]) }}" class="avatar circleImage" alt="">
                @endif
                <div class="data">
                    
                    <h1> {{$user->name}} <h1>
                    <h4>{{"@".$user->nick}}<h4>
                </div>
                <a href="{{ route('user.profile', ['user_id'=>$user->id]) }}" class="btn btn-success">Ver perfil</a>
            </div>
            <div class="clearfix"></div>
        @endforeach

            <div>
                    {{$users->links() }}
            </div> 
    
               
        </div>
    </div>
</div>
@endsection