<!-- The Modal -->
<div class="modal fade" id="editTeacherModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Teacher</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                        <form action="" id="update-teacher" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-sm">Personal Information</p>

                                    <input type="hidden" class="id form-control" name="id" readonly>

                                    <label for="">Full Name</label>
                                    <input type="text" class="name form-control" name="fullName" required>

                                    <label for="">Poistion/Rank</label>
                                    <input type="text" class="position form-control" name="position" required>

                                    <label for="">Date Employed</label>
                                    <input type="date" class="dateEmployed form-control" name="dateEmployed" required>

                                    <label for="">Address</label>
                                    <input type="text" class="address form-control" name="address" required>

                                    <label for="">Contact Number</label>
                                    <input type="text" class="contactNumber form-control" name="contactNumber" required>

                                    <p class="text-sm mt-4">Account Information</p>

                                    <label for="">Email</label>
                                    <input type="email" class="email form-control" name="email" required>

                                    <label for="">Change Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-sm bg-gradient-primary">Update Account</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> 