<?Php
include 'includes/init.php'

    ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">View all Contents</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Contents</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                                <th>ID</th>
                            <th>Content Name</th>
                            <th>Section name</th>
                            <th>Content hour</th>
                            <th>Lesson</th>
                            <th>Content video</th>
                            <th>Updated_by</th>
                            <th>Updated_at</th>
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
                        <?php foreach (read('sections') as $section): 
                            if($section['is_deleted'] == 0){
                            ?>
                        <?php foreach (read('contents') as $content): 
                            if($content['Section_ID'] == $section['ID']){
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($content['ID']); ?></td>
                                <td><?php echo htmlspecialchars($content['Content_name']); ?></td>
                                <td><?php echo htmlspecialchars(readcolumn('sections', 'Section_name', $content['Section_ID'])); ?></td>
                                <td><?php echo htmlspecialchars(readcolumn('courses', 'Course_name', $content['Course_ID'])); ?>
                                </td>
                                <td><?php echo htmlspecialchars($content['Content_time']); ?></td>
                                <td><?php echo htmlspecialchars($content['lesson']); ?></td>
                                <td><?php echo htmlspecialchars($content['Content_Video']); ?></td>
                                <td><?php echo htmlspecialchars($content['updated_by']); ?></td>
                                <td><?php echo htmlspecialchars($content['updated_at']); ?></td>
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