<!-- The Modal -->
<div class="modal fade" id="createScoreModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Score Activity</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                        <form action="" id="create-score" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="student-id" name="id" class="form-control" readonly>
                            <input type="hidden" id="score-id" name="scoreID" class="form-control" readonly>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Total Score</label>
                                    <input type="number" min="0" id="edit-score" class="form-control mb-2" name="score" required>

                                    <label for="">Total Items</label>
                                    <input type="number" min="0" id="edit-items" class="form-control mb-2" name="items" required>
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