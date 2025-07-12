<?php
include 'includes/functions.php';
if (isset($_POST['Course'])) {
    global $conn;
    $course_id = $_POST['Course'];
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT ID, Section_name FROM sections WHERE Course_ID = :course_id and is_deleted =0");
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();

        $options = "<option value=''>Select Section</option>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $options .= "<option value='{$row['ID']}'>{$row['Section_name']}</option>";
        }

        echo $options;
    }
