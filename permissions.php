<?php
include 'includes/connection.php';
include 'includes/functions.php';
if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
    // Fetch the user's permissions from the database
    // $role_id = readcolumn('users', "role_id", $user_id);
    $stmt = $conn->prepare("SELECT permissions FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $permissions = $stmt->fetchColumn();
    $permissions_array = explode(',', $permissions); // Assuming permissions are stored as a comma-separated string

    // Return the permissions as JSON
    echo json_encode(['permissions' => $permissions_array]);
}
?>

