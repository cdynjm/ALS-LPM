<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}"
        data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title }}</li>
            </ol>
            <h6 class="font-weight-bolder text-dark mb-0">{{ $title }}</h6>
        </nav>
        <div class="navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                    
                </div>
            </div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    
                    <a href="javascript:;" class="nav-link text-dark p-0 mt-2" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                        @if(auth()->user()->role == 1)
                            <span class=" fw-bolder d-sm-inline">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</span>
                            <img src="https://cdn-icons-png.flaticon.com/512/9131/9131529.png" class="avatar avatar-sm ms-2" alt="user1">
                            <div class="text-xs text-center">Administrator</div>
                        @endif
                        @if(auth()->user()->role == 2)
                            <span class="fw-bolder d-sm-inline">{{ auth()->user()->Teachers->name }}</span>
                            <img src="https://cdn-icons-png.flaticon.com/512/9131/9131529.png" class="avatar avatar-sm ms-2" alt="user1">
                            <div class="text-xs text-center">Teacher</div>
                        @endif
                        @if(auth()->user()->role == 3)
                            <span class="fw-bolder d-sm-inline">{{ auth()->user()->Students->firstname }} {{ auth()->user()->Students->lastname }}</span>
                            <img src="https://cdn-icons-png.flaticon.com/512/9131/9131529.png" class="avatar avatar-sm ms-2" alt="user1">
                            <div class="text-xs text-center">Student</div>
                        @endif
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3"
                        aria-labelledby="dropdownMenuButton">
                        <li class="list-group-item p-0" style="border: none !important;">
                            <a wire:navigate 
                            @if(Auth::user()->role == 1)
                                href="{{ route('admin-profile') }}" 
                            @endif
                            @if(Auth::user()->role == 2)
                                href="{{ route('teacher-profile') }}" 
                            @endif
                            @if(Auth::user()->role == 3)
                                href="{{ route('account-profile') }}" 
                            @endif
                            class=" ms-2 nav-link text-dark font-weight-bold p-0">
                                <i class="fas fa-user-circle me-2"></i> Profile
                            </a>
                        </li>
                        <hr>
                        <li class="list-group-item p-0" style="border: none !important;">
                            <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="ms-2 nav-link text-dark font-weight-bold p-0">
                                    <i class="fas fa-sign-out-alt me-2"></i> Log Out
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
                @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-dark p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-dark"></i>
                            <i class="sidenav-toggler-line bg-dark"></i>
                            <i class="sidenav-toggler-line bg-dark"></i>
                        </div>
                    </a>
                </li>
                @endif
                @if(auth()->user()->role == 3)
                    @if(auth()->user()->Students->status == 0)
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-dark p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-dark"></i>
                                    <i class="sidenav-toggler-line bg-dark"></i>
                                    <i class="sidenav-toggler-line bg-dark"></i>
                                </div>
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
