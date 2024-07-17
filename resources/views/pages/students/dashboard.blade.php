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
            <div class="pre-overall-rating col-md-6 text-center">
                <label for="">Functional Literacy Test (FLT) Pre-Test Result</label>
            </div>
            <div class="post-overall-rating col-md-6 text-center">
                <label for="">Functional Literacy Test (FLT) Post-Test Result</label>
                @if(Auth::user()->Students->progress == 100)
                    @if($postOverallScore == null)
                    <div class="mt-4">
                        <a href="javascript:;" id="post-take-exams" class="btn bg-gradient-primary">Take Exam</a>
                        <p class="text-xs text-danger">
                            Note: You will be unable to access your dashboard during your FLT Post-Test.
                        </p>
                    </div>
                    @endif
                @else
                    <div class="mt-2 fs-3 text-danger">
                        <i class="fa-solid fa-eye-low-vision"></i>
                    </div>
                    <p class="text-sm text-danger mt-2">Please complete and submit all of the needed activities in your learning materials to take the Post Test.</p>
                @endif
            </div>
            <div class="col-md-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Learning Materials</p>
                                    <h5 class="font-weight-bolder fs-3">
                                        @php
                                            $learningMaterialsCount = 0;
                                            $learningMaterialCollect = collect();
                                        @endphp

                                        @foreach ($learningMaterials as $lm)
                                            @foreach($exams as $ex)
                                                @if($ex->subjectID == $lm->subjectID)
                                                    @if($lm->competency == $ex->competency)
                                                        @if(!$learningMaterialCollect->contains($lm->id))
                                                            @if($ex->Answers->correctAnswer == 0)
                                                                @php
                                                                    $learningMaterialsCount += 1;
                                                                    $learningMaterialCollect->push($lm->id);
                                                                @endphp
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach
                                        {{ $learningMaterialsCount }}
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
            <div class="col-md-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Submissions</p>
                                    <h5 class="font-weight-bolder fs-3">
                                        @php
                                            $countSubmission = 0;
                                        @endphp
                                        @foreach($activities as $act)
                                            @if($act->studentID == Auth::user()->studentID)
                                                @php
                                                    $countSubmission += 1;
                                                @endphp
                                            @endif
                                        @endforeach

                                        {{ $countSubmission }}
                                    </h5>
                                    <p class="mb-0 text-xs">
                                        Total Count
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-primary text-center rounded-circle">
                                    <i class="fas fa-file-signature opacity-10 text-lg"></i>
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
                            <h5 class="mb-2 text-sm text-danger">Learning Materials</h5>
                        </div>
                        <span class="d-inline">
                            <span class="text-sm"><i class="fas fa-star text-warning"></i> Total Score: </span> 
                            <span class="fw-bold">@livewire('fetch-student-score')</span>
                        </span>
                    </div>
                    </div>
                   
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th width="5%" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                             File</th>
                                        <th
                                             class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                             Competency</th>
                                        <th
                                            class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Filename</th>
                                        
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $learningMaterialCollect = collect();
                                        $competency = collect();
                                    @endphp
                                    @foreach ($subjectScore as $sub)

                                        @php 
                                            $display = false;
                                            $activityScore = 0;
                                            $activityItems = 0;
                                        @endphp
                                       
                                        <tr id="show-{{ $sub->Subjects->id }}">
                                            <td colspan="5" class="text-info fw-bolder">{{ $sub->Subjects->subject }}</td>
                                        </tr>
                                     
                                        @foreach ($learningMaterials as $lm)
                                            @if($sub->subjectID == $lm->subjectID)
                                                @foreach($exams as $ex)
                                                    @if($ex->subjectID == $lm->subjectID)
                                                        @if($lm->competency == $ex->competency)
                                                            @if(!$learningMaterialCollect->contains($lm->id))
                                                                @if($ex->Answers->correctAnswer == 0)
                                                                    <tr>
                                                                        <td class="text-center" id="{{ $aes->encrypt($lm->id) }}">
                                                                            <a class="text-lg text-center" href="{{ asset('storage/learning-materials/'.$lm->files) }}" target="_blank"><i class="fas fa-file-invoice"></i></a>
                                                                        </td>
                                                                        <td class="text-center"
                                                                            @foreach ($competencies as $com)
                                                                                @if($com->subjectID == $sub->Subjects->id && $com->code ==  $lm->competency)
                                                                                    subject="{{ $sub->Subjects->subject }}"
                                                                                    competency="{{ $com->description }}"
                                                                                    code="{{ $com->code }}"
                                                                                @endif
                                                                            @endforeach
                                                                        >
                                                                            <a href="javascript:;" id="show-competency" class="text-xs font-weight-bold mb-0 ms-3 mt-1">Competency {{ $lm->competency }}</a>
                                                                        </td>
                                                                        <td>
                                                                            <a wire:navigate href="{{ route('my-learning-material', ['id' => $aes->encrypt($lm->id)]) }}?key={{ \Str::random(50) }}">
                                                                            <p class="text-sm font-weight-bold mb-0 ms-3 mt-1">{{ $lm->filename }}</p>
                                                                            </a>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            @php
                                                                                $status = false;
                                                                            @endphp
                                                                            @foreach($activities as $act)
                                                                                @if($act->studentID == Auth::user()->studentID)
                                                                                    @if($lm->id == $act->learningMaterialID)
                                                                                        @php
                                                                                            $status = true;
                                                                                            $activityScore += $act->score;
                                                                                            $activityItems += $act->items;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach

                                                                            @if($status == true)
                                                                                <span class="badge bg-gradient-success">
                                                                                    <i class="fas fa-check-circle"></i>
                                                                                </span>
                                                                            @else
                                                                                <span class="badge bg-gradient-danger">
                                                                                    <i class="fa-solid fa-circle-minus"></i>
                                                                                </span>
                                                                            @endif      
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a wire:navigate href="{{ route('my-learning-material', ['id' => $aes->encrypt($lm->id)]) }}?key={{ \Str::random(50) }}" class="text-secondary font-weight-bold text-xs"
                                                                                data-toggle="tooltip">
                                                                                <i class="fas fa-eye text-sm"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    @php 
                                                                        $display = true;
                                                                        $learningMaterialCollect->push($lm->id);
                                                                    @endphp
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td colspan="5" id="show-{{ $sub->Subjects->id }}"><span class="text-sm fw-bold"><i class="fas fa-star text-warning"></i> Total Score: {{ $activityScore }} / {{ $activityItems }}</span></td>
                                        </tr>
                                        @if($display == false) <style>#show-{{ $sub->Subjects->id }} { display: none; } </style>@endif
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

