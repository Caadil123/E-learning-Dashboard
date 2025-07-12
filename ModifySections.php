<?Php
include 'includes/init.php';

if (isset($_POST['btn_add_section'])) {
    if ($_POST['operation'] == "insert") {

        // Handle add category
        $data = [
            'Section_name' => $_POST['sectionName'],
            'Course_ID' => $_POST['Course']
        ];

        $table = 'sections';
        $result = insert($table, $data);

        if ($result) {
            // echo "New category inserted with ID: " . $result;
            echo "<script>
                alert('New section inserted');
            window.location.href = 'ModifySections.php'; // Redirect to index page
            </script>";
        } else {
            // echo "Error inserting category.";
            echo "<script>
        alert('Error: Could not create section');
    window.location.href = 'ModifySections.php'; // Redirect to index page
    </script>";
        }
    } else if ($_POST['operation'] == "update") {
        $data = [
            'id' => $_POST['sectionid'],
            'Section_name' => $_POST['sectionName'],
            'Course_ID' => $_POST['Course'],
            'updated_by' => $_SESSION['userId'],
        ];

        $table = 'sections';
        $result = update($table, $data);

        if ($result) {
            echo "<script>
                        alert('section successfully updated');
                        window.location.href = 'ModifySections.php'; // Redirect to index page
                      </script>";
        } else {
            echo "<script>
                        alert('Error: Could not update section');
                        window.location.href = 'ModifySections.php'; // Redirect to index page
                      </script>";
        }
    }
}
// delete category process.
if (isset($_POST['btn_delete_section'])) {
    $result = deleteRecord("sections", ["id" => trim($_POST["sectionid"])]);
    if ($result) {
        echo "<script> alert('Successfully deleted!') 
        window.location.href = 'ModifySections.php';
        </script>";
    } else {
        echo "<script> alert('Something went wrong!') </script>";
    }
}

// displaying only teacher his course sections
$userID = $_SESSION['userId'];
$userRoleID = readcolumn('users', 'role_id', $_SESSION['userId']);
$courses = read_where('courses', "Instructor_Id=$userID");
$usercourses = GetCourseId('courses', "Instructor_Id=$userID");

// Print the array of course IDs to debug

// If $usercourses is an array, convert it to a comma-separated string
if (is_array($usercourses) && !empty($usercourses)) {
    $courseIDs = implode(',', $usercourses);  // Convert array to a comma-separated string
} else {
    $courseIDs = 'NULL';  // Handle the case when no courses are found
}
// print_r($courseIDs);
// Use the formatted $courseIDs in your query
$sections = $userRoleID == 2 ? read_where('sections', "Course_ID IN ($courseIDs)") : read('sections');
// print_r($courses);
include 'modals/SectionModel.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Modify Sections</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Sections</h6>
            <?php
            $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
            
            // Check if the user has the 'delete' permission for the current submenu
            if (!in_array("insert-$submenu_id", $userPermissions)): ?>
                <a href="#" class="btn btn-primary" onclick="clearForm()" data-toggle="modal" data-target="#add-section">
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
                            <th>Sections Name</th>
                            <th>Course type</th>
                            <th>Updated_by</th>
                            <th>Updated_at</th>
                            <th>Action</th>
                            <!-- <th>Salary</th> -->
                        </tr>
                    </thead>
                    <!-- <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot> -->
                    <tbody>
                        <!-- Student info -->
                        <?php
                        foreach (read('courses') as $course) {
                            // Ensure $course is an array
                            if ($course["is_deleted"] == 0) {
                                foreach ($sections as $section) {
                                    // Ensure $section is an array
                                    if (is_array($section) && $section['Course_ID'] == $course['ID']) {
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($section['ID']); ?></td>
                                            <td><?php echo htmlspecialchars($section['Section_name']); ?></td>
                                            <td><?php echo htmlspecialchars(readcolumn('courses', 'Course_name', $section['Course_ID'])); ?>
                                            <td><?php echo htmlspecialchars(readcolumn('users', 'name', $section['updated_by'])); ?></td>
                                            <td><?php echo htmlspecialchars($section['updated_at']); ?></td>
                                            </td>
                                            <td style="text-align:center">
                                                <div>
                                                    <!-- Update button -->
                                                    <?php
                                                    $submenu_id = GetId('submenus', "href='$current_page'");
                                                    if (!in_array("update-$submenu_id", $userPermissions)): ?>
                                                        <button type="button" class="btn btn-primary" style="width: 50px; height: 40px;"
                                                            data-toggle="modal" data-target="#add-section" data-id=""
                                                            onclick="handleForm(<?= $section['ID'] ?>)">
                                                            <i class="fas fa-fw fa-pen"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    <!-- Delete button -->
                                                    <?php
                                                    $submenu_id = GetId('submenus', "href='$current_page'");
                                                    if (!in_array("delete-$submenu_id", $userPermissions)): ?>
                                                        <button type="submit" class="btn btn-danger" style="width: 50px; height: 40px;"
                                                            data-toggle="modal" data-target="#delete-section"
                                                            onclick="setIdToDelete(<?= $section['ID'] ?>)">
                                                            <i class="fas fa-fw fa-trash"></i></button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>

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