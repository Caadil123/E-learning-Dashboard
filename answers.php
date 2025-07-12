<?Php
include 'includes/init.php';

if (isset($_POST['btn_add_answer'])) {
    if ($_POST['operation'] == "insert") {
        $data = [
            'question_id' => $_POST['Questiontext'],
            'quiz_id' => $_POST['Quizz'],
            'course_id' => $_POST['course'],
            'answer_text' => $_POST['Answer'],
            'is_correct' => isset($_POST['is_correctAnswer']) ? 1 : 0
        ];

        $table = 'answers';
        $result = insert($table, $data);
        if ($result) {
            // echo "New category inserted with ID: " . $result;
            echo "<script>
                alert('New answer inserted');
            window.location.href = 'answers.php'; // Redirect to index page
            </script>";
        } else {
            // echo "Error inserting category.";
            echo "<script>
        alert('Error: Could not create content');
    window.location.href = 'answers.php'; // Redirect to index page
    </script>";
        }
    } else if ($_POST['operation'] == "update") {
        $data = [
            'id' => $_POST['answerid'],
            'question_id' => $_POST['Questiontext'],
            'quiz_id' => $_POST['Quizz'],
            'course_id' => $_POST['course'],
            'answer_text' => $_POST['Answer'],
            'is_correct' => isset($_POST['is_correctAnswer']) ? 1 : 0
        ];

        $table = 'answers';
        $result = update($table, $data);

        if ($result) {
            echo "<script>
                        alert('Answer successfully updated');
                        window.location.href = 'answers.php'; // Redirect to index page
                      </script>";
        } else {
            echo "<script>
                        alert('Error: Could not update content');
                        window.location.href = 'answers.php'; // Redirect to index page
                      </script>";
        }
    }
}
// delete category process.
if (isset($_POST['btn_delete_content'])) {
    $result = deleteRecord("answers", ["id" => trim($_POST["answerid"])]);
    if ($result) {
        echo "<script> alert('Successfully deleted!') 
        window.location.href = 'answers.php';
        </script>";
    } else {
        echo "<script> alert('Something went wrong!') </script>";
    }
}

// displaying only teacher his course sections
$userID = $_SESSION['userId'];
$userRoleID = readcolumn('users', 'role_id', $_SESSION['userId']);
$usercourses = GetCourseId('courses', "Instructor_Id=$userID");

// Print the array of course IDs to debug
// print_r($usercourses);

// If $usercourses is an array, convert it to a comma-separated string
if (is_array($usercourses) && !empty($usercourses)) {
    $courseIDs = implode(',', $usercourses);  // Convert array to a comma-separated string
} else {
    $courseIDs = 'NULL';  // Handle the case when no courses are found
}

// Use the formatted $courseIDs in your query
$sections = $userRoleID == 2 ? GetCourseId('sections', "Course_ID IN ($courseIDs)") : read('sections');

if (is_array($sections) && !empty($sections)) {
    $sectionIDs = implode(',', $sections);  // Convert array to a comma-separated string
} else {
    $courseIDs = 'NULL';  // Handle the case when no courses are found
}
// GetCourseId('quizzes', "section_id IN ($sectionIDs)")
$quizzes = GetCourseId('quizzes', "section_id IN ($sectionIDs)");


if (is_array($quizzes) && !empty($quizzes)) {
    $quizzIDs = implode(',', $quizzes);  // Convert array to a comma-separated string
} else {
    $quizzIDs = 'NULL';  // Handle the case when no courses are found
}

$questions = read_where('questions', "quiz_id IN ($quizzIDs)");

include 'modals/AnswerModel.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Modify Answers</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Answers</h6>
            <?php
            $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
            
            // Check if the user has the 'delete' permission for the current submenu
            if (!in_array("insert-$submenu_id", $userPermissions)): ?>
                <a href="#" class="btn btn-primary" onclick="clearForm()" data-toggle="modal" data-target="#add-answer">
                    <i class="fas fa-plus"></i>
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course name</th>
                            <th>Quiz name</th>
                            <th>Question text</th>
                            <th>Answer text</th>
                            <th>Is Correct</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- answersinfo -->
                        <?php foreach ($questions as $question):
                            if ($question['is_deleted'] == 0) {
                                $i = 1; // ✅ Now it's here – resets only once per question block
                                ?>
                                <?php foreach (read('answers') as $answer):
                                    if ($answer['question_id'] == $question['id']) {
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($answer['id']); ?></td>
                                            <td><?= htmlspecialchars(readcolumn('courses', 'Course_name', $answer['course_id'])); ?>
                                            <td><?= htmlspecialchars(readcolumn('quizzes', 'title', $answer['quiz_id'])); ?>
                                            <td><?= htmlspecialchars(readcolumn('questions', 'question_text', $answer['question_id'])); ?>
                                            </td>
                                            <td><?= htmlspecialchars($answer['answer_text']); ?></td>
                                            <td><?=  $answer['is_correct'] == 1 ? 'Correct' : 'Wrong'; ?></td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <?php
                                                    $submenu_id = GetId('submenus', "href='$current_page'");
                                                    if (!in_array("update-$submenu_id", $userPermissions)): ?>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#add-answer" onclick="handleForm(<?= $answer['id'] ?>, <?= $i ?>)">
                                                            <i class="fas fa-fw fa-pen"></i>
                                                        </button>
                                                    <?php endif; ?>

                                                    <?php if (!in_array("delete-$submenu_id", $userPermissions)): ?>
                                                        <button type="submit" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#delete-answer" onclick="setIdToDelete(<?= $answer['id'] ?>)">
                                                            <i class="fas fa-fw fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++;
                                    }
                                endforeach; ?>
                            <?php }endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include 'includes/footer.php' ?>

</body>

</html>