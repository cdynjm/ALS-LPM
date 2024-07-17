@php
    use Illuminate\Support\Facades\File;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="token" content="{{ Session::get('token') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo/als-logo.png') }}">
    <title>
        ALS | Learners Progress Monitoring
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/argon-dashboard.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css' data-navigate-once>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" data-navigate-once></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" data-navigate-once></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js" data-navigate-once></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" data-navigate-once></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js" data-navigate-once></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous" data-navigate-once></script>

    <link rel='stylesheet' href='{{asset('storage/css/student.css')}}'>
    <link rel='stylesheet' href='{{asset('storage/css/datatable.css')}}'>

    <script src="{{asset('storage/js/admin.js')}}" data-navigate-once></script>
    <script src="{{asset('storage/js/teacher.js')}}" data-navigate-once></script>
    <script src="{{asset('storage/js/student.js')}}" data-navigate-once></script>

     <!-- CKEditor 4 CDN -->
     <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.onpopstate = function(event) {
            window.location.reload(true);
        };
    </script>

    @livewireStyles
</head>

<body class="{{ $class ?? '' }}">
   
    @php
        $folderPath = base_path('vendor/livewire/livewire');
        $linkPath = public_path('storage');
    @endphp
    
    @if(!File::exists($folderPath))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Please install laravel livewire framework to proceed',
                html: '<span class="text-danger">You are not authorized to access this page.</span> <br><br> <span class="text-sm">1. `composer require livewire/livewire` <br> 2. `php artisan livewire:publish --config`</span>',
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false
            }).then(function(){ 
                    location.reload();
                });
        </script>
    @endif

    @if(!File::exists($linkPath))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Storage link not found',
                html: '<span class="text-danger">You are not authorized to access this page.</span> <br><br> <span class="text-sm">Please run `php artisan storage:link` or `localhost:8000/storage`</span>',
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false
            }).then(function(){ 
                    location.reload();
                });
        </script>
    @endif

    <script data-navigate-once>
        // Listen for the offline event
        window.addEventListener('offline', function(e) {
            // Show a SweetAlert popup when offline
            SweetAlert.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No internet connection!',
            });
        });
        
        // Optional: Listen for the online event
        window.addEventListener('online', function(e) {
            // Show a SweetAlert popup when back online
            SweetAlert.fire({
                icon: 'success',
                title: 'Great News!',
                text: 'Internet connection restored!',
            });
        });
    </script>

    @guest
        @yield('content')
    @endguest

    @auth
        @if (in_array(request()->route()->getName(), ['sign-in-static', 'sign-up-static', 'login', 'register', 'recover-password', 'rtl', 'virtual-reality']))
            @yield('content')
        @else
            @if (!in_array(request()->route()->getName(), ['profile', 'profile-static']))
               
            @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile']))
                
            @endif
            @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                @include('layouts.navbars.auth.sidenav')
            @endif
            @if(auth()->user()->role == 3)
                @if(auth()->user()->Students->status == 0)
                    @include('layouts.navbars.auth.sidenav')
                @endif
            @endif
                <main class="main-content border-radius-lg">
                    @yield('content')
                    @include('components.fixed-plugin')
                </main>
            
        @endif
    @endauth

    <!--   Core JS Files   -->
    <script src="/assets/js/core/popper.min.js" data-navigate-once></script>
    <script src="/assets/js/core/bootstrap.min.js" data-navigate-once></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js" data-navigate-once></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js" data-navigate-once></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js" data-navigate-once></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/assets/js/argon-dashboard.js"></script>
    
    <style> #nprogress .bar { background: red !important; } </style>

    @stack('js')
    @livewireScripts

</body>

</html>
