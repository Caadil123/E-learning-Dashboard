<?php
include 'includes/init.php';

$userRole = readcolumn('users', 'role_id', $_SESSION['userId']);
$userId = $_SESSION['userId'];

// Common WHERE clause for queries based on user role
$courseFilter = ($userRole == 2) ? " AND courses.instructor_id = $userId" : "";

// Get course enrollment data
$enrollmentQuery = "SELECT courses.Course_name, COUNT(enrollments.Student_ID) AS total_students
          FROM courses
          JOIN enrollments ON courses.ID = enrollments.course_id 
          WHERE courses.is_deleted = 0 $courseFilter
          GROUP BY courses.Course_name
          ORDER BY total_students DESC
          LIMIT 5";

$enrollmentStmt = $conn->query($enrollmentQuery);
$enrollmentResult = $enrollmentStmt->fetchAll(PDO::FETCH_ASSOC);

// Get course rating data
$ratingQuery = "SELECT courses.Course_name, AVG(rating.rating_number) AS avg_rating
               FROM courses
               JOIN rating ON courses.ID = rating.course_id
               WHERE courses.is_deleted = 0 $courseFilter
               GROUP BY courses.Course_name
               HAVING COUNT(rating.id) > 3
               ORDER BY avg_rating DESC
               LIMIT 5";

$ratingStmt = $conn->query($ratingQuery);
$ratingResult = $ratingStmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for charts
$enrollmentLabels = $enrollmentData = $ratingLabels = $ratingData = [];

foreach ($enrollmentResult as $row) {
    $enrollmentLabels[] = $row['Course_name'];
    $enrollmentData[] = $row['total_students'];
}

foreach ($ratingResult as $row) {
    $ratingLabels[] = $row['Course_name'];
    $ratingData[] = round($row['avg_rating'], 1);
}

// Modify stats queries based on user role
$totalStudentsQuery = "SELECT COUNT(*) FROM students";
$totalCategoriesQuery = "SELECT COUNT(*) FROM categories";
$totalCoursesQuery = "SELECT COUNT(*) 
                      FROM courses c
                      JOIN categories cat ON c.category_ID = cat.ID
                      WHERE c.is_deleted = 0 
                      AND cat.is_deleted = 0"
                      . ($userRole == 2 ? " AND c.instructor_id = $userId" : "");
$totalInstructorsQuery = "SELECT COUNT(*) FROM users" . ($userRole == 2 ? " WHERE id = $userId" : "");

