<?Php
include 'includes/init.php';

if (isset($_POST['btn_add_course'])) {
    if ($_POST['operation'] == "insert") {

        // Handle add category
        $data = [
            'course_name' => $_POST['CourseName'],
            'Category_ID' => $_POST['category'],
            'instructor_id' => $_POST['instructor'],
            'Duration' => $_POST['duration'],
            'Level' => $_POST['level'],
            'describtion' => $_POST['describtion']
        ];
        // handle course image
        if (isset($_FILES['Course_image']) && $_FILES['Course_image']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["Course_image"]["name"]);
            if (move_uploaded_file($_FILES["Course_image"]["tmp_name"], $target_file)) {
                $data['Course_image'] = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        $table = 'courses';
        $result = insert($table, $data);

        if ($result) {
            // echo "New category inserted with ID: " . $result;
            echo "<script>
                alert('New course inserted');
            window.location.href = 'Modifycourses.php'; // Redirect to index page
            </script>";
        } else {
            // echo "Error inserting category.";
            echo "<script>
        alert('Error: Could not course category');
    window.location.href = 'Modifycourses.php'; // Redirect to index page
    </script>";
        }
    } else if ($_POST['operation'] == "update") {
        $data = [
            'id' => $_POST['courseid'],
            'Course_name' => $_POST['CourseName'],
            'Category_ID' => $_POST['category'],
            'instructor_id' => $_POST['instructor'],
            'Duration' => $_POST['duration'],
            'Level' => $_POST['level'],
            'describtion' => $_POST['describtion']
        ];
        // handle course image
        if (isset($_FILES['Course_image']) && $_FILES['Course_image']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["Course_image"]["name"]);
            if (move_uploaded_file($_FILES["Course_image"]["tmp_name"], $target_file)) {
                $data['Course_image'] = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        $table = 'courses';
        $resultUpdate = update($table, $data);
        // print_r( $resultUpdate);

        if ($resultUpdate) {
            // echo 'Success';
            echo "<script>
                        alert('Course successfully updated');
                        window.location.href = 'Modifycourses.php'; // Redirect to index page
                      </script>";
        } else {
            echo 'Error';
            echo "<script>
                        alert('Error: Could not update Course');
                        window.location.href = 'Modifycourses.php'; // Redirect to index page
                      </script>";
        }
    }
}
// delete category process.
if (isset($_POST['btn_delete_course'])) {
    $result = deleteRecord("courses", ["id" => trim($_POST["courseid"])]);
    if ($result) {
        echo "<script> alert('Successfully deleted!') </script>";
    } else {
        echo "<script> alert('Something went wrong!') </script>";
    }
}

include 'modals/CourseModel.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Modify Courses</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Courses</h6>
            <?php
            $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
            
            // Check if the user has the 'delete' permission for the current submenu
            if (!in_array("insert-$submenu_id", $userPermissions)): ?>
                <a href="#" class="btn btn-primary" onclick="clearForm()" data-toggle="modal" data-target="#add-course">
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
                            <th>Course_name</th>
                            <th>Course_image</th>
                            <th>Category_ID</th>
                            <th>Teacher_ID</th>
                            <th>Describtion</th>
                            <th>Duration</th>
                            <th>Level</th>
                            <th>Average Rating</th>
                            <th>Updated_by</th>
                            <th>Updated_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (read('categories') as $category):
                            if ($category['is_deleted'] == 0): ?>
                                <?php foreach (read('courses') as $course):
                                    if ($course['Category_ID'] == $category['ID']): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($course['ID']); ?></td>
                                            <td><?php echo htmlspecialchars($course['Course_name']); ?></td>
                                            <td>
                                                <img src="<?php echo htmlspecialchars($course['Course_image']); ?>" alt="Course Image"
                                                    style="width: 50px; height: 50px; border-radius:50%">
                                            </td>
                                            <td><?php echo htmlspecialchars(readcolumn('categories', 'Cat_name', $course['Category_ID'])); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars(readcolumn('users', 'name', $course['Instructor_Id'])); ?>
                                            </td>
                                            <td
                                                style="width: 200px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                <?php echo htmlspecialchars($course['describtion']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($course['Duration']); ?></td>
                                            <td><?php echo htmlspecialchars($course['Level']); ?></td>
                                            <td><?php echo getAverageRating($course['ID']); ?></td>
                                            <td><?php echo htmlspecialchars($course['updated_by']); ?></td>
                                            <td><?php echo htmlspecialchars($course['updated_at']); ?></td>
                                            <td style="width: 100px;">
                                                <div class="d-flex justify-content-between">
                                                    <!-- Update button -->
                                                    <?php
                                                    $submenu_id = GetId('submenus', "href='$current_page'");
                                                    if (!in_array("update-$submenu_id", $userPermissions)): ?>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#add-course" data-modal="" data-id=""
                                                            onclick="handleForm(<?= $course['ID'] ?>)">
                                                            <i class="fas fa-fw fa-pen"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    <!-- Delete button -->
                                                    <?php
                                                    $submenu_id = GetId('submenus', "href='$current_page'");
                                                    if (!in_array("delete-$submenu_id", $userPermissions)): ?>
                                                        <button type="submit" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#delete-course" onclick="setIdToDelete(<?= $course['ID'] ?>)"><i
                                                                class="fas fa-fw fa-trash"></i></button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif;
                                endforeach; ?>
                            <?php endif;
                        endforeach; ?>
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