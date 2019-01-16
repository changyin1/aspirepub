<div class="nav-top text-right">
    <a href="#"><i class="fas fa-bell"></i></a>
    <a href="#">My Profile <i class="fas fa-user-circle"></i></a>
    <a href="{{route('logout')}}">Logout</a>
</div>
<div class="nav-bottom">
    <div class="left">
        <div class="logo d-inline-block"><img src="images/logo-white.png" alt="logo"></div>
        <div class="nav-tabs">
            <a class="nav-tab{{Route::currentRouteName() == 'agenda' ? ' active' : '' }}" href="{{route('agenda')}}"><div>Agenda</div></a>
            <a class="nav-tab{{Route::currentRouteName() == 'availability' ? ' active' : '' }}" href="{{route('availability')}}"><div>Availability</div></a>
            <a class="nav-tab{{Route::currentRouteName() == 'settings' ? ' active' : '' }}" href="{{route('settings')}}"><div>Settings</div></a>
        </div>
    </div>
    <div class="right">
        <a href="#">My Balance</a>
        <a class="big-text" href="#">$0.00</a>
    </div>
</div>