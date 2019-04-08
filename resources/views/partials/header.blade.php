<div class="nav-top text-right">
    <a href="#"><i class="fas fa-bell"></i></a>
    <a href="#">My Profile <i class="fas fa-user-circle"></i></a>
    <a href="{{route('logout')}}">Logout</a>
</div>
<div class="nav-bottom">
    <div class="left">
        <div class="logo d-inline-block"><img src="{{asset('images/logo-white.png')}}" alt="logo"></div>
        <div class="nav-tabs">
            <a class="nav-tab{{Route::currentRouteName() == 'schedule' ? ' active' : '' }}" href="{{route('schedule')}}"><div>Schedule</div></a>
            <a class="nav-tab{{Route::currentRouteName() == 'availability' ? ' active' : '' }}" href="{{route('availability')}}"><div>Availability</div></a>
            <a class="nav-tab{{Route::currentRouteName() == 'settings' ? ' active' : '' }}" href="{{route('settings')}}"><div>Settings</div></a>  
            @if(auth()->user()->role == 'admin')
            <a class="nav-tab{{Route::currentRouteName() == 'admin' ? ' active' : '' }}" href="{{route('admin')}}"><div>Admin</div></a>
            @endif
        </div>
    </div>
    @if(auth()->user()->role != 'admin')
        <div class="right">
            <a href="#">My Balance</a>
            <a class="big-text" href="#">$0.00</a>
        </div>
    @endif
</div>