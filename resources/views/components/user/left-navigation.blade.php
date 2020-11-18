
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            @if(Auth::user()->profile)
                <a href="#">
                    <img class="shadow profile-img mr-3 " style="width:140px; height:140px; border-radius: 50%" alt="" src="{{ asset(Auth::user()->profile) }}">
                </a>
            @else
                <div class="bg-main text-light ml-3 mt-3" style="width:80px; height:80px; border-radius: 50%; padding-top:10px">
                    <h1 class="text-center pt-2 text-uppercase">
                        {{ Str::limit(Auth::user()->firstname ,1,'') }}{{ Str::limit(Auth::user()->lastname ,1,'') }}
                    </h1>
                </div>
                <div class="row ml-3 mt-1">
                    <h5 class="text-capitalize">{{ Auth::user()->firstname." ".Auth::user()->lastname }}</h5>
                </div>
            @endif

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav mt-3">
                    <li >
                        <router-link to='/dashboard' class="new-link" exact>
                            <i class="menu-icon fa fa-dashboard"></i> Dashboard
                        </router-link>
                    </li>

                    @if (Auth::user()->role_id == 1)
                        <li class="menu-title">User Management</li>
                        <li>
                            <router-link to='/roles' class="new-link">
                                <i class="menu-icon fa fa-user"></i> Roles
                            </router-link>
                        </li>
                        <li>
                            <router-link to='/users' class="new-link">
                                <i class="menu-icon fa fa-users"></i> Users
                            </router-link>
                        </li>
                    @endif

                    <li class="menu-title">Expense Management</li>
                    @if (Auth::user()->role_id == 1)
                        <li>
                            <router-link to='/expense-categories' class="new-link">
                                <i class="menu-icon fa fa-list"></i> Expense Categories
                            </router-link>
                        </li>
                    @endif
                    <li>
                        <router-link to='/expenses' class="new-link">
                            <i class="menu-icon fa fa-dollar"></i> Expenses
                        </router-link>
                    </li>


                    <li class="menu-title">Manage Account</li>

                    <li>
                        <router-link to='/settings' class="new-link">
                            <i class="menu-icon fa fa-cog"></i> My Account
                        </router-link>
                    </li>
                    <li>
                        <a href="javascript:logout" onclick="document.getElementById('logout-form').submit();"> <i class="menu-icon fa fa-arrow-left"></i> Logout </a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>
