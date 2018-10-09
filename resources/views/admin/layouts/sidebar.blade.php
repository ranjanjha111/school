<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('dashboard.index') }}" class="site_title"><i class="fa fa-paw"></i> <span>School Admin</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ asset('admin/images/img.jpg') }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ Auth::user()->name }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-user"></i> Manage Admin <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admins.index') }}">List Admin</a></li>
                            @can('add_admins')
                                <li><a href="{{ route('admins.create') }}">Add New Admin</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li><a><i class="fa fa-user"></i> Manage User <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('users.index') }}">List User</a></li>
                            @can('add_users')
                                <li><a href="{{ route('users.create') }}">Add New User</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li><a><i class="fa fa-key"></i> Manage Role <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('roles.index') }}">List Role</a></li>
                            @can('add_users')
                                <li><a href="{{ route('roles.create') }}">Add New Role</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li><a><i class="fa fa-users" aria-hidden="true"></i>Manage Language <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('languages.index') }}">List Language</a></li>
                            <li><a href="{{ route('languages.create') }}">Add New Language</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-users" aria-hidden="true"></i>Manage Team <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('teams.index') }}">List Team</a></li>
                            <li><a href="{{ route('teams.create') }}">Add New Team</a></li>
                        </ul>
                    </li>

                    <li><a><i class="fa fa-flag" aria-hidden="true"></i> Manage State <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('states.index') }}">List State</a></li>
                            @can('add_users')
                                <li><a href="{{ route('states.create') }}">Add State</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li><a><i class="fa fa-building"></i> Manage City <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('city.index') }}">List City</a></li>
                            @can('add_users')
                                <li><a href="{{ route('city.create') }}">Add New City</a></li>
                            @endcan
                        </ul>
                    </li>

                    <li><a><i class="fa fa-history" aria-hidden="true"></i> Manage Activity <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('activities.index') }}">List Activity</a></li>
                            @can('add_users')
                                <li><a href="{{ route('activities.create') }}">Add New Activity</a></li>
                            @endcan
                        </ul>
                    </li>
                    {{--<li><a><i class="fa fa-universal-access" aria-hidden="true"></i> Manage Nutrition <span class="fa fa-chevron-down"></span></a>--}}
                    {{--<ul class="nav child_menu">--}}
                    {{--<li><a href="{{ route('nutritions.index') }}">List Nutrition</a></li>--}}
                    {{--@can('add_users')--}}
                    {{--<li><a href="{{ route('nutritions.create') }}">Add New Nutrition</a></li>--}}
                    {{--@endcan--}}
                    {{--</ul>--}}
                    {{--</li>--}}








                    {{--<li><a><i class="fa fa-tasks" aria-hidden="true"></i> Manage Program <span class="fa fa-chevron-down"></span></a>--}}
                    {{--<ul class="nav child_menu">--}}
                    {{--<li><a href="{{ route('programs.index') }}">List Program</a></li>       --}}
                    {{--@can('add_users')--}}
                    {{--<li><a href="{{ route('programs.create') }}">Add New Program</a></li>    --}}
                    {{--@endcan--}}
                    {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li><a><i class="fa fa-tasks" aria-hidden="true"></i> Manage Gallery <span class="fa fa-chevron-down"></span></a>--}}
                    {{--<ul class="nav child_menu">--}}
                    {{--<li><a href="{{ route('galleries.index') }}">List Gallery</a></li>       --}}
                    {{--@can('add_users')--}}
                    {{--<li><a href="{{ route('galleries.create') }}">Add New Gallery</a></li>    --}}
                    {{--@endcan--}}
                    {{--</ul>--}}
                    {{--</li>--}}

                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

    </div>
</div>