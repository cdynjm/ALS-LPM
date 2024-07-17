<table class="table align-items-center mb-0" id="learning-materials-data-result">
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
                Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subjects as $sub)
        <tr>
            <td colspan="4" class="text-info fw-bolder">{{ $sub->subject }}</td>
        </tr>
        @foreach ($learningMaterials as $lm) 
            @if($lm->subjectID == $sub->id)
            <tr>
                <td class="text-center" id="{{ $aes->encrypt($lm->id) }}">
                    <a class="text-lg text-center" href="{{ asset('storage/learning-materials/'.$lm->files) }}" target="_blank"><i class="fas fa-file-invoice"></i></a>
                </td>
                <td>
                    <a href="{{ asset('storage/learning-materials/'.$lm->files) }}" target="_blank">
                    <p class="text-sm font-weight-bold mb-0 ms-3 mt-1">{{ $lm->filename }}</p>
                    </a>
                </td>
                <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0 ms-3 mt-1">Competency {{ $lm->competency }}</p>
                </td>
                <td class="text-center">
                    <a href="javascript:;" id="delete-file" class="text-secondary font-weight-bold text-xs"
                        data-toggle="tooltip">
                        <i class="fas fa-trash-alt text-sm"></i>
                    </a>
                </td>
            </tr>
            @endif
        @endforeach
    @endforeach
    </tbody>
</table>