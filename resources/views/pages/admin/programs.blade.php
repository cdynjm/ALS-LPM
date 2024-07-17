@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.admin.program-modal')
@extends('modals.admin.edit.program-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Programs'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-2 text-sm text-primary">List of Programs</h5>
                        </div>
                        <button class="btn btn-sm bg-gradient-secondary" id="add-program">+ Add</button>
                    </div>
                    </div>
                   
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4" wire:ignore>
                            @include('data.program-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
