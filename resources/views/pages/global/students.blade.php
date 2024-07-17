@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Students'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-2 text-sm text-info">Students</h5>
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
                                            Address</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Highest Educational Attainment</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Teacher</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            FLT Pre-Exam Result</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            FLT Post-Exam Result</th>
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
                                                    <a wire:navigate href="{{ route('student-profile', ['id' => $aes->encrypt($st->id)]) }}?key={{ \Str::random(50) }}">
                                                        <h6 class="mb-0 text-sm">{{ $st->lastname }} {{ $st->firstname }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $st->User->email }}</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-wrap text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $st->Barangay->brgyDesc }}, {{ ucwords(strtolower($st->Municipal->citymunDesc)) }}, {{ ucwords(strtolower($st->Province->provDesc)) }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $st->education }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $st->Teachers->name }}</span>
                                        </td>
                                        <td class="align-middle text-center text-wrap">
                                            <span class="text-dark text-sm font-weight-bolder">
                                                @php
                                                    $data = 0;
                                                    $total = 0;
                                                @endphp
                                                @foreach ($fltResult as $flt)
                                                    @if($flt->studentID == $st->id && $flt->type == 1)
                                                        {{ $flt->score }} / {{ $flt->item }}
                                                        @php
                                                            $total = ($flt->score / $flt->item) * 100;
                                                            $data += 1;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if($data == 0)
                                                    <div class="text-sm text-danger mb-1">No Data</div>
                                                @endif
                                                <div class="progress">
                                                    <div class="progress-bar 
                                                    @if($total >= 75)
                                                        bg-success
                                                    @endif
                                                    @if($total >= 50 && $total < 75)
                                                        bg-orange
                                                    @endif
                                                    @if($total < 50)
                                                        bg-danger
                                                    @endif
                                                    " role="progressbar" style="width: {{ $total }}%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <style>.bg-orange { background-color: orange !important; }</style>
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-wrap">
                                            <span class="text-dark text-sm font-weight-bolder">
                                                @php
                                                    $data = 0;
                                                    $total = 0;
                                                @endphp
                                                @foreach ($fltResult as $flt)
                                                    @if($flt->studentID == $st->id && $flt->type == 2)
                                                        {{ $flt->score }} / {{ $flt->item }}
                                                        @php
                                                            $total = ($flt->score / $flt->item) * 100;
                                                            $data += 1;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if($data == 0)
                                                    <div class="text-sm text-danger mb-1">No Data</div>
                                                @endif
                                                <div class="progress">
                                                    <div class="progress-bar 
                                                    @if($total >= 75)
                                                        bg-success
                                                    @endif
                                                    @if($total >= 50 && $total < 75)
                                                        bg-orange
                                                    @endif
                                                    @if($total < 50)
                                                        bg-danger
                                                    @endif
                                                    " role="progressbar" style="width: {{ $total }}%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <style>.bg-orange { background-color: orange !important; }</style>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a wire:navigate href="{{ route('student-profile', ['id' => $aes->encrypt($st->id)]) }}?key={{ \Str::random(50) }}" class="text-secondary font-weight-bold text-xs me-2"
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
