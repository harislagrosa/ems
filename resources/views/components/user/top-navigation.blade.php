        <header id="header" class="header">
            <div class="top-left ">
                <div class="navbar-header">
                    <a class="navbar-brand logo" href="">
                        <h4 class="text-main font-weight-bold position-absolute" style="margin: -13px">EMS</h4>
                    </a>
                    <a class="navbar-brand logo hidden" href="">
                        <label>EMS</label>
                    </a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="user-area dropdown float-left" id="top-profile">
                        <a href="#" class="dropdown-toggle active  mt-2 mt-md-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <small class="font-weight-bold h6 mr-2 mt-2 text-dark text-capitalize">
                                {{ Auth::user()->firstname }}
                                {{ Auth::user()->lastname }}
                            </small>
                            
                            @if(Auth::guard()->user()->profile)
                                <img class="user-avatar rounded-circle" src="{{ asset(Auth::user()->profile) }}" alt="User Avatar">
                            @else
                                <label class="text-light bg-main name-icon text-center text-uppercase" type="button"  >
                                    <b>
                                        {{ Str::limit(Auth::user()->firstname ,1,'').Str::limit(Auth::user()->lastname, 1, '') }}
                                    </b>
                                </label>
                            @endif
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href=""><i class="fa fa- user"></i>My Account</a>
                            <a class="nav-link" href="#" onclick="document.getElementById('logout-form').submit();"><i class="fa fa-power -off"></i>Logout</a>

                            <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
