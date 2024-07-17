<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fas fa-book text-lg"></i>
    </a>

    <div class="card shadow-lg overflow-auto">
        <div class="card-header pb-0 pt-3">
            <div class="float-end mt-1">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <h6>Learning Strands Competencies</h6>
            <div class="mt-4">
                @foreach ($learningStrandsPlugin as $ls)
                    <div class="mt-4">
                    <p class="text-sm fw-bolder mt-4 text-decoration-underline">{{ $ls->subject }}</p>
                    @foreach ($comptenciesPlugin as $com)
                        @if($com->subjectID == $ls->id)
                        <p class="text-sm  mb-2 ms-2 mt-1">{{ $com->code }}. {{ $com->description }}</p>   
                        @endif
                    @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>