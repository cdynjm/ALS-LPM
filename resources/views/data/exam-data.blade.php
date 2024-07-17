<ul class="list-group" id="exam-data-result">
    @foreach ($subjects as $sj)   
        <h6 class="fw-bolder ms-2">{{ $sj->subject }}</h6>
        @php
            $num = 1;
        @endphp
        @foreach ($exams as $ex)
            @if($ex->subjectID == $sj->id)
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg" data-value="{{ $aes->encrypt($ex->id) }}">
                    <div class="d-flex flex-column">
                        <h6 style="white-space: pre-wrap" class="mb-3 text-sm text-wrap">{{ $num }}. {{ $ex->question }}</h6>
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
                                <span class="mb-2 text-sm @if($ch->correctAnswer == 1) fw-bolder text-success @endif"> {{ $letter }}.
                                    <span class="text-dark font-weight-bold ms-sm-2 @if($ch->correctAnswer == 1) text-decoration-underline @endif ">{{ $ch->choices }}</span>
                                </span>
                                @php
                                    $letter ++;
                                @endphp
                            @endif
                        @endforeach
                    </div>
                    <div class="ms-auto text-end">
                        <a class="btn btn-link text-danger text-gradient px-3 mb-0" id="delete-question" href="javascript:;"><i
                                class="far fa-trash-alt me-2"></i>Delete</a>
                        <!-- <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a> -->
                    </div>
                </li>
                @php
                    $num += 1;
                @endphp
            @endif
        @endforeach
    @endforeach
</ul>