<!-- Modal -->
<div class="modal fade" id="add-instructor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="user" id="instructor-form" action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="addInstructorModalLabel">Add New user</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title Instructor-info">User Information <span>
                              
                    </button>
                        </div>
                        <input type="hidden" name="instuctorid" id="instuctorid" value="0">
                        <input type="hidden" id="operation" name="operation" value="insert">
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>User Name <span class="login-danger">*</span></label>
                                <input class="form-control p-4" type="text" placeholder="Enter User Name" name="InstructorName" id="InstructorName">
                                <div class="error-message" id="InstructorName-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                        <div class="form-group local-forms">
                                <label>User Email <span class="login-danger">*</span></label>
                                <input class="form-control p-4" type="text" placeholder="Enter User Email" name="username" id="username">
                                <div class="error-message" id="Username-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                        <div class="form-group local-forms">
                                <label>Password <span class="login-danger">*</span></label>
                                <input class="form-control form-control-user p-4" type="password" placeholder="Enter password" name="password" id="password">
                                <div class="error-message" id="password-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                        <label>Role type <span class="login-danger">*</span></label>
                                <select class="form-control select" name="role" id="role">
                                    <option value="" disabled selected>Please Select Role</option>
                                    <?php foreach (read('role') as $role) { ?>
                                        <option value="<?= $role['id'] ?>">
                                            <?= readcolumn('role', 'role_name', $role['id']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_add_instructor" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="delete-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="category-form" action="" method="post">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Delete Instructor</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="instructorid" id="instructor_id">
                        <p class="lead">Are you sure to delete this Instructor?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_delete_instructor" class="btn btn-primary" value="Yes">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
      function handleForm(id) {
        $("#instuctorid").val(id);
        console.log(id);
        $("#addInstructorModalLabel").html("Update user");
        $("[name='btn_add_instructor']").val("Update");

        // Fetch student data
        $.ajax({
            method: "POST",
            url: "includes/ajaxReader.php",
            data: {
                table: "users",
                id: id
            }
        })
            .done((res) => {
                // console.log(res);
                var res = JSON.parse(res);
                // console.log(res);
                $("#InstructorName").val(res.name);
                $("#username").val(res.username);
                $("#password").val(res.password);
                $("#role").val(res.role_id);
                $('#operation').val('update');
                // console.log(document.getElementById('operation').value);
                
                $('#instuctorid').val(res.id);

            })
    }
       function clearForm() {
        $('#addCategoryModalLabel').html('Add New user');
        $("[name='btn_add_instructor']").val('Save');
        $('#InstructorName').val('')
        $('#username').val('')
        $('#password').val('')
        $("#role").val('');
        $('#operation').val('insert');
        $('#instuctorid').val(0);
    }
    // const Cat_Name = document.getElementById('Cat_Name');
    // const Cat_desc = document.getElementById('Cat_desc');
    // const Cat_image = document.getElementById('exampleInputCatImage');
    // console.log(Cat_Name);
    // console.log(Cat_desc);
    // console.log(Cat_image);

    function setIdToDelete(id) {
        $('#instructor_id').val(id);
    }

    document.getElementById('instructor-form').addEventListener('submit', function (event) {
        // event.preventDefault();
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        let isValid = true;

        // Validate Full Name
        const instructor_Name = document.getElementById('InstructorName').value;
        console.log(instructor_Name);
        if (instructor_Name.trim() === '') {
            isValid = false;
            document.getElementById('InstructorName-error').textContent = 'Instructor Name is required';
        }
        const username = document.getElementById('username').value;
        // console.log(Cat_desc);
        if (username.trim() === '') {
            isValid = false;
            document.getElementById('Username-error').textContent = 'username is required';
        }

        const password = document.getElementById('password').value;
        // console.log(Cat_desc);
        if (password.trim() === '') {
            isValid = false;
            document.getElementById('password-error').textContent = 'password is required';
        }

        // Validate image
        const Instructor_image = document.getElementById('exampleInputInstructorImage').value;
        // console.log(Cat_image);
        if (Instructor_image.trim() === '') {
            isValid = false;
            document.getElementById('Instructor_image-error').textContent = 'Instructor image is required';
        } 


        if (!isValid) {
            event.preventDefault();
        }
    });
</script>

<style>
    .error-message {
        color: red;
        font-size: 0.875em;
        margin-top: 5px;
    }
</style>