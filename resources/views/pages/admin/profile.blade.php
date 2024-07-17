@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header pb-0 text-center">
                        <div class="align-items-center">
                            <h5 class="fw-bolder"><i class="fa-solid fa-user-shield me-1"></i>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h5> 
                            <p class="text-sm"></p>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        <form action="" id="update-admin-profile">
                            <div class="row">

                                <div class="col-md-6">

                                    <p>Personal Information</p>

                                    <label for="">First Name</label>
                                    <input type="text" class="form-control" name="firstname" value="{{ Auth::user()->firstname }}" required>
                                
                                    <label for="">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" value="{{ Auth::user()->lastname }}" required>

                                    <label for="">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ Auth::user()->address }}" required>
                                </div>

                                <div class="col-md-6">

                                    <p>Account Information</p>

                                    <label for="">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                                
                                    <label for="">New Password</label>
                                    <input type="text" class="form-control" name="password">

                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-sm bg-gradient-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
