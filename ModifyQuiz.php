<?Php
include 'includes/init.php';

// Add instructor
if (isset($_POST['btn_add_quizz'])) {
    if ($_POST['operation'] == "insert") {

        // Handle add category
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['describtion'],
            'section_id' => $_POST['Section'],
            'course_id' => $_POST['course']
        ];


        $table = 'quizzes';
        $result = insert($table, $data);

        if ($result) {
            // echo "New category inserted with ID: " . $result;
            echo "<script>
                alert('New quizz inserted');
            window.location.href = 'ModifyQuiz.php'; // Redirect to index page
            </script>";
        } else {
            // echo "Error inserting category.";
            echo "<script>
        alert('Error: Could not create quizz');
    window.location.href = 'ModifyQuizz.php'; // Redirect to index page
    </script>";
        }
    } else if ($_POST['operation'] == "update") {
        $data = [
            'id' => $_POST['quizzId'],
            'title' => $_POST['title'],
            'description' => $_POST['describtion'],
            'section_id' => $_POST['Section'],
            'course_id' => $_POST['course']
        ];
        $table = 'quizzes';
        $result = update($table, $data);
        // echo $result;

        if ($result) {
            echo "<script>
                        alert('quizz successfully updated');
                        window.location.href = 'ModifyQuiz.php'; // Redirect to index page
                      </script>";
        } else {
            echo "<script>
                        alert('Error: Could not update user');
                        window.location.href = 'ModifyQuiz.php'; // Redirect to index page
                      </script>";
        }
    }
}
// delete instructor process.
if (isset($_POST['btn_delete_quizz'])) {
    $result = deleteRecord("quizzes", ["id" => trim($_POST["quizzId"])]);
    if ($result) {
        echo "<script> alert('Successfully deleted!') 
        window.location.href = 'ModifyQuiz.php';
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
$sections = $userRoleID == 2 ? read_where('sections', "Course_ID IN ($courseIDs)") : read('sections');


include "modals/QuizModel.php";
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Modify Quizz</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Quizzes</h6>
                <?php
                $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
                // Check if the user has the 'delete' permission for the current submenu
                if (!in_array("insert-$submenu_id", $userPermissions)): ?>
                    <a href="#" class="btn btn-primary" onclick="clearForm()" data-toggle="modal" data-target="#add-quizz">
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
                            <th>Section Name</th>
                            <th>Title</th>
                            <th>Describtion</th>
                            <th>Created at</th>
                            <th>Action</th>
                            <!-- <th>Salary</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Quiz info -->
                        <?php 
                        
                        foreach ($sections as $section){
                            if ($section['is_deleted'] == 0) {
                                ?>
                        <?php foreach (read('quizzes') as $quizz): 
                            if ($quizz['section_id'] == $section['ID']) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($quizz['id']); ?></td>
                                <td><?php echo htmlspecialchars(readcolumn('courses', 'Course_name', $quizz['section_id'])); ?></td>
                                <td><?php echo htmlspecialchars(readcolumn('sections', 'Section_name', $quizz['section_id'])); ?></td>
                                <td><?php echo htmlspecialchars($quizz['title']); ?></td>
                                <td><?php echo htmlspecialchars($quizz['description']); ?></td>
                                <td><?php echo htmlspecialchars($quizz['created_at']); ?></td>
                                <td>
                                    <?php
                                    $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
                                
                                    // Check if the user has the 'delete' permission for the current submenu
                                    if (!in_array("update-$submenu_id", $userPermissions)): ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#add-quizz" data-id="" onclick="handleForm(<?= $quizz['id'] ?>)">
                                            <i class="fas fa-fw fa-pen"></i>
                                        </button>
                                    <?php endif; ?>

                                    <!-- Delete button -->
                                    <?php
                                    $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
                                
                                    // Check if the user has the 'delete' permission for the current submenu
                                    if (!in_array("delete-$submenu_id", $userPermissions)): ?>
                                        <button type="submit" class="btn btn-danger" data-toggle="modal"
                                            data-target="#delete-quizz"
                                            onclick="setIdToDelete(<?= htmlspecialchars($quizz['id']) ?>)">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </button>
                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php }endforeach; ?>
                        <?php } }  ; ?>
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