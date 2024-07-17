<!-- The Modal -->
<div class="modal fade" id="createFileModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New File</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                        <form action="" id="create-file" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                   <label for="" class="mb-2">File</label>
                                   <input type="file" class="form-control" accept=".pdf, .docx, .pptx" name="file" required>
                                
                                   <label for="" class="mb-2">Filename</label>
                                   <input type="text" class="form-control" name="filename" required>
                                   
                                   <label for="" class="mb-2">Learning Strands</label>
                                   <select name="subject" class="form-select" id="" required>
                                       <option value="">Select...</option>
                                       @foreach ($subjects as $sj)
                                           <option value="{{ $aes->encrypt($sj->id) }}">{{ $sj->subject }}</option>
                                       @endforeach
                                   </select>

                                   <!-- <label for="" class="mb-2">Level</label>
                                   <select name="rating" class="form-select" id="" required>
                                       <option value="">Select...</option>
                                       <option value="{{ $aes->encrypt('1') }}">Basic Level </option>
                                       <option value="{{ $aes->encrypt('2') }}">Lower Elementary</option>
                                       <option value="{{ $aes->encrypt('3') }}">Advanced Elementary</option>
                                       <option value="{{ $aes->encrypt('4') }}">Junior HS (Elementary)</option>
                                       <option value="{{ $aes->encrypt('5') }}">Junior HS</option>
                                       <option value="{{ $aes->encrypt('6') }}">Senior HS</option>
                                    </select> -->

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
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-sm bg-gradient-primary">Upload</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> 