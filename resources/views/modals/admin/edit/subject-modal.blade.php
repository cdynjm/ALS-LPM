<!-- The Modal -->
<div class="modal fade" id="editSubjectModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Learning Strand</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                        <form action="" id="update-subject" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">

                                    <input type="hidden" class="id form-control" name="id" readonly>

                                    <label for="">Name</label>
                                    <input type="text" class="subject form-control" name="subject" required>
                                    
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