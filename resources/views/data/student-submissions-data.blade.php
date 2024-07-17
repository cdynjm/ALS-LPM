<table class="table align-items-center mb-0" id="student-submissions-data-result">
    <thead>
        <tr>
            
            <th width="5%" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                 File</th>
            <th
                class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Filename</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Competency</th> 
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Status</th> 
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
                <td colspan="5" class="fw-bolder text-info">{{ $sub->Subjects->subject }}</td>
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
                                            <td>
                                                <a href="{{ asset('storage/learning-materials/'.$lm->files) }}" target="_blank">
                                                <p class="text-sm font-weight-bold mb-0 ms-3 mt-1">{{ $lm->filename }}</p>
                                                </a>
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
                                            <td class="text-center">
                                                @php
                                                    $status = false;
                                                @endphp
                                                @foreach($activities as $act)
                                                    @if($act->studentID == $students->id)
                                                        @if($lm->id == $act->learningMaterialID)
                                                            @php
                                                                $status = true;
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
                                        </tr>
                                           
                                            @foreach ($activities as $act)
                                                @if($act->learningMaterialID == $lm->id && $act->studentID == $students->id)
                                                <tr>
                                                    <td colspan="4" 
                                                        
                                                        studentID="{{ $aes->encrypt($students->id) }}"
                                                        scoreID="{{ $aes->encrypt($act->id) }}"
                                                        score="{{ $act->score }}"
                                                        items="{{ $act->items }}"

                                                    >
                                                        <a href="javascript:;" id="add-score" class="ms-8 me-2"><i class="fas fa-marker"></i></a>
                                                        <a wire:navigate class="text-sm text-danger text-wrap" href="{{ route('student-activity', ['id' => $aes->encrypt($act->id)]) }}?{{ \Str::random(50) }}">
                                                            <i class="fas fa-file-signature me-1"></i>
                                                            {{ $act->filename }}
                                                        </a>
                                                        <span class="ms-2 text-xs">{{ date('F d, Y | h:i a', strtotime($act->created_at)) }}</span>
                                                        <span class="ms-2 text-sm fw-bolder">Score: {{ $act->score }} / {{ $act->items }}
                                                            @if($act->score == 0 && $act->items == 0)
                                                                <span class="badge bg-gradient-primary ms-1 text-capitalize">To Check</span>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                @php
                                                    $activityScore += $act->score;
                                                    $activityItems += $act->items;
                                                @endphp
                                                @endif
                                            @endforeach
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
                <td colspan="4" id="show-{{ $sub->Subjects->id }}"><span class="text-sm fw-bold"><i class="fas fa-star text-warning"></i> Total Score: {{ $activityScore }} / {{ $activityItems }}</span></td>
            </tr>
            @if($display == false) <style>#show-{{ $sub->Subjects->id }} { display: none; } </style>@endif
        @endforeach
    </tbody>
</table>