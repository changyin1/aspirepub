<div class="sidebar mt-4">
    <h2>Dashboard</h2>
    <ul>
        <li>
            <a href="{{route('admin/settings')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/settings') === 0) ? 'active' : '' }}">Call Settings</a>
        </li>
        <li>
            <a href="{{route('admin/clients')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/clients') === 0) ? 'active' : '' }}">Clients</a>
            @if(strpos(Route::currentRouteName(), 'admin/clients') === 0   ||
                strpos(Route::currentRouteName(), 'admin/companies') === 0 ||
                strpos(Route::currentRouteName(), 'admin/regions') === 0   ||
                strpos(Route::currentRouteName(), 'admin/categories') === 0)
                <ul>
                    <li>
                        <a href="{{route('admin/companies')}}">Companies</a>
                    </li>
                    <li>
                        <a href="{{route('admin/regions')}}">Regions</a>
                    </li>
                    <li>
                        <a href="{{route('admin/categories')}}">Categories</a>
                    </li>
                </ul>
            @endif
        </li>
        <li>
            <a href="{{route('admin/schedules')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/schedules') === 0) ? 'active' : '' }}">Schedules</a>
        </li>
        <li>
            <a href="{{route('admin/questions')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/questions') === 0) ? 'active' : '' }}">Questions</a>
        </li>
        <li><a href="{{route('admin/question_templates')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/question_templates') === 0) ? 'active' : '' }}">Question Templates</a>
        </li>
        <li>
            <a href="{{route('admin/reports')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/reports') === 0) ? 'active' : '' }}">Reports</a>
        </li>
        <li>
            <a href="{{route('admin/users')}}" class="{{ (strpos(Route::currentRouteName(), 'admin/users') === 0) ? 'active' : '' }}">Users</a>
        </li>
    </ul>
</div>