@push('js')

    <script data-navigate-once>

        document.addEventListener('livewire:navigated', () => {

            
            const container = document.querySelector(".pre-overall-rating");
            const courses = [
                    { course: 'Overall Rating | Score: {{ $overallScore->score }}/{{ $overallScore->item }}', percent: Math.round({{ $overallScore->rating }}),
                            @if($overallScore->rating >= 75) color: "#78e08f" @endif 
                            @if($overallScore->rating >= 50 && $overallScore->rating < 75) color: "orange" @endif
                            @if($overallScore->rating < 50) color: "red" @endif
                    },
                ];

            courses.forEach((course) => {
            container.innerHTML += `
                    <center>
                        <div class="progess-group">
                            <div class="circular-progress" >
                                <span class="course-value text-lg text-secondary">0%</span>
                            </div>
                            <label class="text-sm mt-2">${course.course}</label>
                        </div>
                    </center>
            `;
            })

            const progressGroups = document.querySelectorAll(".progess-group");

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
                        progress.querySelector(".circular-progress").style.background = `
                        conic-gradient(${courses[index].color} ${3.6 * progressStartValue}deg, #fff 0deg)`;

                        progress.querySelector(".course-value").innerHTML = progressStartValue + "%";
                    }, speed);
                }
            });


            @if($postOverallScore != null)
                const postContainer = document.querySelector(".post-overall-rating");
                const postCourses = [
                        { course: 'Overall Rating | Score: {{ $postOverallScore->score }}/{{ $postOverallScore->item }}', percent: Math.round({{ $postOverallScore->rating }}),
                                @if($postOverallScore->rating >= 75) color: "#78e08f" @endif 
                                @if($postOverallScore->rating >= 50 && $postOverallScore->rating < 75) color: "orange" @endif
                                @if($postOverallScore->rating < 50) color: "red" @endif
                        },
                    ];

                postCourses.forEach((course) => {
                postContainer.innerHTML += `
                        <center>
                            <div class="post-progess-group">
                                <div class="post-circular-progress" >
                                    <span class="post-course-value text-lg text-secondary">0%</span>
                                </div>
                                <label class="text-sm mt-2">${course.course}</label>
                            </div>
                        </center>
                `;
                })

                const postProgressGroups = document.querySelectorAll(".post-progess-group");

                postProgressGroups.forEach((progress, index) => {
                    if(postCourses[index].percent != 0) {
                        let progressStartValue = 0;
                        let progressStartEnd = postCourses[index].percent;
                        let speed =20;
                        let progessTimer = setInterval(() => {
                            progressStartValue++;
                            if (progressStartValue == progressStartEnd) {
                                clearInterval(progessTimer);
                            }
                            progress.querySelector(".post-circular-progress").style.background = `
                            conic-gradient(${postCourses[index].color} ${3.6 * progressStartValue}deg, #fff 0deg)`;

                            progress.querySelector(".post-course-value").innerHTML = progressStartValue + "%";
                        }, speed);
                    }
                });
            @endif
        });
    </script>

    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
@endpush
