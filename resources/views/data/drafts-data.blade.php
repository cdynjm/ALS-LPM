<div id="drafts-data-result">
    <ul class="list-unstyled">
    @php
        $count = false;
    @endphp
    @foreach ($drafts as $dr)
        @if($dr->studentID == Auth::user()->studentID)
            @if($dr->learningMaterialID == $learningMaterial->id)
                <li class="mb-4" data-value="{{ $aes->encrypt($dr->id) }}">
                    <i class="fas fa-file me-2"></i>
                    <a class="text-sm" href="javascript:;">{{ $dr->filename }}</a>
                    <div class="text-sm">Date Saved: {{ date('M. d, Y | h:i a', strtotime($dr->updated_at)) }}</div>
                    <div class="text-sm mt-2">
                        <a href="javascript:;" class="text-dark me-2" id="edit-draft"><i class="fa-solid fa-pen"></i> Edit Draft</a>
                        <a href="javascript:;" class="text-danger" id="delete-draft"><i class="fa-solid fa-xmark"></i> Remove</a>
                    </div>
                </li>
                @php
                    $count = true;
                @endphp
            @endif
        @endif
    @endforeach
    @if ($count == false)
        <span>No Drafts</span>
    @endif
    </ul>
</div>
