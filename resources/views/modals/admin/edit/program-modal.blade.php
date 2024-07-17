<!-- The Modal -->
<div class="modal fade" id="editProgramModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Program</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body" wire:ignore>  
                        <form action="" id="update-program" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">

                                    <input type="hidden" class="id form-control" name="id" readonly>

                                    <label for="">Program/Course Name</label>
                                    <input type="text" class="program form-control" name="program" required>
                                    
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-sm bg-gradient-primary">Update</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> 