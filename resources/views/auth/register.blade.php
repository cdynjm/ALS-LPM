@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'bg-gray-100'])

@section('content')
    
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header pb-0 m-auto">
                    <a class="align-items-center d-flex" href="">
                    <img style="width: 55px; height: 55px;" src="{{ asset('storage/logo/als-logo.png') }}" class="ms-2 mb-3" alt="...">
                    <span class="sidebar-text fw-bolder fs-4 ms-2">
                        ALS
                        <p style="font-size: 10px;">Learners Progress Monitoring</p>
                    </span>
                    </a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header pb-0 text-center">
                        <div class="align-items-center">
                            <h5 class="fw-bolder"><i class="fa-solid fa-user-shield me-1"></i> Create your account</h5> 
                            <p class="text-sm">Enter your account credentials to proceed</p>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        <form action="" id="register-student">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">

                                    <p>Personal Information</p>

                                    <label for="">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" required>

                                    <label for="">First Name</label>
                                    <input type="text" class="form-control" name="firstname" required>

                                    <label for="">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename" required>

                                    <label for="">Birth Date</label>
                                    <input type="date" class="form-control" name="birthdate" required>

                                    <label for="">Place of Birth</label>
                                    <input type="text" class="form-control" name="birthplace" required>

                                    <label for="">Highest Educational Attainment</label>
                                    <select name="education" id="" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="{{ $aes->encrypt('Elementary Undergraduate') }}">Elementary Undergraduate</option>
                                        <option value="{{ $aes->encrypt('Elementary Graduate') }}">Elementary Graduate</option>
                                        <option value="{{ $aes->encrypt('High School Undergraduate') }}">High School Undergraduate</option>
                                        <option value="{{ $aes->encrypt('High School Graduate') }}">High School Graduate</option>
                                        <option value="{{ $aes->encrypt('College Undergraduate') }}">College Undergraduate</option>
                                        <option value="{{ $aes->encrypt('College Graduate') }}">College Graduate</option>
                                    </select>

                                    <p class="mt-4">Your Address</p>

                                    <label for="">Street/Purok</label>
                                    <input type="text" class="form-control" name="street" required>

                                    <label for="">Province</label>
                                    <select name="province" class="form-select" id="select-province" required>
                                        <option value="">Select</option>
                                        @foreach ($province as $prov)
                                            <option value="{{ $aes->encrypt($prov->provCode) }}">{{ ucwords(strtolower($prov->provDesc)) }}</option>
                                        @endforeach
                                    </select>

                                    <label for="select-municipal">Municipality</label>
                                    @include('auth.address.municipal')

                                    <label for="">Barangay</label>
                                    @include('auth.address.barangay')
                                </div>
                                <div class="col-md-6">
                                    <label for="">Community Learning Center</label>
                                    <input type="text" class="form-control" name="clc" required>

                                    <label for="">Divsion</label>
                                    <input type="text" class="form-control" name="division" required>

                                    <label for="">District</label>
                                    <input type="text" class="form-control" name="district" required>

                                    <label for="">Program Enrolled</label>
                                    <select name="program" id="" class="form-select" required>
                                        <option value="">Select...</option>
                                        @foreach ($programs as $pr)
                                            <option value="{{ $aes->encrypt($pr->id) }}">{{ $pr->program }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <label for="">Teacher</label>
                                    <select name="teacher" id="" class="form-select" required>
                                        <option value="">Select...</option>
                                        @foreach ($teachers as $tc)
                                            <option value="{{ $aes->encrypt($tc->id) }}">{{ $tc->name }}</option>
                                        @endforeach
                                    </select>

                                    <p class="mt-4">Account Information</p>

                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email" required>

                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="password" required>

                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn bg-gradient-danger mt-4"> Register</button>
                            </div>
                          
                            <div class="card-footer text-center pt-0 px-lg-2 px-1 mb-0 mt-2">
                                <p class="text-sm mx-auto mb-0">
                                    Already have an account?
                                    <a wire:navigate href="{{ route('login') }}" class="text-success font-weight-bold">Sign in</a>
                                </p>
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
