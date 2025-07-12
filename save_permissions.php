<?php
include 'includes/connection.php';
if (isset($_POST['btn_save_permissions'])) {
    $user_id = intval($_POST['user_id']);
    $permissions = implode(',', array_merge(
        array_keys($_POST['permissions']['access'] ?? []),
        array_map(fn($submenu_id) => 'insert-' . $submenu_id, array_keys($_POST['permissions']['insert'] ?? [])),
        array_map(fn($submenu_id) => 'update-' . $submenu_id, array_keys($_POST['permissions']['update'] ?? [])),
        array_map(fn($submenu_id) => 'delete-' . $submenu_id, array_keys($_POST['permissions']['delete'] ?? []))
    ));

    // Update permissions in the database
    $stmt = $conn->prepare("UPDATE users SET permissions = :permissions WHERE id = :user_id");
    $stmt->execute(['permissions' => $permissions, 'user_id' => $user_id]);

    echo "<script>alert('Permissions updated successfully!');window.location.href = 'Modifyusers.php';</script>";
}


?>