<?Php
include 'includes/init.php';

// $userRoleID = readcolumn('users', 'role_id', $_SESSION['userId']);
// $usercourses = GetId('courses', "Instructor_Id=".$_SESSION['userId']);
$userID = $_SESSION['userId'];
$userRoleID = readcolumn('users', 'role_id', $_SESSION['userId']);
$usercourses = GetId('courses', "Instructor_Id=$userID");

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

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">View all Sections</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Sections</h6>
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
                        <?php foreach (read('courses') as $course): 
                            if($course['is_deleted'] == 0){
                            ?>
                        <?php foreach ($sections as $section): 
                            if($section['Course_ID'] == $course['ID']){
                            ?>
                    <tr>
                        <td><?php echo htmlspecialchars($section['ID']); ?></td>
                        <td><?php echo htmlspecialchars($section['Section_name']); ?></td>
                        <td><?php echo htmlspecialchars(readcolumn('courses', 'Course_name', $section['Course_ID'])); ?></td>
                        <td><?php echo htmlspecialchars(readcolumn('users', 'name', $section['updated_by'])); ?></td>
                        <td><?php echo htmlspecialchars($section['updated_at']); ?></td>
                    </tr>
                <?php } endforeach; ?>
                <?php } endforeach; ?>
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