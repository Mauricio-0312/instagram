@if(Auth::user()->image)
    <img src=" {{ route('user.profileImage', ['filename'=> Auth::user()->image]) }}" class="avatar" alt="">
@endif