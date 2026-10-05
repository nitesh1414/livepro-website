<?php
$admin_title = 'Manage Users';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';
require_admin();

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    if ($id == $_SESSION['user_id']) {
        set_flash('danger', 'You cannot delete your own account.');
    } else {
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
        set_flash('success', 'User deleted.');
    }
    redirect(admin_url('users.php'));
}

if (isset($_GET['toggle'])) {
    $id = (int) $_GET['toggle'];
    if ($id == $_SESSION['user_id']) {
        set_flash('danger', 'You cannot deactivate your own account.');
    } else {
        $pdo->prepare("UPDATE users SET is_active = NOT is_active WHERE id = ?")->execute([$id]);
        set_flash('success', 'Status updated.');
    }
    redirect(admin_url('users.php'));
}

$users = $pdo->query("SELECT * FROM users ORDER BY id ASC")->fetchAll();
?>

<h4 class="fw-bold mb-4">Manage Admin Users</h4>

<a href="<?php echo admin_url('user_edit.php'); ?>" class="btn btn-livepro mb-3">Add New User</a>

<div class="card admin-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td><strong><?php echo sanitize($u['username']); ?></strong></td>
                        <td><?php echo sanitize($u['email']); ?></td>
                        <td><?php echo ucfirst($u['role']); ?></td>
                        <td>
                            <a href="<?php echo admin_url('users.php?toggle=' . $u['id']); ?>" class="badge bg-<?php echo $u['is_active'] ? 'success' : 'secondary'; ?> text-decoration-none"><?php echo $u['is_active'] ? 'Active' : 'Inactive'; ?></a>
                        </td>
                        <td>
                            <a href="<?php echo admin_url('user_edit.php?id=' . $u['id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                            <?php if ($u['id'] != $_SESSION['user_id']): ?>
                            <a href="<?php echo admin_url('users.php?delete=' . $u['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
