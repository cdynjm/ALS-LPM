<table class="table align-items-center mb-0" id="teacher-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Name</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                Position/Rank</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Address</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Date Employed</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($teachers as $tc)
        <tr>

            <td 
                id="{{ $aes->encrypt($tc->id) }}" 
                name="{{ $tc->name }}" 
                address="{{ $tc->address }}" 
                position="{{ $tc->position }}" 
                contactNumber="{{ $tc->contactNumber }}"
                dateEmployed="{{ $tc->dateEmployed }}"
                email="{{ $tc->User->email }}" 
            >
                <div class="d-flex px-2 py-1">
                    <div>
                        <img src="https://cdn-icons-png.flaticon.com/512/9131/9131529.png" class="avatar avatar-sm me-3"
                            alt="user1">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{ $tc->name }}</h6>
                        <p class="text-xs text-secondary mb-0">{{ $tc->User->email }}</p>
                    </div>
                </div>
            </td>
            <td>
                <p class="text-xs font-weight-bold mb-0">{{ $tc->position }}</p>
            </td>
            <td class="align-middle text-center text-sm">
                <p class="text-xs font-weight-bold mb-0">{{ $tc->address }}</p>
            </td>
            <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{ date('F d, Y', strtotime($tc->dateEmployed)) }}</span>
            </td>
            <td class="text-center">
                <a href="javascript:;" id="edit-teacher" class="text-secondary font-weight-bold text-xs me-2"
                    data-toggle="tooltip">
                    <i class="fas fa-pen-alt text-sm"></i>
                </a>
                <a href="javascript:;" id="delete-teacher" class="text-secondary font-weight-bold text-xs"
                    data-toggle="tooltip">
                    <i class="fas fa-trash-alt text-sm"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>