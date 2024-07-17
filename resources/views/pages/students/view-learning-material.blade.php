@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'My Learning Material'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12 text-center mb-4">
                <p class="fw-bolder">{{ $learningMaterial->filename }}</p>
                <div class="ratio" style="--bs-aspect-ratio: 50%;">
                    <iframe class="rounded-3" src="{{ asset('storage/learning-materials/'.$learningMaterial->files) }}"></iframe>
                </div>
            </div>
            <div class="col-md-12">
                <p class="fw-bolder text-center">Submission</p>
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="text-sm mb-4">1. Create your activity here</h6>
                        
                        <form action="" id="upload-activity" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $aes->encrypt($learningMaterial->id) }}" name="id" id="id" class="form-control" readonly>
                            <textarea name="documentContent" id="editor"></textarea>
                            <div class="mt-2 text-xs text-danger">Note: Make sure to save your work as a draft before leaving. You may also submit after you're finished.</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-lg bg-gradient-success btn-lg w-100 mb-0 mt-4">Submit</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-lg bg-gradient-info btn-lg w-100 mb-0 mt-4" id="save-draft">Save as Draft</button>
                                </div>
                            </div>
                        </form>

                        <div class="mt-4">

                            <h6 class="text-sm mb-4">2. Or Upload your Activity File here (Optional)</h6>

                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <input type="file" class="form-control mb-4 d-none" id="file-input" multiple>
                                    <button type="button" class="btn btn-lg bg-gray-200 btn-lg w-100 mb-3" id="add-more-files"><i class="fas fa-cloud-upload-alt me-1"></i> Upload File</button>
                                    
                                    <form id="upload-form" class="mt-0" enctype="multipart/form-data">
                                      <ul id="file-list" class="list-unstyled"></ul>
                                      <div class="text-center">
                                        <button type="submit" class="btn btn-lg bg-gradient-danger btn-lg w-100 mb-0">Upload & Submit</button>
                                    </div>
                                    </form>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-sm mb-4">Your Submissions: </h6>
                                @include('data.activities-data')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-sm mb-4">Your Drafts: </h6>
                                <input type="hidden" class="form-control" id="draftID" value="0" readonly>
                                @include('data.drafts-data')
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                    CKEDITOR.replace('editor');
                </script>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
