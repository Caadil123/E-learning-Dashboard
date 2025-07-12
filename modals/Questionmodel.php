<!-- Modal -->
<div class="modal fade" id="add-question" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="question-form" action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="addSectionModalLabel">Add New Question</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title Section-info">Question Information <span>

                                    </button>
                        </div>
                        <input type="hidden" name="questionid" id="questionid" value="0">
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
                                <label>Quizz Name <span class="login-danger">*</span></label>
                                <select class="form-control select" name="Quizz" id="Quizz">
                                    <option value="" disabled selected>Please Select Quiz</option>
                                    <?php foreach (read('courses') as $courses) {
                                        if ($courses['Instructor_Id'] == $_SESSION['userId']) {
                                            ?>
                                            <?php foreach (read('sections') as $section) {
                                                if ($section['Course_ID'] == $courses['ID']) {
                                                    ?>
                                                    <?php foreach (read('quizzes') as $quizz) {
                                                        if ($quizz['section_id'] == $section['ID']) {
                                                            ?>
                                                            <option value="<?= $quizz['id'] ?>">
                                                                <?= readcolumn('quizzes', 'title', $quizz['id']) ?>
                                                            </option>
                                                        <?php }
                                                    } ?>
                                                <?php }
                                            } ?>
                                        <?php }
                                    } ?>
                                </select>
                                <div class="error-message" id="Quizz-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Question text <span class="login-danger">*</span></label>
                                <input class="form-control p-4" type="text" placeholder="Enter Question text"
                                    name="Questiontext" id="Questiontext">
                                <div class="error-message" id="Questiontext-error"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_add_question" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="delete-question" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="question-form" action="" method="post">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Delete question</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" name="questionid" id="question_id">
                        <p class="lead">Are you sure to delete this question?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_delete_question" class="btn btn-primary" value="Yes">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleForm(id) {
        $("#questionid").val(id);
        // console.log(id);
        $("#addSectionModalLabel").html("Update Question");
        $("[name='btn_add_question']").val("Update");

        // Fetch student data
        $.ajax({
            method: "POST",
            url: "includes/ajaxReader.php",
            data: {
                table: "questions",
                id: id
            }
        })
            .done((res) => {
                // console.log(res);
                var res = JSON.parse(res);
                // console.log(res);
                $("#Questiontext").val(res.question_text);
                $("#Quizz").val(res.quiz_id);
                $("#course_id").val(res.course_id);
                $('#operation').val('update');
                // console.log(document.getElementById('operation').value);

                $('#question_id').val(res.id);

            })
    }
    function clearForm() {
        $('#addSectionModalLabel').html('Add New Question');
        $("[name='btn_add_quizz']").val('Save');
        $("#Questiontext").val('')
        $("#Quizz").val('')
        $("#course_id").val('')
        $('#operation').val('insert');
        $('#questionid').val(0);
    }

    function setIdToDelete(id) {
        $('#question_id').val(id);
    }

    document.getElementById('question-form').addEventListener('submit', function (event) {
        // event.preventDefault();
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        let isValid = true;

        // Validate Full Name
        const QuestionText = document.getElementById('Questiontext').value;
        // console.log(instructor_Name);
        if (QuestionText.trim() === '') {
            isValid = false;
            document.getElementById('Questiontext-error').textContent = 'Question text is required';
        }
        const Quizz = document.getElementById('Quizz').value;
        // console.log(Cat_desc);
        if (Quizz.trim() === '') {
            isValid = false;
            document.getElementById('Quizz-error').textContent = 'Quizz is required';
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