@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.teachers.score-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Student Submissions'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-auto">
                                <span class="icon icon-shape bg-gradient-info shadow-primary text-center rounded-circle">
                                    <i class="fas fa-user-graduate opacity-10 text-lg"></i>
                                </span>
                            </div>
                            <div class="col">
                                <h6 class="">
                                    {{ $students->firstname }} {{ $students->lastname }}
                                    <div class="text-sm fw-light">Student | <span class="text-xs">{{ $students->User->email }}</span></div>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-auto">
                                <span class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="fas fa-star opacity-10 text-lg"></i>
                                </span>
                            </div>
                            <div class="col">
                                <h6 class="">
                                    <span class="fw-bolder">@livewire('fetch-student-score')</span>
                                    <div class="text-sm fw-light">Overall Score</div>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-2 text-sm text-danger">Learning Materials</h5>
                        </div>
                    </div>
                    </div>
                   
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            @include('data.student-submissions-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
