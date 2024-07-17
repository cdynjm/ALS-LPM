<!-- The Modal -->
<div class="modal fade" id="createProgramModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Program</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                        <form action="" id="create-program" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">

                                    <label for="">Program/Course Name</label>
                                    <input type="text" class="form-control" name="program" required>
                                    
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
