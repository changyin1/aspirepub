<div class="sidebar mt-4">
    <h2>Dashboard</h2>
    <ul>
        <a href="{{route('admin/clients')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/clients') == 0) ? 'active' : '' }}"><li>Clients</li></a>
        <a href="{{route('admin/schedules')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/schedules') == 0) ? 'active' : '' }}"><li>Schedules</li></a>
        <a href="{{route('admin/questions')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/questions') == 0) ? 'active' : '' }}"><li>Questions</li></a>
        <a href="{{route('admin/question_templates')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/question_templates') == 0) ? 'active' : '' }}"><li>Question Templates</li></a>
        <a href="{{route('admin/users')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/users') == 0) ? 'active' : '' }}"><li>Users</li></a>
    </ul>
</div>
