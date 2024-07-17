<!-- The Modal -->
<div class="modal fade" id="createTeacherModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Teacher</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                        <form action="" id="create-teacher" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-sm">Personal Information</p>

                                    <label for="">Full Name</label>
                                    <input type="text" class="form-control" name="fullName" required>

                                    <label for="">Poistion/Rank</label>
                                    <input type="text" class="form-control" name="position" required>

                                    <label for="">Date Employed</label>
                                    <input type="date" class="form-control" name="dateEmployed" required>

                                    <label for="">Address</label>
                                    <input type="text" class="form-control" name="address" required>

                                    <label for="">Contact Number</label>
                                    <input type="text" class="form-control" name="contactNumber" required>

                                    <p class="text-sm mt-4">Account Information</p>

                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email" required>

                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-sm bg-gradient-primary">Create Account</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div> 