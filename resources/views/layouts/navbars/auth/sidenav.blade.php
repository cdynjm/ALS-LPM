@php
    use App\Models\StudentExamAttempts;

    if(Auth::user()->role == 3) {
        $count = StudentExamAttempts::where(['type' => 2])->where(['studentID' => Auth::user()->Students->id])->count();
    }
@endphp
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " style="position: fixed; z-index: 10;"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex mt-3" href="">
            <img style="width: 50px; height: 50px;" src="{{ asset('storage/logo/als-logo.png') }}" class="ms-4 mb-4 mt-2" alt="...">
            <span class="ms-3 sidebar-text fw-bolder fs-4">
                ALS
            <p style="font-size: 10px;">Learners Progress Monitoring</p>
          </span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">General</h6>
            </li>
            <li class="nav-item">
                <a  wire:navigate
                @if(auth()->user()->role == 1)
                    class="nav-link {{ Route::currentRouteName() == 'admin-dashboard' ? 'active' : '' }}" href="{{ route('admin-dashboard') }}"
                @endif
                @if(auth()->user()->role == 2) 
                    class="nav-link {{ Route::currentRouteName() == 'teacher-dashboard' ? 'active' : '' }}" href="{{ route('teacher-dashboard') }}"
                @endif
                @if(auth()->user()->role == 3) 
                    class="nav-link {{ Route::currentRouteName() == 'student-dashboard' ? 'active' : '' }}" href="{{ route('student-dashboard') }}"
                @endif
                > 
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a wire:navigate
                @if(auth()->user()->role == 1)
                    class="nav-link {{ Route::currentRouteName() == 'admin-profile' ? 'active' : '' }}" href="{{ route('admin-profile') }}"
                @endif
                @if(auth()->user()->role == 2)
                    class="nav-link {{ Route::currentRouteName() == 'teacher-profile' ? 'active' : '' }}" href="{{ route('teacher-profile') }}"
                @endif
                @if(auth()->user()->role == 3)
                    class="nav-link {{ Route::currentRouteName() == 'account-profile' ? 'active' : '' }}" href="{{ route('account-profile') }}"
                @endif
                >
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Your Profile</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pages</h6>
            </li>
            @if(auth()->user()->role == 1)
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ str_contains(request()->url(), 'teachers') == true ? 'active' : '' }}" href="{{ route('teachers')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-users opacity-10 text-lg text-warning"></i>
                    </div>
                    <span class="nav-link-text ms-1">Teachers</span>
                </a>
            </li>
            <li class="nav-item">
                <a wire:navigate class="nav-link {{  str_contains(request()->url(), 'programs') == true ? 'active' : '' }}" href="{{ route('programs') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Programs</span>
                </a>
            </li>
            <li class="nav-item">
                <a wire:navigate class="nav-link {{  str_contains(request()->url(), 'learning-strands') == true ? 'active' : '' }}" href="{{ route('learning-strands') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-book opacity-10 text-lg text-danger"></i>
                    </div>
                    <span class="nav-link-text ms-1">Learning Strands</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->role == 1 || auth()->user()->role == 2)
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ str_contains(request()->url(), 'students') == true ? 'active' : '' }}" href="{{ route('students')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-graduation-cap opacity-10 text-lg text-info"></i>
                    </div>
                    <span class="nav-link-text ms-1">Students</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->role == 2)
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ str_contains(request()->url(), 'exams') == true ? 'active' : '' }}" href="{{ route('exams')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-newspaper opacity-10 text-lg text-primary"></i>
                    </div>
                    <span class="nav-link-text ms-1">Exams</span>
                </a>
            </li>
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ str_contains(request()->url(), 'learning-materials') == true ? 'active' : '' }}" href="{{ route('learning-materials')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-book-reader opacity-10 text-lg text-danger"></i>
                    </div>
                    <span class="nav-link-text ms-1">Learning Materials</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->role == 3)
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ str_contains(request()->url(), 'exam-result') == true ? 'active' : '' }}" href="{{ route('exam-result')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-newspaper opacity-10 text-lg text-primary"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pre-Exam Result</span>
                </a>
            </li>
                @if($count != 0)
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ str_contains(request()->url(), 'post-test-result') == true ? 'active' : '' }}" href="{{ route('post-test-result')}}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-newspaper opacity-10 text-lg text-success"></i>
                        </div>
                        <span class="nav-link-text ms-1">Post-Exam Result</span>
                    </a>
                </li>
                @endif
            @endif
        </ul>
    </div>
    
</aside>

