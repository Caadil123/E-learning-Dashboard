<?Php
include 'includes/connection.php';
// include 'includes/functions.php';

// $roles = $conn->query("SELECT * FROM role")->fetchAll();


// Fetch all menus and submenus
$menus = $conn->query("
    SELECT 
        menus.id AS menu_id, 
        menus.name AS menu_name, 
        menus.icon, 
        submenus.id AS submenu_id, 
        submenus.label, 
        submenus.href
    FROM menus
    LEFT JOIN submenus 
        ON menus.id = submenus.menu_id 
        AND submenus.is_deleted = 0
    WHERE menus.is_deleted = 0
    ORDER BY menus.id
")->fetchAll(PDO::FETCH_GROUP);

?>


<div class="modal fade" id="privleges" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form id="permission-form" action="save_permissions.php" method="post">
    <!-- Add this hidden input to store the user ID -->
    <input type="hidden" name="user_id" value="">

    <div class="modal-header">
        <h1 class="modal-title fs-5" id="addCategoryModalLabel">Manage Permissions</h1>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
    </div>

    <div class="modal-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Page/Action</th>
                    <th>Access</th>  <!-- For Page Access -->
                    <th>Insert</th>  <!-- Action: Insert -->
                    <th>Update</th>  <!-- Action: Update -->
                    <th>Delete</th>  <!-- Action: Delete -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menus as $menu_id => $submenus): ?>
                    <?php foreach ($submenus as $submenu): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($submenu['label']); ?></td>
                            <td><input type="checkbox" name="permissions[access][<?php echo $submenu['submenu_id']; ?>]" value="<?php echo $submenu['submenu_id']; ?>"></td>
                            <td><input type="checkbox" name="permissions[insert][<?php echo $submenu['submenu_id']; ?>]" value="insert-<?php echo $submenu['submenu_id']; ?>"></td>
                            <td><input type="checkbox" name="permissions[update][<?php echo $submenu['submenu_id']; ?>]" value="update-<?php echo $submenu['submenu_id']; ?>"></td>
                            <td><input type="checkbox" name="permissions[delete][<?php echo $submenu['submenu_id']; ?>]" value="delete-<?php echo $submenu['submenu_id']; ?>"></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="btn_save_permissions" class="btn btn-primary" value="Save">
    </div>
</form>
        </div>
    </div>
</div>


<script>
function loadUserPermissions(userId) {
    // Clear all checkboxes before loading new permissions
    document.querySelectorAll('#privleges input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });

    // Fetch user permissions via AJAX or update the modal content dynamically
    fetch(`permissions.php?user_id=${userId}`)
    .then(response => response.json())
    .then(data => {
        document.querySelectorAll('#privleges input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = data.permissions.includes(checkbox.value);
        });

        // Update the hidden field in the modal form
        document.querySelector('#permission-form input[name="user_id"]').value = userId;
    })
    .catch(error => console.error('Error fetching user permissions:', error));
}

</script>