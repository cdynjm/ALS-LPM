@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Sutdent Profile'])
    
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 text-center">
                        <div class="align-items-center">
                            <h5 class="fw-bolder"><i class="fa-solid fa-user-shield me-1"></i> Student Profile</h5> 
                            <p class="text-sm"></p>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4">
                        @foreach ($student as $student)
                            <div class="row">
                                <div class="col-md-6">

                                    <p>Personal Information</p>

                                    <label for="">Last Name</label>
                                    <input type="text" class="form-control bg-white" name="lastname" value="{{ $student->lastname }}" disabled>

                                    <label for="">First Name</label>
                                    <input type="text" class="form-control bg-white" name="firstname" value="{{ $student->firstname }}" disabled>

                                    <label for="">Middle Name</label>
                                    <input type="text" class="form-control bg-white" name="middlename" value="{{ $student->middlename }}" disabled>

                                    <label for="">Birth Date</label>
                                    <input type="text" class="form-control bg-white" name="birthdate" value="{{ date('F d, Y', strtotime($student->birthdate)) }}" disabled>

                                    <label for="">Place of Birth</label>
                                    <input type="text" class="form-control bg-white" name="birthplace" value="{{ $student->birthplace }}" disabled>

                                    <label for="">Highest Educational Attainment</label>
                                    <input type="text" class="form-control bg-white" name="education" value="{{ $student->education }}" disabled>

                                    <p class="mt-4">Address Information</p>

                                    <label for="">Street/Purok</label>
                                    <input type="text" class="form-control bg-white" name="street" value="{{ $student->street }}" disabled>

                                </div>
                                <div class="col-md-6">
                                    <label for="">Province</label>
                                    <input type="text" class="form-control bg-white" name="province" value="{{ ucwords(strtolower($student->Province->provDesc)) }}" disabled>

                                    <label for="select-municipal">Municipality</label>
                                    <input type="text" class="form-control bg-white" name="municipal" value="{{ ucwords(strtolower($student->Municipal->citymunDesc)) }}" disabled>

                                    <label for="">Barangay</label>
                                    <input type="text" class="form-control bg-white" name="barangay" value="{{ ucwords(strtolower($student->Barangay->brgyDesc)) }}" disabled>

                                    <label for="">Community Learning Center</label>
                                    <input type="text" class="form-control bg-white" name="clc" value="{{ $student->clc }}" disabled>

                                    <label for="">Divsion</label>
                                    <input type="text" class="form-control bg-white" name="division" value="{{ $student->division }}" disabled>

                                    <label for="">District</label>
                                    <input type="text" class="form-control bg-white" name="district" value="{{ $student->district }}" disabled>

                                    <label for="">Program Enrolled</label>
                                    <input type="text" class="form-control bg-white" name="program" value="{{ $student->Programs->program }}" disabled>
                                    
                                    <label for="">Teacher</label>
                                    <input type="text" class="form-control bg-white" name="teacher" value="{{ $student->Teachers->name }}" disabled>
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="fw-bolder mb-4">Learning Strands FLT Pre-Exam Results</h6>
                        @if(!empty($overallScore->studentID))
                            <h6>Overall Rating/Score: {{ $overallScore->score }}/{{ $overallScore->item }} | {{ $overallScore->rating }}%</h6>
                            <div class="progress">
                                <div class="progress-bar 
                                @if($overallScore->rating >= 75)
                                    bg-success
                                @endif
                                @if($overallScore->rating >= 50 && $overallScore->rating < 75)
                                    bg-orange
                                @endif
                                @if($overallScore->rating < 50)
                                    bg-danger
                                @endif
                                " role="progressbar" style="width: {{ $overallScore->rating }}%" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(!empty($overallScore->studentID))
                            <p>Learning Strands:</p>
                        @else
                            <p class="text-danger">Student have not taken the FLT Pre-Exam yet.</p>
                        @endif
                        @foreach ($subjectScore as $sc)
                            <span class="fw-bolder">{{ $sc->Subjects->subject }}</span>
                            <div class="mb-2 text-sm">Total Score: {{ $sc->score }}/{{ $sc->item }} | {{ $sc->rating }}%</div>
                            <div class="progress mb-4">
                                <div class="progress-bar 
                                @if($sc->rating >= 75)
                                    bg-success
                                @endif
                                @if($sc->rating >= 50 && $sc->rating < 75)
                                    bg-orange
                                @endif
                                @if($sc->rating < 50)
                                    bg-danger
                                @endif
                                " role="progressbar" style="width: {{ $sc->rating }}%" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @endforeach
                        <style>.bg-orange { background-color: orange !important; }</style>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="fw-bolder mb-4">Learning Strands FLT Post-Exam Results</h6>
                        @if(!empty($postOverallScore->studentID))
                            <h6>Overall Rating/Score: {{ $postOverallScore->score }}/{{ $postOverallScore->item }} | {{ $postOverallScore->rating }}%</h6>
                            <div class="progress">
                                <div class="progress-bar 
                                @if($postOverallScore->rating >= 75)
                                    bg-success
                                @endif
                                @if($postOverallScore->rating >= 50 && $postOverallScore->rating < 75)
                                    bg-orange
                                @endif
                                @if($postOverallScore->rating < 50)
                                    bg-danger
                                @endif
                                " role="progressbar" style="width: {{ $postOverallScore->rating }}%" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(!empty($postOverallScore->studentID))
                            <p>Learning Strands:</p>
                        @else
                            <p class="text-danger">Student have not taken the FLT Post-Exam yet.</p>
                        @endif
                        @foreach ($postSubjectScore as $sc)
                            <span class="fw-bolder">{{ $sc->Subjects->subject }}</span>
                            <div class="mb-2 text-sm">Total Score: {{ $sc->score }}/{{ $sc->item }} | {{ $sc->rating }}%</div>
                            <div class="progress mb-4">
                                <div class="progress-bar 
                                @if($sc->rating >= 75)
                                    bg-success
                                @endif
                                @if($sc->rating >= 50 && $sc->rating < 75)
                                    bg-orange
                                @endif
                                @if($sc->rating < 50)
                                    bg-danger
                                @endif
                                " role="progressbar" style="width: {{ $sc->rating }}%" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @endforeach
                        <style>.bg-orange { background-color: orange !important; }</style>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        @if(!empty($overallScore->studentID))

        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h6 class="mb-2 text-primary">FLT Pre-Exam Result</h6>
                            <input type="hidden" class="form-control" id="pre-id" value="{{ $aes->encrypt($overallScore->studentID) }}">
                            <a href="javascript:;" id="teacher-print-result" class="text-sm text-danger"><i class="fas fa-print me-1 text-sm"></i> Print Result</a>
                        </div>
                        <span>Score: {{ $overallScore->score }}/{{ $overallScore->item }} |<span class="fw-bolder ms-1">{{ $overallScore->rating }}%</span></span>
                    </div>
                    </div>
                <div class="card-body pt-4 p-3">
                    <ul class="list-group">
                    @foreach ($subjects as $sj)   
                        <h6 class="fw-bolder ms-2">{{ $sj->subject }}</h6>
                        @php
                            $num = 1;
                        @endphp
                        @foreach ($exams as $ex)
                            @if($ex->subjectID == $sj->id)
                                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-3 text-sm text-wrap">
                                                @if($ex->Answers->correctAnswer == 1)
                                                    <span class="me-2 fw-bolder text-success"><i class="fas fa-check text-lg"></i></span>
                                                @else
                                                    <span class="me-2 fw-bolder text-danger"><i class="fas fa-times text-lg"></i></span>
                                                @endif
                                                {{ $num }}. {{ $ex->question }}
                                            </h6>
                                            @if(!empty($ex->Files->file))
                                            <div class="text-center mb-2">
                                                <img class="rounded img-fluid" src="{{ asset('storage/files/'.$ex->Files->file) }}" alt="">
                                            </div>
                                            @endif
                                            @php
                                                $letter = 'A';
                                            @endphp
                                            @foreach ($choices as $ch)
                                                @if($ch->questionID == $ex->questionID)
                                                    <span class="mb-2 text-sm @if($ch->id == $ex->answerID) fw-bolder text-info @endif"> {{ $letter }}.
                                                        <span class="text-dark font-weight-bold ms-sm-2 @if($ch->id == $ex->answerID) text-decoration-underline @endif">{{ $ch->choices }}</span>
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
                </div>
            </div>
        </div>
       
        @endif

        @if(!empty($postOverallScore->studentID))
       
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h6 class="mb-2 text-primary">FLT Post-Exam Result</h6>
                            <input type="hidden" class="form-control" id="post-id" value="{{ $aes->encrypt($overallScore->studentID) }}">
                            <a href="javascript:;" id="teacher-print-post-result" class="text-sm text-danger"><i class="fas fa-print me-1 text-sm"></i> Print Result</a>
                        </div>
                        <span>Score: {{ $postOverallScore->score }}/{{ $postOverallScore->item }} |<span class="fw-bolder ms-1">{{ $postOverallScore->rating }}%</span></span>
                    </div>
                    </div>
                <div class="card-body pt-4 p-3">
                    <ul class="list-group">
                    @foreach ($subjects as $sj)   
                        <h6 class="fw-bolder ms-2">{{ $sj->subject }}</h6>
                        @php
                            $num = 1;
                        @endphp
                        @foreach ($postExams as $ex)
                            @if($ex->subjectID == $sj->id)
                                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-3 text-sm text-wrap">
                                                @if($ex->Answers->correctAnswer == 1)
                                                    <span class="me-2 fw-bolder text-success"><i class="fas fa-check text-lg"></i></span>
                                                @else
                                                    <span class="me-2 fw-bolder text-danger"><i class="fas fa-times text-lg"></i></span>
                                                @endif
                                                {{ $num }}. {{ $ex->question }}
                                            </h6>
                                            @if(!empty($ex->Files->file))
                                            <div class="text-center mb-2">
                                                <img class="rounded img-fluid" src="{{ asset('storage/files/'.$ex->Files->file) }}" alt="">
                                            </div>
                                            @endif
                                            @php
                                                $letter = 'A';
                                            @endphp
                                            @foreach ($choices as $ch)
                                                @if($ch->questionID == $ex->questionID)
                                                    <span class="mb-2 text-sm @if($ch->id == $ex->answerID) fw-bolder text-info @endif"> {{ $letter }}.
                                                        <span class="text-dark font-weight-bold ms-sm-2 @if($ch->id == $ex->answerID) text-decoration-underline @endif">{{ $ch->choices }}</span>
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
                </div>
            </div>
        </div>
       
        @endif
    </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection