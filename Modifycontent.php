<?Php
include 'includes/init.php';

if (isset($_POST['btn_add_content'])) {
    if ($_POST['operation'] == "insert") {

        // Handle add category
        $data = [
            'Content_name' => $_POST['contentName'],
            'Section_ID' => $_POST['Section'],
            'Course_ID' => $_POST['Course'],
            'Content_time' => $_POST['Content_time'],
            'lesson' => $_POST['Lesson']
        ];

        if (isset($_FILES['Content_Video']) && $_FILES['Content_Video']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/videos/";
            $target_file = $target_dir . basename($_FILES["Content_Video"]["name"]);

            if (move_uploaded_file($_FILES["Content_Video"]["tmp_name"], $target_file)) {
                $data['Content_Video'] = $target_file;
            } else {
                echo "<script>alert('Sorry, there was an error uploading your video.');</script>";
                exit;
            }
        }

        $table = 'contents';
        $result = insert($table, $data);
        if ($result) {
            // echo "New category inserted with ID: " . $result;
            echo "<script>
                alert('New content inserted');
            window.location.href = 'Modifycontent.php'; // Redirect to index page
            </script>";
        } else {
            // echo "Error inserting category.";
            echo "<script>
        alert('Error: Could not create content');
    window.location.href = 'Modifycontent.php'; // Redirect to index page
    </script>";
        }
    } else if ($_POST['operation'] == "update") {
        $data = [
            'id' => $_POST['contentid'],
            'Content_name' => $_POST['contentName'],
            'Section_ID' => $_POST['Section'],
            'Course_ID' => $_POST['Course'],
            'Content_time' => $_POST['Content_time'],
            'lesson' => $_POST['Lesson'],
            'updated_by' => $_SESSION['userId'],
        ];
        if (isset($_FILES['Content_Video']) && $_FILES['Content_Video']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/videos/";
            $target_file = $target_dir . basename($_FILES["Content_Video"]["name"]);

            if (move_uploaded_file($_FILES["Content_Video"]["tmp_name"], $target_file)) {
                $data['Content_Video'] = $target_file;
            } else {
                echo "<script>alert('Sorry, there was an error uploading your video.');</script>";
                exit;
            }
        }

        $table = 'contents';
        $result = update($table, $data);

        if ($result) {
            echo "<script>
                        alert('content successfully updated');
                        window.location.href = 'Modifycontent.php'; // Redirect to index page
                      </script>";
        } else {
            echo "<script>
                        alert('Error: Could not update content');
                        window.location.href = 'Modifycontent.php'; // Redirect to index page
                      </script>";
        }
    }
}
// delete category process.
if (isset($_POST['btn_delete_content'])) {
    $result = deleteRecord("contents", ["id" => trim($_POST["contentid"])]);
    if ($result) {
        echo "<script> alert('Successfully deleted!') 
        window.location.href = 'Modifycontent.php';
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
// print_r($sections);
include 'modals/ContentModel.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Modify Contens</h1>

   <!-- DataTales Example - Improved with Search Filter -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-center bg-white">
        <h6 class="m-0 font-weight-bold text-primary">All Contents</h6>
        <?php
        $submenu_id = GetId('submenus', "href='$current_page'");
        if (!in_array("insert-$submenu_id", $userPermissions)): ?>
            <button class="btn btn-primary btn-sm mt-2 mt-md-0" onclick="clearForm()" data-toggle="modal" data-target="#add-content">
                <i class="fas fa-plus mr-1"></i> Add Content
            </button>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Content Name</th>
                        <th>Section</th>
                        <th>Course</th>
                        <th>Duration</th>
                        <th>Lesson</th>
                        <th>Video</th>
                        <th>Updated By</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sections as $section):
                        if ($section['is_deleted'] == 0) {
                            foreach (read('contents') as $content):
                                if ($content['Section_ID'] == $section['ID']) {
                                    $videoPath = htmlspecialchars($content['Content_Video']);
                                    ?>
                                    <tr>
                                        <td><?= $content['ID'] ?></td>
                                        <td class="font-weight-bold"><?= htmlspecialchars($content['Content_name']) ?></td>
                                        <td><?= htmlspecialchars(readcolumn('sections', 'Section_name', $content['Section_ID'])) ?></td>
                                        <td>
                                            <span class="badge badge-info">
                                                <?= htmlspecialchars(readcolumn('courses', 'Course_name', $content['Course_ID'])) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($content['Content_time']) ?></td>
                                        <td><?= htmlspecialchars($content['lesson']) ?></td>
                                        <td>
                                            <?php if ($videoPath): ?>
                                                <a href="<?= $videoPath ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-play"></i> Play
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">None</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars(readcolumn('users', 'name', $content['updated_by'])) ?></td>
                                        <td><?= date('M d, Y', strtotime($content['updated_at'])) ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <?php if (!in_array("update-$submenu_id", $userPermissions)): ?>
                                                    <button class="btn btn-sm btn-circle btn-primary mr-1" 
                                                        data-toggle="modal" data-target="#add-content" 
                                                        onclick="handleForm(<?= $content['ID'] ?>)" 
                                                        title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <?php if (!in_array("delete-$submenu_id", $userPermissions)): ?>
                                                    <button class="btn btn-sm btn-circle btn-danger"
                                                        data-toggle="modal" data-target="#delete-content"
                                                        onclick="setIdToDelete(<?= $content['ID'] ?>)"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                            endforeach;
                        }
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Custom CSS for the table */
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.03);
    }
    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .dataTables_filter input {
        border-radius: 4px;
        padding: 5px 10px;
        border: 1px solid #ddd;
    }
    .badge {
        font-weight: 500;
        padding: 5px 8px;
    }
    #dataTable th {
        white-space: nowrap;
    }
</style>

<script>
$(document).ready(function() {
    // Initialize DataTable with all original functionality
    $('#dataTable').DataTable({
        responsive: true,
        dom: '<"top"<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>>rt<"bottom"<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>>',
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search contents...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            paginate: {
                previous: "<i class='fas fa-chevron-left'></i>",
                next: "<i class='fas fa-chevron-right'></i>"
            }
        },
        initComplete: function() {
            // Style the search box after initialization
            $('.dataTables_filter input').addClass('form-control form-control-sm');
        }
    });
    
    // Initialize tooltips
    $('[title]').tooltip({
        trigger: 'hover',
        placement: 'top'
    });
});
</script>
</div>


<!-- /.container-fluid -->

<!-- End of Main Content -->

<?php include 'includes/footer.php' ?>

</body>

</html>