$totalStudents = $conn->query($totalStudentsQuery)->fetchColumn();
$totalCategories = $conn->query($totalCategoriesQuery)->fetchColumn();
$totalCourses = $conn->query($totalCoursesQuery)->fetchColumn();
$totalInstructors = $conn->query($totalInstructorsQuery)->fetchColumn();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $userRole == 1 ? 'Admin' : "Instructor" ?> Dashboard</h1>
        <div class="d-none d-sm-inline-block">
            <span class="text-muted">Last updated: <?= date('F j, Y H:i') ?></span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">

        <!-- Total Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?php echo ($userRole == 1) ? 'Students' : 'Students in My Courses'; ?>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                if ($userRole == 1) {
                                    // Admin sees total students
                                    echo countRows('students');
                                } else {
                                    // Instructor sees only students in their courses
                                    $instructorStudentsQuery = "SELECT COUNT(DISTINCT e.Student_ID) 
                                               FROM enrollments e
                                               JOIN courses c ON e.course_id = c.ID
                                               WHERE c.instructor_id = $userId";
                                    echo $conn->query($instructorStudentsQuery)->fetchColumn();
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Categories Card -->
        <?php if ($userRole == 1): ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Categories</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalCategories ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-th-large fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <!-- <div class="mt-2 text-xs">
                            <span class="text-muted"><?= rand(2, 8) ?> active</span>
                        </div> -->
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Total Courses Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total <?= $userRole == 2 ? 'My Courses' : 'Courses' ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalCourses ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <!-- <div class="mt-2 text-xs">
                        <span class="text-info font-weight-bold"><?= rand(3, 9) ?> new</span> this month
                    </div> -->
                </div>
            </div>
        </div>

        <!-- Total Instructors Card -->
        <?php if ($userRole == 1): ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Instructors</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalInstructors ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <!-- <div class="mt-2 text-xs">
                            <span class="text-warning font-weight-bold"><?= rand(1, 5) ?> active</span> today
                        </div> -->
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Charts Row -->
    <div class="row">

        <!-- Enrollment Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-graduate mr-2"></i>Top <?= $userRole == 2 ? 'My Courses' : 'Courses' ?> by
                        Enrollment
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Chart Options:</div>
                            <a class="dropdown-item" href="#" onclick="changeChartType('enrollmentChart', 'bar')">Bar
                                Chart</a>
                            <a class="dropdown-item" href="#" onclick="changeChartType('enrollmentChart', 'pie')">Pie
                                Chart</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="downloadChart('enrollmentChart')">Export
                                Image</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="enrollmentChart" height="250"></canvas>
                    </div>
                    <div class="mt-4 small text-muted">
                        Showing top 5 most enrolled <?= $userRole == 2 ? 'of my courses' : 'courses' ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ratings Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-star mr-2"></i>Top Rated <?= $userRole == 2 ? 'My Courses' : 'Courses' ?>
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Chart Options:</div>
                            <a class="dropdown-item" href="#" onclick="changeChartType('ratingChart', 'bar')">Bar
                                Chart</a>
                            <a class="dropdown-item" href="#" onclick="changeChartType('ratingChart', 'radar')">Radar
                                Chart</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="downloadChart('ratingChart')">Export Image</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="ratingChart" height="250"></canvas>
                    </div>
                    <div class="mt-4 small text-muted">
                        Showing top 5 highest rated <?= $userRole == 2 ? 'of my courses' : 'courses' ?> (minimum 4
                        ratings)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <?php if ($userRole == 1): // Only show for admin ?>
        <!-- Recent Activity Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-history mr-2"></i>Recent Activity
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Activity</th>
                                        <th>User</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $activityQuery = "
                                    (SELECT 
                                        e.enrollment_date AS activity_date,
                                        'Enrollment' AS activity_type,
                                        s.STD_name AS username,
                                        CONCAT('Enrolled in ', c.Course_name) AS details
                                    FROM enrollments e
                                    JOIN students s ON e.Student_ID = s.ID
                                    JOIN courses c ON e.course_id = c.ID
                                    ORDER BY e.enrollment_date DESC
                                    LIMIT 2)
                                    
                                    UNION
                                    
                                    (SELECT 
                                        r.create_at AS activity_date,
                                        'Rating' AS activity_type,
                                        s.STD_name AS username,
                                        CONCAT('Rated ', c.Course_name, ' ', r.rating_number, ' stars') AS details
                                    FROM rating r
                                    JOIN students s ON r.user_id = s.ID
                                    JOIN courses c ON r.course_id = c.ID
                                    ORDER BY r.create_at DESC
                                    LIMIT 2)
                                    
                                    UNION
                                    
                                    (SELECT 
                                        c.updated_at AS activity_date,
                                        'New Course' AS activity_type,
                                        u.username,
                                        CONCAT('Assigned \"', c.Course_name, '\" course') AS details
                                    FROM courses c
                                    JOIN users u ON c.instructor_id = u.id
                                    ORDER BY c.updated_at DESC
                                    LIMIT 1)
                                    
                                    ORDER BY activity_date DESC
                                    LIMIT 5
                                ";

                                    $activityStmt = $conn->query($activityQuery);
                                    $activities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($activities) > 0):
                                        foreach ($activities as $activity):
                                            ?>
                                            <tr>
                                                <td><?= date('Y-m-d H:i', strtotime($activity['activity_date'])) ?></td>
                                                <td><?= htmlspecialchars($activity['activity_type']) ?></td>
                                                <td><?= htmlspecialchars($activity['username']) ?></td>
                                                <td><?= htmlspecialchars($activity['details']) ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No recent activities found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>
<!-- /.container-fluid -->

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<!-- Chart Rendering -->
<script>
    // Enrollment Chart
    var enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
    var enrollmentChart = new Chart(enrollmentCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($enrollmentLabels); ?>,
            datasets: [{
                label: 'Number of Students',
                data: <?php echo json_encode($enrollmentData); ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: Math.round,
                    font: {
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Students'
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Rating Chart
    var ratingCtx = document.getElementById('ratingChart').getContext('2d');
    var ratingChart = new Chart(ratingCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($ratingLabels); ?>,
            datasets: [{
                label: 'Average Rating',
                data: <?php echo json_encode($ratingData); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: function (value) {
                        return value + ' ★';
                    },
                    font: {
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    title: {
                        display: true,
                        text: 'Average Rating (1-5)'
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Chart utility functions
    function changeChartType(chartId, type) {
        if (chartId === 'enrollmentChart') {
            enrollmentChart.config.type = type;
            enrollmentChart.update();
        } else if (chartId === 'ratingChart') {
            ratingChart.config.type = type;
            ratingChart.update();
        }
    }

    function downloadChart(chartId) {
        const link = document.createElement('a');
        link.download = chartId + '.png';

        if (chartId === 'enrollmentChart') {
            link.href = enrollmentChart.toBase64Image();
        } else if (chartId === 'ratingChart') {
            link.href = ratingChart.toBase64Image();
        }

        link.click();
    }
</script>

<?php include 'includes/footer.php'; ?>