<?Php
include 'includes/init.php';

// Add instructor
if (isset($_POST['btn_add_instructor'])) {
    if ($_POST['operation'] == "insert") {

        // Handle add category
        $data = [
            'name' => $_POST['InstructorName'],
            'username' => $_POST['username'],
            'role_id' => $_POST['role'],
            'password' => md5(trim($_POST['password']))
        ];


        $table = 'users';
        $result = insert($table, $data);

        if ($result) {
            // echo "New category inserted with ID: " . $result;
            echo "<script>
                alert('New user inserted');
            window.location.href = 'Modifyusers.php'; // Redirect to index page
            </script>";
        } else {
            // echo "Error inserting category.";
            echo "<script>
        alert('Error: Could not create user');
    window.location.href = 'Modifyusers.php'; // Redirect to index page
    </script>";
        }
    } else if ($_POST['operation'] == "update") {
        $data = [
            'id' => $_POST['instuctorid'],
            'name' => $_POST['InstructorName'],
            'username' => $_POST['username'],
            'role_id' => $_POST['role'],
            'password' => md5(trim($_POST['password']))
        ];
        $table = 'users';
        $result = update($table, $data);
        // echo $result;

        if ($result) {
            echo "<script>
                        alert('user successfully updated');
                        window.location.href = 'Modifyusers.php'; // Redirect to index page
                      </script>";
        } else {
            echo "<script>
                        alert('Error: Could not update user');
                        window.location.href = 'Modifyusers.php'; // Redirect to index page
                      </script>";
        }
    }
}
// delete instructor process.
if (isset($_POST['btn_delete_instructor'])) {
    $result = deleteRecord("users", ["id" => trim($_POST["instructorid"])]);
    if ($result) {
        echo "<script> alert('Successfully deleted!') 
        window.location.href = 'Modifyusers.php';
        </script>";
    } else {
        echo "<script> alert('Something went wrong!') </script>";
    }
}

include 'modals/instructorModel.php';
include 'modals/permissionModel.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Modify users</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All users</h6>
                <?php
                $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
            
                // Check if the user has the 'delete' permission for the current submenu
                if (!in_array("insert-$submenu_id", $userPermissions)): ?>
                    <a href="#" class="btn btn-primary" onclick="clearForm()" data-toggle="modal" data-target="#add-instructor">
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
                            <th>Name</th>
                            <th>username</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>privleges</th>
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
                        <?php foreach (read('users') as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['password']) ? '****' : ''; ?></td>
                                <td><?php echo htmlspecialchars(readcolumn('role', 'role_name', $user['role_id'])); ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#privleges" data-id="<?php //echo $user['id']; ?>"
                                        onclick="loadUserPermissions(<?php echo $user['id']; ?>)">
                                        <i class="fas fa-fw fa-key"></i>
                                    </button>
                                </td>
                                <td>
                                    <?php
                                    $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
                                
                                    // Check if the user has the 'delete' permission for the current submenu
                                    if (!in_array("update-$submenu_id", $userPermissions)): ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#add-instructor" data-id="" onclick="handleForm(<?= $user['id'] ?>)">
                                            <i class="fas fa-fw fa-pen"></i>
                                        </button>
                                    <?php endif; ?>

                                    <!-- Delete button -->
                                    <?php
                                    $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
                                
                                    // Check if the user has the 'delete' permission for the current submenu
                                    if (!in_array("delete-$submenu_id", $userPermissions)): ?>
                                        <button type="submit" class="btn btn-danger" data-toggle="modal"
                                            data-target="#delete-user"
                                            onclick="setIdToDelete(<?= htmlspecialchars($user['id']) ?>)">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </button>
                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
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