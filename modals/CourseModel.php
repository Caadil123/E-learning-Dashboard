<!-- Modal -->
<div class="modal fade" id="add-course" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="Course-form" action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="addCourseModalLabel">Add New Course</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title Instructor-info">Course Information <span>

                                    </button>
                        </div>
                        <input type="hidden" name="courseid" id="course_id" value="0">
                        <input type="hidden" id="operation" name="operation" value="insert">
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Course Name <span class="login-danger">*</span></label>
                                <input class="form-control p-4" type="text" placeholder="Enter Course Name"
                                    name="CourseName" id="CourseName">
                                <div class="error-message" id="CourseName-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                            <label>Category type <span class="login-danger">*</span></label>
                                <select class="form-control select" name="category" id="category">
                                    <option value="" disabled selected>Please Select Category</option>
                                    <?php foreach (read('categories') as $category) { ?>
                                        <option value="<?= $category['ID'] ?>">
                                            <?= readcolumn('categories', 'Cat_name', $category['ID']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="error-message" id="category-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                            <label>instructor Name <span class="login-danger">*</span></label>
                                <select class="form-control select" name="instructor" id="instructor">
                                    <option value="" disabled selected>Please Select Instructor</option>
                                    <?php foreach (getInstructor() as $instructor) { ?>
                                        <option value="<?= $instructor['id'] ?>">
                                            <?= readcolumn('users', 'name', $instructor['id']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="error-message" id="instructor-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Describtion <span class="login-danger">*</span></label>
                                <textarea class="form-control" name="describtion" id="describtion" rows="3"></textarea>
                                <div class="error-message" id="describtion-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Duration <span class="login-danger">*</span></label>
                                <select class="form-control select" name="duration" id="duration">
                                    <option value="" disabled selected>Please Select course duration</option>
                                    <option value="2 weeks">2 weeks</option>
                                    <option value="4 weeks">4 weeks</option>
                                    <option value="6 weeks">6 weeks</option>
                                    <option value="8 weeks">8 weeks</option>
                                </select>
                                <div class="error-message" id="Duration-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Course Level <span class="login-danger">*</span></label>
                                <select class="form-control select" name="level" id="level">
                                    <option value="" disabled selected>Please Select course level</option>
                                    <option value="Begginner">Begginner</option>
                                    <option value="intermediate">intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                </select>
                                <div class="error-message" id="Level-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label for="exampleInputCourseImage" class="form-label">Course Image</label>
                                <input type="file" class="form-control p-4" name="Course_image"
                                    id="exampleInputCourseImage" accept="image/jpeg, image/png, image/jpg, image/webp">
                                <div class="error-message" id="Course_image-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <img id="CourseDisplay" src="" style="width: 150px; height: 150px; border-radius:50%"
                                alt="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_add_course" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="delete-course" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="course-form" action="" method="post">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Delete course</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="courseid" id="courseid">
                        <p class="lead">Are you sure to delete this course?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_delete_course" class="btn btn-primary" value="Yes">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleForm(id) {
        $("#course_id").val(id);
        console.log(id);
        $("#addCourseModalLabel").html("Update Course");
        $("[name='btn_add_course']").val("Update");

        // Fetch student data
        $.ajax({
            method: "POST",
            url: "includes/ajaxReader.php",
            data: {
                table: "courses",
                id: id
            }
        })
            .done((res) => {
                // console.log(res);
                var res = JSON.parse(res);
                console.log(res);
                $("#CourseName").val(res.Course_name);
                $("#duration").val(res.Duration);
                $("#level").val(res.Level);
                $("#category").val(res.Category_ID);
                $("#instructor").val(res.Instructor_Id);
                $("#describtion").val(res.describtion);
                $('#CourseDisplay').attr('src', res.Course_image);
                $('#operation').val('update');
                console.log(document.getElementById('operation').value);
                $('#courseid').val(res.Course_ID);

            })
    }
    function clearForm() {
        $('#addCourseModalLabel').html('Add New Course');
        $("[name='btn_add_course']").val('Save');
        $('#CourseName').val('')
        $('#duration').val('')
        $('#level').val('')
        $('#category').val('')
        $('#instructor').val('')
        $('#describtion').val('')
        $('#operation').val('insert');
        $('#courseid').val(0);
    }
    // const Cat_Name = document.getElementById('Cat_Name');
    // const Cat_desc = document.getElementById('Cat_desc');
    // const Cat_image = document.getElementById('exampleInputCatImage');
    // console.log(Cat_Name);
    // console.log(Cat_desc);
    // console.log(Cat_image);

    function setIdToDelete(id) {
        $('#courseid').val(id);
    }

    document.getElementById('Course-form').addEventListener('submit', function (event) {
        // event.preventDefault();
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        let isValid = true;

        // Validate Full Name
        const Course_name = document.getElementById('CourseName').value;
        // console.log(Course_name);
        if (Course_name.trim() === '') {
            isValid = false;
            document.getElementById('CourseName-error').textContent = 'Course Name is required';
        }
        const Duration = document.getElementById('duration').value;
        // console.log(Cat_desc);
        if (Duration.trim() === '') {
            isValid = false;
            document.getElementById('Duration-error').textContent = 'Duration is required';
        }
        const Level = document.getElementById('level').value;
        // console.log(Cat_desc);
        if (Level.trim() === '') {
            isValid = false;
            document.getElementById('Level-error').textContent = 'Level is required';
        }
        const category = document.getElementById('category').value;
        // console.log(Cat_desc);
        if (category.trim() === '') {
            isValid = false;
            document.getElementById('category-error').textContent = 'category is required';
        }
        const instructor = document.getElementById('instructor').value;
        // console.log(Cat_desc);
        if (instructor.trim() === '') {
            isValid = false;
            document.getElementById('instructor-error').textContent = 'instructor is required';
        }
        const describtion = document.getElementById('describtion').value;
        // console.log(Cat_desc);
        if (describtion.trim() === '') {
            isValid = false;
            document.getElementById('describtion-error').textContent = 'describtion is required';
        }

        // Validate Phone
        const Course_image = document.getElementById('exampleInputCourseImage').value;
        // console.log(Cat_image);
        if (Course_image.trim() === '') {
            isValid = false;
            document.getElementById('Course_image-error').textContent = 'Course_image number is required';
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