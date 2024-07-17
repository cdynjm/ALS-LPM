<table class="table align-items-center mb-0" id="subject-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Subject Name</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subjects as $sj)
        <tr>
            <td 
            id="{{ $aes->encrypt($sj->id) }}"
            subject="{{ $sj->subject }}"
            >
                <p class="text-xs font-weight-bold mb-0  ms-3">{{ $sj->subject }}</p>
            </td>
            <td class="text-center">
                <a href="javascript:;" id="edit-subject" class="text-secondary font-weight-bold text-xs me-2"
                    data-toggle="tooltip">
                    <i class="fas fa-pen-alt text-sm"></i>
                </a>
                <a href="javascript:;" id="delete-subject" class="text-secondary font-weight-bold text-xs"
                    data-toggle="tooltip">
                    <i class="fas fa-trash-alt text-sm"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>