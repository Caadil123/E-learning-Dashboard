<?Php
include 'includes/init.php'

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">View all students</h1>
                    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All Students</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Student Name</th>
                                            <th>Student Email</th>
                                            <th>Student Password</th>
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
                                <?php foreach (read('students') as $student): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($student['ID']); ?></td>
                                        <td><?php echo htmlspecialchars($student['STD_name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['STD_email']); ?></td>
                                        <td><?php echo htmlspecialchars($student['STD_pass']) ? '****' : ''; ?></td>
                                        <!-- <td>
                                            <form action="delete.php" method="post" style="display:inline-block;">
                                                <input type="hidden" name="id"
                                                    value="<?php echo htmlspecialchars($student['ID']); ?>">
                                                <button type="submit" class="btn btn-success"><i
                                                        class="bi bi-trash3"></i></button>
                                                <input type="hidden" name="form_type" value="student_deleted">
                                            </form>
                                        </td> -->
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
            <?php include 'includes/footer.php'?>

</body>

</html>