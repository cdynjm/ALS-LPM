<div id="activities-data-result">
    <ul class="list-unstyled">
    @php
        $count = false;
    @endphp
    @foreach ($activities as $act)
        @if($act->studentID == Auth::user()->studentID)
            @if($act->learningMaterialID == $learningMaterial->id)
                <li class="mb-4" data-value="{{ $aes->encrypt($act->id) }}">
                    <i class="fas fa-file me-2"></i>
                    <a class="text-sm" href="{{ asset('storage/activities/'.$act->filename) }}" target="_blank">{{ $act->filename }}</a>
                    <div class="text-sm">Date Submitted: {{ date('M. d, Y | h:i a', strtotime($act->created_at)) }}</div>
                    <div class="text-sm fw-bolder">Score: {{ $act->score }} / {{ $act->items }}</div>
                    @if($act->score == 0 && $act->items == 0) 
                        <div class="text-sm mt-2"><a href="javascript:;" class="text-danger" id="delete-activity"><i class="fas fa-times"></i> Remove</a></div>
                    @else
                    <div class="text-sm mt-2 text-success">Recorded</div>
                    @endif
                </li>
                @php
                    $count = true;
                @endphp
            @endif
        @endif
    @endforeach
    @if ($count == false)
        <span>No Submissions Yet</span>
    @endif
    </ul>
</div>
