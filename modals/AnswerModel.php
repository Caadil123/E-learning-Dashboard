<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="add-answer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="answer-form" action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="addAnswerModalLabel">Add New Answer</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title Answers-info">Answers Information</h5>
                        </div>
                        <input type="hidden" name="answerid" id="answerid" value="0">
                        <input type="hidden" id="operation" name="operation" value="insert">

                        <!-- Course name -->
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

                        <!-- Question Text -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Question Text <span class="login-danger">*</span></label>
                                <select class="form-control select" name="Questiontext" id="Questiontext">
                                    <option value="" disabled selected>Please Select Questions</option>
                                    <?php foreach (read('courses') as $courses) {
                                        if ($courses['Instructor_Id'] == $_SESSION['userId']) {
                                            ?>
                                            <?php foreach (read('sections') as $section) {
                                                if ($section['Course_ID'] == $courses['ID']) {
                                                    ?>
                                                    <?php foreach (read('quizzes') as $quizz) {
                                                        if ($quizz['section_id'] == $section['ID']) {
                                                            ?>
                                                            <?php foreach (read('questions') as $question) {
                                                                if ($question['quiz_id'] == $quizz['id']) {
                                                                    ?>
                                                                    <option value="<?= $question['id'] ?>">
                                                                        <?= readcolumn('questions', 'question_text', $question['id']) ?>
                                                                    </option>
                                                                <?php }
                                                            } ?>
                                                        <?php }
                                                    } ?>
                                                <?php }
                                            } ?>
                                        <?php }
                                    } ?>
                                </select>
                                <div class="error-message" id="question-error"></div>
                            </div>
                        </div>

                        <!-- Answer  -->
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Answer<span class="login-danger">*</span></label>
                                <input class="form-control p-4" type="text" placeholder="Enter Answer text"
                                    name="Answer" id="Answer">
                                <div class="error-message" id="Answer-error"></div>
                                <input type="checkbox" name="is_correctAnswer" id="isCorrect" value="1">
                                <label for="isCorrectOne">Is Correct</label>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_add_answer" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Delete modal -->
<div class="modal fade" id="delete-answer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="Section-form" action="" method="post">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Delete Answer</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" name="answerid" id="answer_id">
                        <p class="lead">Are you sure to delete this Answer?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_delete_answer" class="btn btn-primary" value="Yes">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleForm(id) {
        $("#answerid").val(id);
        // console.log(id);
        $("#addAnswerModalLabel").html("Update Answer");
        $("[name='btn_add_answer']").val("Update");

        // Fetch student data
        $.ajax({
            method: "POST",
            url: "includes/ajaxReader.php",
            data: {
                table: "answers",
                id: id
            }
        })
            .done((res) => {
                // console.log(res);
                var res = JSON.parse(res);
                // console.log(res);
                $("#course_id").val(res.course_id);
                $("#Quizz").val(res.quiz_id);
                $("#Questiontext").val(res.question_id);
                $("#Answer").val(res.answer_text);
                $("#isCorrect").prop('checked', res.is_correct == 1);
                $('#operation').val('update');
                // console.log(document.getElementById('operation').value);

                $('#answerid').val(res.id);

            });
    }


    function clearForm() {
        $("#addAnswerModalLabel").html('Add New Answer');
        $("[name='btn_add_answer']").val('Save');
        $("#course_id").val('')
        $("#Quizz").val('')
        $("#Questiontext").val('')
        $("#Answer").val('');
        $("#isCorrect").val('');
        $('#answerid').val(0);
    }

    function setIdToDelete(id) {
        $('#answer_id').val(id);
    }

    document.getElementById('answer-form').addEventListener('submit', function (event) {
        // event.preventDefault();
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        let isValid = true;

        // Validate Full Name
        const Questiontext = document.getElementById('Questiontext').value;
        // console.log(instructor_Name);
        if (Questiontext.trim() === '') {
            isValid = false;
            document.getElementById('question-error').textContent = 'question text is required';
        }
        const Answerone = document.getElementById('Answer').value;
        // console.log(Cat_desc);
        if (Answerone.trim() === '') {
            isValid = false;
            document.getElementById('Answer-error').textContent = 'Answer is required';
        }
        

        const Coursename = document.getElementById('course_id').value;
        // console.log(Cat_desc);
        if (Coursename.trim() === '') {
            isValid = false;
            document.getElementById('course-error').textContent = 'course is required';
        }

        const quizname = document.getElementById('Quizz').value;
        // console.log(Cat_desc);
        if (quizname.trim() === '') {
            isValid = false;
            document.getElementById('quiz-error').textContent = 'quiz is required';
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