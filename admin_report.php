<?php
require 'includes/init.php';

// Get statistics
$stats = [
    'users' => $conn->query("SELECT COUNT(*) FROM users")->fetchColumn(),
    'courses' => $conn->query("SELECT COUNT(*) FROM courses")->fetchColumn(),
    'enrollments' => $conn->query("SELECT COUNT(*) FROM enrollments")->fetchColumn(),
    'active_enrollments' => $conn->query("SELECT COUNT(*) FROM enrollments")->fetchColumn()
];

$stmt = $conn->prepare("
    SELECT c.ID, c.Course_name 
    FROM courses c
    JOIN categories cat ON c.category_ID = cat.ID
    WHERE c.is_deleted = 0 
    AND cat.is_deleted = 0
    ORDER BY c.Course_name
");
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-pie text-primary"></i> Enrollment Reports
        </h1>
        <div class="d-none d-sm-inline-block">
            <span class="text-muted">Last updated: <?= date('F j, Y H:i') ?></span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <!-- <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['users'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Courses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['courses'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Enrollments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['enrollments'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Active Enrollments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['active_enrollments'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Report Generator Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter mr-2"></i>Filter Enrollments
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                     aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Report Options:</div>
                    <a class="dropdown-item" href="#" id="setLastMonth">
                        <i class="fas fa-calendar-minus mr-2"></i>Last Month
                    </a>
                    <a class="dropdown-item" href="#" id="setLastQuarter">
                        <i class="fas fa-calendar-alt mr-2"></i>Last Quarter
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" id="setAllTime">
                        <i class="fas fa-infinity mr-2"></i>All Time
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="admin_report.php" id="reportForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date" class="font-weight-bold">Start Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date" class="font-weight-bold">End Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="course_id" class="font-weight-bold">Course Filter</label>
                            <select class="form-control select2" id="course_id" name="course_id">
                                <option value="">All Courses</option>
                                <?php foreach ($courses as $c): ?>
                                <option value="<?= $c['ID'] ?>"><?= htmlspecialchars($c['Course_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="submit" name="generate" class="btn btn-primary btn-block">
                            <i class="fas fa-search mr-2"></i>Generate
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if (isset($_POST['generate'])): ?>
    <?php
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $courseId = $_POST['course_id'];

    $params = [':start' => $startDate, ':end' => $endDate];
    $query = "SELECT e.*, s.STD_name AS student_name, c.Course_name 
              FROM enrollments e
              JOIN students s ON e.Student_ID = s.ID
              JOIN courses c ON e.course_id = c.ID
              WHERE e.enrollment_date BETWEEN :start AND :end";

    if (!empty($courseId)) {
        $query .= " AND e.course_id = :courseId";
        $params[':courseId'] = $courseId;
    }

    $query .= " ORDER BY e.enrollment_date DESC";

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results):
        $_SESSION['report_results'] = $results;
        $_SESSION['report_filters'] = $_POST;
    ?>
    <!-- Results Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-2"></i>Report Results
            </h6>
            <div>
                <form method="post" action="generate_pdf.php" class="d-inline">
                    <input type="hidden" name="download_pdf" value="1">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i>Export PDF
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                Showing <?= count($results) ?> records between <?= $startDate ?> and <?= $endDate ?>
                <?= !empty($courseId) ? 'for selected course' : 'across all courses' ?>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="reportTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Enrollment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $index => $row): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($row['student_name']) ?></td>
                            <td><?= htmlspecialchars($row['Course_name']) ?></td>
                            <td><?= htmlspecialchars($row['enrollment_date']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        No enrollment records found for the selected criteria.
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>

<!-- JavaScript for enhanced UI -->
<script>
$(document).ready(function() {
    // Initialize select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: "Select a course"
    });

    // Set default dates
    $('#setLastMonth').click(function(e) {
        e.preventDefault();
        const end = new Date();
        const start = new Date();
        start.setMonth(end.getMonth() - 1);
        
        $('#start_date').val(start.toISOString().split('T')[0]);
        $('#end_date').val(end.toISOString().split('T')[0]);
    });

    $('#setLastQuarter').click(function(e) {
        e.preventDefault();
        const end = new Date();
        const start = new Date();
        start.setMonth(end.getMonth() - 3);
        
        $('#start_date').val(start.toISOString().split('T')[0]);
        $('#end_date').val(end.toISOString().split('T')[0]);
    });

    $('#setAllTime').click(function(e) {
        e.preventDefault();
        $('#start_date').val('2010-01-01');
        $('#end_date').val(new Date().toISOString().split('T')[0]);
    });

    // Set default to last month
    $('#setLastMonth').trigger('click');
});

function exportToExcel() {
    // You can implement Excel export using SheetJS or similar library
    alert('Excel export functionality would be implemented here');
    // window.location = 'export_excel.php'; // You could create a separate export file
}
</script>