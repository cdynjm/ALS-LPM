<table class="table align-items-center mb-0" id="competency-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Learning Strands Comptencies</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Action</th>
        </tr>
    </thead>
    <tbody>
       @foreach ($subjects as $sj)
           <tr>
                <td colspan="3"><p class="text-xs font-weight-bolder mb-0 ms-3 mt-1"> {{ $sj->subject }}</p></td>
           </tr>
            @foreach ($competencies as $com)
                @if($com->subjectID == $sj->id)
                <tr>
                    <td><p class="text-sm mb-0 ms-6 mt-1 text-wrap">{{ $com->code }}. {{ $com->description }}</p></td>
                    <td></td>
                </tr>
                @endif
            @endforeach
       @endforeach
    </tbody>
</table>