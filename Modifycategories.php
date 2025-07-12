<?Php
include 'includes/init.php';

$current_page = basename($_SERVER['PHP_SELF']);

if (isset($_POST['btn_add_category'])) {
    if ($_POST['operation'] == "insert") {

        // Handle add category
        $data = [
            'Cat_Name' => $_POST['Cat_Name'],
            'Cat_desc' => $_POST['Cat_desc'],
        ];
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["category_image"]["name"]);
            if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)) {
                $data['Cat_image'] = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        $table = 'categories';
        $result = insert($table, $data);

        if ($result) {
            // echo "New category inserted with ID: " . $result;
            echo "<script>
                alert('New category inserted');
            window.location.href = 'Modifycategories.php'; // Redirect to index page
            </script>";
        } else {
            // echo "Error inserting category.";
            echo "<script>
        alert('Error: Could not create category');
    window.location.href = 'Modifycategories.php'; // Redirect to index page
    </script>";
        }
    } else if ($_POST['operation'] == "update") {
        $data = [
            'id' => $_POST['categoryid'],
            'Cat_name' => $_POST['Cat_Name'],
            'Cat_desc' => $_POST['Cat_desc'],
            'updated_by' => $_SESSION['userId'],
        ];
        if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["category_image"]["name"]);
            if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)) {
                $data['Cat_image'] = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        }

        $table = 'categories';
        $result = update($table, $data);

        if ($result) {
            echo "<script>
                        alert('Category successfully updated');
                        window.location.href = 'Modifycategories.php'; // Redirect to index page
                      </script>";
        } else {
            echo "<script>
                        alert('Error: Could not update category');
                        window.location.href = 'Modifycategories.php'; // Redirect to index page
                      </script>";
        }
    }
}
// delete category process.
if (isset($_POST['btn_delete_category'])) {
    $result = deleteRecord("categories", ["id" => trim($_POST["categoryid"]), 'deleted_by' => $_SESSION['userId']]);
    if ($result) {
        echo "<script> alert('Successfully deleted!') 
        window.location.href = 'Modifycategories.php';
        </script>";
    } else {
        echo "<script> alert('Something went wrong!') </script>";
    }
}

include 'modals/CategoryModel.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Modify Categories</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
            <?php
            $submenu_id = GetId('submenus', "href='$current_page'"); // Get the submenu ID for the current page
            
            // Check if the user has the 'delete' permission for the current submenu
            if (!in_array("insert-$submenu_id", $userPermissions)): ?>
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-category">
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
                            <th>Category Name</th>
                            <th>Category image</th>
                            <th>Category describtion</th>
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
                        <?php foreach (read('categories') as $category): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['ID']); ?></td>
                                <td><?php echo htmlspecialchars($category['Cat_name']); ?></td>
                                <td><img src="<?= htmlspecialchars($category['Cat_image']); ?>" alt="Category Image"
                                        style="width: 50px; height: 50px; border-radius:50%"></td>
                                <td
                                    style="width: 200px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo htmlspecialchars($category['Cat_desc']); ?>
                                </td>
                                <td><?php echo htmlspecialchars(readcolumn('users', 'name', $category['updated_by'])); ?></td>
                                <td><?php echo htmlspecialchars($category['updated_at']); ?></td>
                                <td style="text-align:center;width: 200px;">
                                    <div class="">
                                        <!-- Update button -->
                                        <?php
                                        $submenu_id = GetId('submenus', "href='$current_page'");
                                        if (!in_array("update-$submenu_id", $userPermissions)): ?>
                                            <button type="button" class="btn btn-primary" style="width: 50px; height: 40px;"
                                                data-toggle="modal" data-target="#add-category" data-id=""
                                                onclick="handleForm(<?= $category['ID'] ?>)">
                                                <i class="fas fa-fw fa-pen"></i>
                                            </button>
                                        <?php endif; ?>
                                        <!-- Delete button -->
                                        <?php
                                        $submenu_id = GetId('submenus', "href='$current_page'");
                                        if (!in_array("delete-$submenu_id", $userPermissions)): ?>
                                            <button type="submit" class="btn btn-danger" style="width: 50px; height: 40px;"
                                                data-toggle="modal" data-target="#delete-category"
                                                onclick="setIdToDelete(<?= htmlspecialchars($category['ID']) ?>)">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
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