@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.admin.subject-modal')
@extends('modals.admin.edit.subject-modal')
@extends('modals.admin.competency-modal')
@extends('modals.admin.edit.competency-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Learning Strands'])
    
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mb-2">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-2 text-sm text-primary">Learning Strands</h5>
                        </div>
                        <button class="btn btn-sm bg-gradient-secondary" id="add-subject">+ Add</button>
                    </div>
                    </div>
                   
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            @include('data.subject-data')
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-2">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-2 text-sm text-primary">Competencies</h5>
                        </div>
                        <button class="btn btn-sm bg-gradient-secondary" id="add-competency">+ Add</button>
                    </div>
                    </div>
                   
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            @include('data.competency-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
