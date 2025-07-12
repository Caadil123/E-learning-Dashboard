<?Php
include 'includes/init.php'

    ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">View all Courses</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Courses</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course Name</th>
                            <th>Course image</th>
                            <th>Category type</th>
                            <th>Instructor</th>
                            <th>describtion</th>
                            <th>Course Duration</th>
                            <th>Level</th>
                            <th>Updated_by</th>
                            <th>Updated_at</th>
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
                        <?php foreach (read('categories') as $category):
                            if ($category['is_deleted'] == 0): // Only process if category is not deleted ?>
                                <?php foreach (read('courses') as $course):
                                    if ($course['Category_ID'] == $category['ID']): // Check if course belongs to this category
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($course['ID']); ?></td>
                                            <td><?php echo htmlspecialchars($course['Course_name']); ?></td>
                                            <td>
                                                <img src="<?= htmlspecialchars($course['Course_image']); ?>" alt="Course Image"
                                                    style="width: 50px; height: 50px; border-radius:50%;">
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
                                            <td><?php echo htmlspecialchars($course['updated_by']); ?></td>
                                            <td><?php echo htmlspecialchars($course['updated_at']); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
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