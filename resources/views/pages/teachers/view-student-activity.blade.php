@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
    $fileExtension = pathinfo($activity->filename, PATHINFO_EXTENSION);
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Student Activity'])
    <div class="container-fluid py-4">
        <div class="row">
            @if($fileExtension == 'pdf')
           
            @endif
            <div class="col-md-6 text-center mb-4">
                <p class="fw-bolder">{{ $activity->filename }}</p>
                @if($fileExtension == 'pdf')
                <a class="text-sm text-decoration-underline text-dark fw-bold" target="_blank" href="{{ asset('storage/activities/'.$activity->filename) }}">
                    <i class="fas fa-external-link-alt me-2 text-sm"></i> Open on New Tab
                </a>
                <div class="ratio mt-3" style="--bs-aspect-ratio: 100%;">
                    <iframe class="rounded-3" src="{{ asset('storage/activities/'.$activity->filename) }}"></iframe>
                </div>
                @else
                <div class="fs-1 text-danger">
                    <i class="fas fa-eye-slash"></i>
                </div>
                <span class="text-xs">
                    Due to the file format not being supported by the browser, it cannot be displayed directly within the browser window. As a result, instead of being viewable here, the file will be made available for download to ensure you can access it without any issues.
                </span>
                <div class="mt-4">
                    <a class="ms-2 text-sm text-decoration-underline text-dark fw-bold" target="_blank" href="{{ asset('storage/activities/'.$activity->filename) }}">
                         <i class="fas fa-download me-2 text-sm"></i> Download Document
                    </a>
                </div>
                @endif
            </div>
            <div class="col-md-6 text-center mb-4">
                <p class="fw-bolder">AI Text Detector ( <i class="fas fa-long-arrow-alt-down"></i> Scroll Down)</p>
                <p class="text-xs">Note: <span class="fw-bolder">Copy</span> the content from the document file and <span class="fw-bolder">Paste</span> it below or upload the file</p>
                <div class="ratio mt-4" style="--bs-aspect-ratio: 100%;">
                    <iframe class="rounded-3" src="https://www.zerogpt.com/"></iframe>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
