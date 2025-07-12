<!-- Modal -->
<div class="modal fade" id="add-quizz" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="user" id="quizz-form" action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="addInstructorModalLabel">Add New Quiz</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title Instructor-info">Quiz Information <span>

                                    </button>
                        </div>
                        <input type="hidden" name="quizzId" id="quizzId" value="0">
                        <input type="hidden" id="operation" name="operation" value="insert">

                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Course Name <span class="login-danger">*</span></label>
                                <select class="form-control select" name="course" id="course_id">
                                    <option value="" disabled selected>Please Select Course</option>
                                    <?php foreach (read('courses') as $courses) {
                                        if ($courses['Instructor_Id'] == $_SESSION['userId']) {
                                            ?>
                                                    <option value="<?= $courses['ID'] ?>">
                                                        <?= readcolumn('courses', 'Course_name', $courses['ID']) ?>
                                                    </option>
                                        <?php }
                                    } ?>
                                </select>
                                <div class="error-message" id="course-error"></div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Section Name <span class="login-danger">*</span></label>
                                <select class="form-control select" name="Section" id="section_id">
                                    <option value="" disabled selected>Please Select Section</option>
                                    <?php foreach (read('courses') as $courses) {
                                        if ($courses['Instructor_Id'] == $_SESSION['userId']) {
                                            ?>
                                            <?php foreach (read('sections') as $section) {
                                                if ($section['Course_ID'] == $courses['ID']) {
                                                    ?>
                                                    <option value="<?= $section['ID'] ?>">
                                                        <?= readcolumn('sections', 'Section_name', $section['ID']) ?>
                                                    </option>
                                                <?php }
                                            } ?>
                                        <?php }
                                    } ?>
                                </select>
                                <div class="error-message" id="section-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Title <span class="login-danger">*</span></label>
                                <input class="form-control form-control-user p-4" placeholder="Enter title" name="title"
                                    id="title">
                                <div class="error-message" id="title-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Describtion <span class="login-danger">*</span></label>
                                <textarea class="form-control form-control-user p-4" placeholder="Enter Describtion"
                                    name="describtion" id="describtion">
                                </textarea>
                                <div class="error-message" id="describtion-error"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_add_quizz" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="delete-quizz" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="quiz-form" action="" method="post">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Delete Instructor</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="quizzId" id="quizz_Id">
                        <p class="lead">Are you sure to delete this quizz?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_delete_quizz" class="btn btn-primary" value="Yes">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleForm(id) {
        $("#quizzId").val(id);
        console.log(id);
        $("#addInstructorModalLabel").html("Update Quizz");
        $("[name='btn_add_quizz']").val("Update");

        // Fetch student data
        $.ajax({
            method: "POST",
            url: "includes/ajaxReader.php",
            data: {
                table: "quizzes",
                id: id
            }
        })
            .done((res) => {
                // console.log(res);
                var res = JSON.parse(res);
                // console.log(res);
                $("#title").val(res.title);
                $("#describtion").val(res.description);
                $("#section_id").val(res.section_id);
                $("#course_id").val(res.course_id);
                $('#operation').val('update');
                // console.log(document.getElementById('operation').value);

                $('#quizzId').val(res.id);

            })
    }
    function clearForm() {
        $('#addCategoryModalLabel').html('Add New Quizz');
        $("[name='btn_add_quizz']").val('Save');
        $('#title').val('')
        $('#username').val('')
        $('#describtion').val('')
        $('#operation').val('insert');
        $('#quizzId').val(0);
    }
    // const Cat_Name = document.getElementById('Cat_Name');
    // const Cat_desc = document.getElementById('Cat_desc');
    // const Cat_image = document.getElementById('exampleInputCatImage');
    // console.log(Cat_Name);
    // console.log(Cat_desc);
    // console.log(Cat_image);

    function setIdToDelete(id) {
        $('#quizz_Id').val(id);
    }

    document.getElementById('quizz-form').addEventListener('submit', function (event) {
        // event.preventDefault();
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        let isValid = true;

        // Validate Full Name
        const title = document.getElementById('title').value;
        // console.log(instructor_Name);
        if (title.trim() === '') {
            isValid = false;
            document.getElementById('title-error').textContent = 'title is required';
        }
        const describtion = document.getElementById('describtion').value;
        // console.log(Cat_desc);
        if (describtion.trim() === '') {
            isValid = false;
            document.getElementById('describtion-error').textContent = 'describtion is required';
        }

        const section = document.getElementById('section_id').value;
        // console.log(Cat_desc);
        if (section.trim() === '') {
            isValid = false;
            document.getElementById('section-error').textContent = 'section is required';
        }

        const course = document.getElementById('course_id').value;
        // console.log(Cat_desc);
        if (course.trim() === '') {
            isValid = false;
            document.getElementById('course-error').textContent = 'course is required';
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