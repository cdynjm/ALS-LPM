<!-- The Modal -->
<div class="modal fade" id="createQuestionModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Question</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                        <form action="" id="create-question" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Question</label>
                                    <textarea name="question" id="" class="form-control" placeholder="Please fill in..." cols="30" rows="5" required></textarea>
                                    
                                    <label for="" class="mt-2">Choose File (Optional)</label>
                                    <input type="file" class="form-control" name="file">

                                    <label for="" class="mt-2">Subject Related/Category</label>
                                    <select name="subject" class="form-select" id="" required>
                                        <option value="">Select...</option>
                                        @foreach ($subjects as $sj)
                                            <option value="{{ $aes->encrypt($sj->id) }}">{{ $sj->subject }}</option>
                                        @endforeach
                                    </select>

                                    <label for="">Competency</label>
                                    <select name="competency" id="" class="form-select" required>
                                        @php
                                            $competency = range(1,15);
                                        @endphp
                                        <option value="">Select...</option>
                                        @foreach ($competency as $comp)
                                            <option value="{{ $aes->encrypt($comp) }}">{{ $comp }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <label for="" class="mt-4">Choices</label>
                                    <button type="button" class="btn btn-sm bg-gradient-info mt-3 ms-2" id="add-choice" data-increment="0"><i class="fas fa-plus"></i></button>
                                    <button class="btn bg-gradient-danger btn-sm mt-3" id="del-choice" type="button" style="display: none;"><i class="fas fa-trash"></i></button>
                                    <div id="new-choices"></div>
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