<?Php
include 'includes/init.php';

// displaying only teacher his course sections
$userID = $_SESSION['userId'];
$userRoleID = readcolumn('users', 'role_id', $_SESSION['userId']);
$usercourses = GetCourseId('courses', "Instructor_Id=$userID");

// Print the array of course IDs to debug
// print_r($usercourses);

// If $usercourses is an array, convert it to a comma-separated string
if (is_array($usercourses) && !empty($usercourses)) {
    $courseIDs = implode(',', $usercourses);  // Convert array to a comma-separated string
} else {
    $courseIDs = 'NULL';  // Handle the case when no courses are found
}

// Use the formatted $courseIDs in your query
$results = $userRoleID == 2 ? read_where('quiz_results', "Course_ID IN ($courseIDs)") : read('quiz_results');

// Fetch quiz results
// $results = read('quiz_results');

// function getDynamicStudentQuizResults()
// {
//     global $conn;
//     $sql = "
//         SELECT 
//             u.id AS user_id,
//             u.STD_name AS student_name,
//             q.id AS quiz_id,
//             q.title AS quiz_title,
//             q.description AS quiz_description,
//             COUNT(que.id) AS total_questions,
//             SUM(CASE WHEN a.is_correct = 1 THEN 1 ELSE 0 END) AS correct_answers,
//             COUNT(que.id) AS max_score
//         FROM students u
//         JOIN user_responses ur ON ur.user_id = u.id
//         JOIN questions que ON ur.question_id = que.id
//         JOIN answers a ON ur.selected_answer_id = a.id
//         JOIN quizzes q ON que.quiz_id = q.id
//         GROUP BY u.id, q.id
//         ORDER BY u.STD_name, q.title
//     ";

//     $stmt = $conn->prepare($sql);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Quiz results</h1>
    <!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Quiz results</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Course name</th>
                            <th>Quiz title</th>
                            <th>Score</th>
                            <th>Completed</th>
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
                        <?php foreach ($results as $result): ?>
                            <tr>
                                <td><?= htmlspecialchars(readcolumn('students', 'STD_name', $result['user_id'])); ?></td>
                                <td><?= htmlspecialchars(readcolumn('courses', 'Course_name', $result['course_id'])); ?></td>
                                <td><?= htmlspecialchars(readcolumn('quizzes', 'title', $result['quiz_id'])); ?></td>
                                <td><?= htmlspecialchars($result['score']); ?> %</td>
                                <td><?= htmlspecialchars($result['completed_at']); ?></td>
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