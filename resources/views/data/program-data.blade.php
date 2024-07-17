
<table class="table align-items-center mb-0" id="program-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Program Name</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($programs as $pr)
            <tr>
                <td
                    id="{{ $aes->encrypt($pr->id) }}"
                    program="{{ $pr->program }}"
                >
                    <p class="text-xs font-weight-bold mb-0  ms-3">{{ $pr->program }}</p>
                </td>
                <td class="text-center">
                    <a href="javascript:;" id="edit-program" class="text-secondary font-weight-bold text-xs me-2"
                        data-toggle="tooltip">
                        <i class="fas fa-pen-alt text-sm"></i>
                    </a>
                    <a href="javascript:;" id="delete-program" class="text-secondary font-weight-bold text-xs"
                        data-toggle="tooltip">
                        <i class="fas fa-trash-alt text-sm"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>