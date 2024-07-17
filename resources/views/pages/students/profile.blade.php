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
                            <h5 class="fw-bolder"><i class="fa-solid fa-user-shield me-1"></i> {{ Auth::user()->Students->firstname }}  {{ Auth::user()->Students->lastname }}</h5> 
                            <p class="text-sm"></p>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                       
                        <form action="" id="update-student-profile">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">

                                    <p>Personal Information</p>

                                    <label for="">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" value="{{ Auth::user()->Students->lastname }}" required>

                                    <label for="">First Name</label>
                                    <input type="text" class="form-control" name="firstname" value="{{ Auth::user()->Students->firstname }}" required>

                                    <label for="">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename" value="{{ Auth::user()->Students->middlename }}" required>

                                    <label for="">Birth Date</label>
                                    <input type="date" class="form-control" name="birthdate" value="{{ Auth::user()->Students->birthdate }}" required>

                                    <label for="">Place of Birth</label>
                                    <input type="text" class="form-control" name="birthplace" value="{{ Auth::user()->Students->birthplace }}" required>

                                    <label for="">Highest Educational Attainment</label>
                                    <select name="education" id="" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="{{ $aes->encrypt('Elementary Undergraduate') }}" @if(Auth::user()->Students->education == 'Elementary Undergraduate') selected @endif>Elementary Undergraduate</option>
                                        <option value="{{ $aes->encrypt('Elementary Graduate') }}" @if(Auth::user()->Students->education == 'Elementary Graduate') selected @endif>Elementary Graduate</option>
                                        <option value="{{ $aes->encrypt('High School Undergraduate') }}" @if(Auth::user()->Students->education == 'High School Undergraduate') selected @endif>High School Undergraduate</option>
                                        <option value="{{ $aes->encrypt('High School Graduate') }}" @if(Auth::user()->Students->education == 'High School Graduate') selected @endif>High School Graduate</option>
                                        <option value="{{ $aes->encrypt('College Undergraduate') }}" @if(Auth::user()->Students->education == 'College Undergraduate') selected @endif>College Undergraduate</option>
                                        <option value="{{ $aes->encrypt('College Graduate') }}" @if(Auth::user()->Students->education == 'College Graduate') selected @endif>College Graduate</option>
                                    </select>

                                    <p class="mt-4">Your Address</p>

                                    <label for="">Current Address</label>
                                    <input type="text" class="form-control bg-white" value="{{ Auth::user()->Students->street }}, {{ Auth::user()->Students->Barangay->brgyDesc }}, {{ ucwords(strtolower(Auth::user()->Students->Municipal->citymunDesc)) }}, {{ ucwords(strtolower(Auth::user()->Students->Province->provDesc)) }}" disabled>
                                    
                                    <div class="form-check form-switch mt-3">
                                        <input class="form-check-input" name="address" type="checkbox" value="1" id="update-address-btn">
                                        <label class="form-check-label" for="">Update Address</label>
                                    </div>

                                    <div class="group" style="display: none;">
                                        <label for="">Street</label>
                                        <input type="text" class="form-control" name="street" disabled>

                                        <label for="">Province</label>
                                        <select name="province" class="form-select" id="select-province" disabled>
                                            <option value="">Select</option>
                                            @foreach ($province as $prov)
                                                <option value="{{ $aes->encrypt($prov->provCode) }}">{{ ucwords(strtolower($prov->provDesc)) }}</option>
                                            @endforeach
                                        </select>

                                        <label for="select-municipal">Municipality</label>
                                        @include('pages.students.address.municipal')

                                        <label for="">Barangay</label>
                                        @include('pages.students.address.barangay')
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Community Learning Center</label>
                                    <input type="text" class="form-control" name="clc" value="{{ Auth::user()->Students->clc }}" required>

                                    <label for="">Divsion</label>
                                    <input type="text" class="form-control" name="division" value="{{ Auth::user()->Students->division }}" required>

                                    <label for="">District</label>
                                    <input type="text" class="form-control" name="district" value="{{ Auth::user()->Students->district }}" required>

                                    <label for="">Program Enrolled</label>
                                    <select name="program" id="" class="form-select" required>
                                        <option value="">Select...</option>
                                        @foreach ($programs as $pr)
                                            <option value="{{ $aes->encrypt($pr->id) }}" @if(Auth::user()->Students->Programs->id == $pr->id) selected @endif>{{ $pr->program }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <label for="">Teacher</label>
                                    <select name="teacher" id="" class="form-select" required>
                                        <option value="">Select...</option>
                                        @foreach ($teachers as $tc)
                                            <option value="{{ $aes->encrypt($tc->id) }}" @if(Auth::user()->Students->Teachers->id == $tc->id) selected @endif>{{ $tc->name }}</option>
                                        @endforeach
                                    </select>

                                    <p class="mt-4">Account Information</p>

                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>

                                    <label for="">New Password</label>
                                    <input type="" class="form-control" name="password">

                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-sm bg-gradient-danger mt-4"> Update</button>
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
