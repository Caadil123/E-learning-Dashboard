<?Php
include 'includes/init.php';

if (isset($_POST['btn_add_question'])) {
    if ($_POST['operation'] == "insert") {

        // Handle add category
        $data = [
            'question_text' => $_POST['Questiontext'],
            'quiz_id' => $_POST['Quizz'],
            'course_id' => $_POST['course']
        ];

        $table = 'questions';
        $result = insert($table, $data);
        if ($result) {
            // echo "New category inserted with ID: " . $result;
            echo "<script>
                alert('New Question inserted');
            window.location.href = 'quizQuestion.php'; // Redirect to index page
            </script>";
        } else {
            // echo "Error inserting category.";
            echo "<script>
        alert('Error: Could not create content');
    window.location.href = 'quizQuestion.php'; // Redirect to index page
    </script>";
        }
    } else if ($_POST['operation'] == "update") {
        $data = [
            'id' => $_POST['questionid'],
            'question_text' => $_POST['Questiontext'],
            'quiz_id' => $_POST['Quizz'],
            'course_id' => $_POST['course']
        ];

        $table = 'questions';
        $result = update($table, $data);

        if ($result) {
            echo "<script>
                        alert('Question successfully updated');
                        window.location.href = 'quizQuestion.php'; // Redirect to index page
                      </script>";
        } else {
            echo "<script>
                        alert('Error: Could not update content');
                        window.location.href = 'quizQuestion.php'; // Redirect to index page
                      </script>";
        }
    }
}
// delete category process.
if (isset($_POST['btn_delete_question'])) {
    $result = deleteRecord("questions", ["id" => trim($_POST["questionid"])]);
    if ($result) {
        echo "<script> alert('Successfully deleted!') 
        window.location.href = 'quizQuestion.php';
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
$sections = $userRoleID == 2 ?  GetCourseId('sections', "Course_ID IN ($courseIDs)") : read('sections');

if (is_array($sections) && !empty($sections)) {
    $sectionIDs = implode(',', $sections);  // Convert array to a comma-separated string
} else {
    $sectionIDs = 'NULL';  // Handle the case when no courses are found
}
$quizzes = read_where('quizzes', "section_id IN ($sectionIDs)");

// print_r($quizzes);



include 'modals/Questionmodel.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Modify Question</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Question</h6>
            <?php
            $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
            
            // Check if the user has the 'delete' permission for the current submenu
            if (!in_array("insert-$submenu_id", $userPermissions)): ?>
                <a href="#" class="btn btn-primary" onclick="clearForm()" data-toggle="modal" data-target="#add-question">
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
                            <th>Course Name</th>
                            <th>Quizz Name</th>
                            <th>Question text</th>
                            <th>Created at</th>
                            <th>Action</th>
                            <!-- <th>Salary</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Student info -->
                        <?php foreach ( $quizzes as $quizz):
                            if ($quizz['is_deleted'] == 0) {
                                ?>
                                <?php foreach (read('questions') as $question):
                                   if($quizz['id'] == $question['quiz_id']) {
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($question['id']); ?></td>
                                            <td><?php echo htmlspecialchars(readcolumn('courses', 'Course_name', $question['course_id'])); ?>
                                            <td><?php echo htmlspecialchars(readcolumn('quizzes', 'title', $question['quiz_id'])); ?>
                                            <td><?php echo htmlspecialchars($question['question_text']); ?></td>
                                            </td>
                                            <td><?php echo htmlspecialchars($question['created_at']); ?></td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <!-- Update button -->
                                                    <?php
                                                    $submenu_id = GetId('submenus', "href='$current_page'");
                                                    if (!in_array("update-$submenu_id", $userPermissions)): ?>
                                                        <button type="button" class="btn btn-primary mb-2"
                                                         data-toggle="modal"
                                                            data-target="#add-question" data-id=""
                                                            onclick="handleForm(<?= $question['id'] ?>)">
                                                            <i class="fas fa-fw fa-pen"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    <!-- Delete button -->
                                                    <?php
                                                    $submenu_id = GetId('submenus', "href='$current_page'");
                                                    if (!in_array("delete-$submenu_id", $userPermissions)): ?>
                                                        <button type="submit" class="btn btn-danger"
                                                            data-toggle="modal" data-target="#delete-question"
                                                            onclick="setIdToDelete(<?= $question['id'] ?>)"><i
                                                                class="fas fa-fw fa-trash"></i></button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }endforeach; ?>
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