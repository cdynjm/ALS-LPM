<!-- The Modal -->
<div class="modal fade" id="createCompetencyModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Competency</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body" wire:ignore>  
                        <form action="" id="create-competency" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Code</label>
                                    <select name="code" id="" class="form-select" required>
                                        @php
                                            $competency = range(1,15);
                                        @endphp
                                        <option value="">Select...</option>
                                        @foreach ($competency as $comp)
                                            <option value="{{ $aes->encrypt($comp) }}">{{ $comp }}</option>
                                        @endforeach
                                    </select>
                                    <label for="">Competency Name</label>
                                    <textarea name="competency" id="" cols="30" rows="5" class="form-control" required></textarea>
                                    <label for="">Learning Strand</label>
                                    <select name="subject" class="form-select" id="" required>
                                        <option value="">Select...</option>
                                        @foreach ($subjects as $sj)
                                            <option value="{{ $aes->encrypt($sj->id) }}">{{ $sj->subject }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-sm bg-gradient-primary">Create</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> 