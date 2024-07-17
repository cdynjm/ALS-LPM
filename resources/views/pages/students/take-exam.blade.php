@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Take Exam'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
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
            <div class="col-md-1"></div>
            <div class="col-md-1"></div>
            
            <div class="col-md-10 mt-2">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="text-center m-4 fw-bolder">FUNCTIONAL LITERACY TEST (FLT)</h4>
                        <h5 class="text-center mt-2 fw-bolder">GENERAL DIRECTIONS</h5>
                        <p class="mt-4 mb-4">
                            The Functional Literacy Test consists mostly of Multiple Choice items. For each item
                            select your answer from the options given. On your answer sheet, SELECT the letter
                            of your chosen answer (Circle provided at the left side of each letter). For example, 
                            if your answer to an item is option C, then select the letter C.
                        </p>
                        <p class="mb-4 text-sm fw-bold">Follow carefully the specific directions for each test part, from LS1 to LS6. Make
                            sure that you use the answer sheet corresponding to the test part. When you finish
                            a part, go on to the next, until you finish the whole test. The time allowed for the
                            whole test is 1-1/2 hours. If you finish ahead of time, review your answers.
                        </p>
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-2 text-primary">Questions</h5>
                            </div>
                            
                        </div>
                        </div>
                    <div class="card-body pt-4 p-3">
                        <form action="" id="submit-exam">
                            <ul class="list-group">
                                @foreach ($subjects as $sj)   
                                    <h5 class="fw-bolder text-center">{{ $sj->subject }}</h5>
                                    @php
                                        $num = 1;
                                    @endphp
                                    @foreach ($exams as $ex)
                                        @if($ex->subjectID == $sj->id)
                                            <input type="hidden" name="questionID[]" class="form-control" value="{{ $aes->encrypt($ex->id) }}" readonly>
                                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-3 text-sm text-wrap">{{ $num }}. {{ $ex->question }}</h6>
                                                    @if(!empty($ex->Files->file))
                                                        <div class="text-center mb-2">
                                                            <img class="rounded img-fluid" src="{{ asset('storage/files/'.$ex->Files->file) }}" alt="">
                                                        </div>
                                                    @endif
                                                    @php
                                                        $letter = 'A';
                                                    @endphp
                                                    @foreach ($choices as $ch)
                                                        @if($ch->questionID == $ex->id)
                                                            <span class="mb-2 text-sm"><input type="radio" value="{{ $aes->encrypt($ch->id) }}" name="answer[{{ $ex->id }}]" required> {{ $letter }}.
                                                                <span class="text-dark font-weight-bold ms-sm-2">{{ $ch->choices }}</span>
                                                            </span>
                                                            @php
                                                                $letter ++;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </li>
                                            @php
                                                $num += 1;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" id="submit-btn" class="btn btn-sm bg-gradient-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-1"></div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection