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
                            <h5 class="fw-bolder"><i class="fa-solid fa-user-shield me-1"></i>{{ Auth::user()->Teachers->name }}</h5> 
                            <p class="text-sm"></p>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        <form action="" id="update-teacher-profile">
                            <div class="row">

                                <div class="col-md-6">

                                    <p>Personal Information</p>

                                    <label for="">Full Name</label>
                                    <input type="text" class="form-control" name="fullName" value="{{ Auth::user()->Teachers->name }}" required>
                                
                                    <label for="">Position/Rank</label>
                                    <input type="text" class="form-control" name="position" value="{{ Auth::user()->Teachers->position }}" required>

                                    <label for="">Date Employed</label>
                                    <input type="date" class="form-control" name="dateEmployed" value="{{ Auth::user()->Teachers->dateEmployed }}" required>
                                
                                    <label for="">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ Auth::user()->Teachers->address }}" required>

                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control" name="contactNumber" value="{{ Auth::user()->Teachers->contactNumber }}" required>
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
