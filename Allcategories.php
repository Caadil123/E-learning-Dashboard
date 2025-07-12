<?Php
include 'includes/init.php'

    ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">View all Categories</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
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
                            <th>Deleted_by</th>
                            <th>Deleted_at</th>
                            <!-- <th>Instructor Password</th> -->
                            <!-- <th>Action</th> -->
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
                                <td style="width: 200px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo htmlspecialchars($category['Cat_desc']); ?></td>
                                <td><?php echo htmlspecialchars(readcolumn('users', 'name', $category['updated_by'])); ?></td>
                                <td><?php echo htmlspecialchars($category['updated_at']); ?></td>
                                <td><?php echo htmlspecialchars(readcolumn('users', 'name', $category['deleted_by'])); ?></td>
                                <td><?php echo htmlspecialchars($category['deleted_at']); ?></td>
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