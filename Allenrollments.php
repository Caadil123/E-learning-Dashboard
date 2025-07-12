<?Php
include 'includes/init.php'

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">View all Enrollments</h1>
                    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">All Students Enrolled course</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Student Name</th>
                                            <th>Course Name</th>
                                            <th>Enrollment Date</th>
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
                                <!-- enrollment info -->
                                <?php foreach (read('enrollments') as $enroll): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($enroll['ID']); ?></td>
                                        <td><?php echo htmlspecialchars(readcolumn('students', 'STD_email', $enroll['Student_ID'])); ?></td>
                                        <td><?php echo htmlspecialchars(readcolumn('courses', 'Course_name', $enroll['course_id'])); ?></td>
                                        <td><?php echo htmlspecialchars($enroll['enrollment_date']); ?></td>
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