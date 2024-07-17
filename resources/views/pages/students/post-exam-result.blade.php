@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Post-Exam Result'])
    
    <div class="container-fluid py-4">
        <p class="fw-bolder">Learning Strands</p>
        <div class="post-exam-result row text-center overflow-hidden"></div>
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h6 class="mb-2 text-primary">Functional Literacy Test (FLT) Result</h6>
                                <a href="javascript:;" id="print-post-result" class="text-sm text-danger"><i class="fas fa-print me-1 text-sm"></i> Print Result</a>
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
       
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')

<script data-navigate-once>
    
    document.addEventListener('livewire:navigated', () => {

        const container = document.querySelector(".post-exam-result");
        const courses = [
            @foreach($subjectScore as $sc)
                { course: '{{ $sc->Subjects->subject }} <br> {{ $sc->score }}/{{ $sc->item }}', percent: Math.round({{ $sc->rating }}), 
                        @if($sc->rating >= 75) color: "#78e08f" @endif 
                        @if($sc->rating >= 50 && $sc->rating < 75) color: "orange" @endif
                        @if($sc->rating < 50) color: "red" @endif
                },
            @endforeach
                { course: 'Overall Rating | {{ $overallScore->score }}/{{ $overallScore->item }}', percent: Math.round({{ $overallScore->rating }}),
                        @if($overallScore->rating >= 75) color: "#78e08f" @endif 
                        @if($overallScore->rating >= 50 && $overallScore->rating < 75) color: "orange" @endif
                        @if($overallScore->rating < 50) color: "red" @endif
                },
            ];

        courses.forEach((course) => {
        container.innerHTML += `
            <div class="col-md-4">
                <div class="post-progess-group">
                    <div class="post-circular-progress" >
                        <span class="post-course-value text-lg text-secondary">0%</span>
                    </div>
                    <label class="text-sm mt-2">${course.course}</label>
                </div>
            </div>
        `;
        })

        const progressGroups = document.querySelectorAll(".post-progess-group");

        progressGroups.forEach((progress, index) => {
            if(courses[index].percent != 0) {
                let progressStartValue = 0;
                let progressStartEnd = courses[index].percent;
                let speed =20;
                let progessTimer = setInterval(() => {
                    progressStartValue++;
                    if (progressStartValue == progressStartEnd) {
                        clearInterval(progessTimer);
                    }
                    progress.querySelector(".post-circular-progress").style.background = `
                    conic-gradient(${courses[index].color} ${3.6 * progressStartValue}deg, #fff 0deg)`;

                    progress.querySelector(".post-course-value").innerHTML = progressStartValue + "%";
                }, speed);
            }
        });
    });
</script>

@endpush