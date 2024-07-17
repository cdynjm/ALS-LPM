@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Students</p>
                                    <h5 class="font-weight-bolder fs-3">
                                       @livewire('fetch-students-count')
                                    </h5>
                                    <p class="mb-0 text-xs">
                                        Total Count
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-primary text-center rounded-circle">
                                    <i class="fas fa-user-graduate opacity-10 text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Learning Materials</p>
                                    <h5 class="font-weight-bolder fs-3">
                                        @livewire('fetch-learning-materials-count')
                                    </h5>
                                    <p class="mb-0 text-xs">
                                        Total Count
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-primary text-center rounded-circle">
                                    <i class="fas fa-folder-open opacity-10 text-lg"></i>
                                </div>
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
                            <h5 class="mb-2 text-sm text-info">Progress Watch</h5>
                        </div>
                    </div>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table class="table align-items-center mb-0" id="student-data-result">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Progress</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Learning Materials Total</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Submissions</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $st)

                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="https://cdn-icons-png.flaticon.com/512/9131/9131529.png" class="avatar avatar-sm me-3"
                                                        alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <a wire:navigate href="{{ route('student-submissions', ['id' => $aes->encrypt($st->id)]) }}?key={{ \Str::random(50) }}">
                                                        <h6 class="mb-0 text-sm">{{ $st->lastname }} {{ $st->firstname }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $st->User->email }}</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center text-lg">
                                            <div class="text-xs mb-2">{{ number_format($st->progress, 2) }}%</div>
                                            <div class="progress">
                                                <div class="progress-bar
                                                @if($st->progress >= 75)
                                                    bg-success
                                                @endif
                                                @if($st->progress >= 50 && $st->progress < 75)
                                                    bg-orange
                                                @endif
                                                @if($st->progress < 50)
                                                    bg-danger
                                                @endif
                                                " role="progressbar" style="width: {{ $st->progress }}%" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <style>.bg-orange { background-color: orange !important; }</style>
                                        </td>

                                        <td class="text-wrap text-center">
                                            <p class="text-sm font-weight-bolder mb-0">
                                                {{ $st->learningMaterials }}
                                            </p>
                                        </td>

                                        <td class="text-wrap text-center">
                                            <p class="text-xs font-weight-bolder mb-0">{{ $st->submissions }}
                                                @if($st->newSubmissions != 0)  |
                                                <span class="badge bg-gradient-danger text-capitalize">New</span>
                                                <span class="text-danger text-lg ms-1">{{ $st->newSubmissions }}</span>
                                                @endif
                                                
                                            </p>
                                        </td>
                                       
                                        <td class="text-center">
                                            <a wire:navigate href="{{ route('student-submissions', ['id' => $aes->encrypt($st->id)]) }}?key={{ \Str::random(50) }}" class="text-secondary font-weight-bold text-xs me-2"
                                                data-toggle="tooltip">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        @include('layouts.footers.auth.footer')
    </div>
@endsection