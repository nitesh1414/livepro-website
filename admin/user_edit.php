<?php
$admin_title = isset($_GET['id']) ? 'Edit User' : 'Add User';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';
require_admin();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$user = ['username' => '', 'email' => '', 'role' => 'editor', 'is_active' => 1];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $db = $stmt->fetch();
    if ($db) $user = $db;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'editor';
    $password = $_POST['password'] ?? '';
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $errors = [];
    if (empty($username) || empty($email)) {
        $errors[] = 'Username and email are required.';
    }

    if (!empty($password) && strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if ($id) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id != ? LIMIT 1");
        $stmt->execute([$username, $id]);
    } else {
        if (empty($password)) $errors[] = 'Password is required for new users.';
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
    }

    if ($stmt->fetch()) {
        $errors[] = 'Username already exists.';
    }

    if (empty($errors)) {
        if ($id) {
            if (!empty($password)) {
                $stmt = $pdo->prepare("UPDATE users SET username=?, email=?, password=?, role=?, is_active=? WHERE id=?");
                $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $role, $is_active, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET username=?, email=?, role=?, is_active=? WHERE id=?");
                $stmt->execute([$username, $email, $role, $is_active, $id]);
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $role, $is_active]);
            $id = $pdo->lastInsertId();
        }
        set_flash('success', 'User saved successfully.');
        redirect(admin_url('user_edit.php?id=' . $id));
    } else {
        set_flash('danger', implode('<br>', $errors));
    }

    $user['username'] = $username;
    $user['email'] = $email;
    $user['role'] = $role;
    $user['is_active'] = $is_active;
}
?>

<h4 class="fw-bold mb-4"><?php echo $id ? 'Edit' : 'Add'; ?> User</h4>

<div class="card admin-card">
    <div class="card-body">
        <form method="POST" action="">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo sanitize($user['username']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo sanitize($user['email']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" <?php echo $id ? '' : 'required'; ?>>
                    <?php if ($id): ?><small class="text-muted">Leave blank to keep current password</small><?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Role</label>
                    <select name="role" class="form-select">
                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="editor" <?php echo $user['role'] === 'editor' ? 'selected' : ''; ?>>Editor</option>
                    </select>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-livepro">Save User</button>
                <a href="<?php echo admin_url('users.php'); ?>" class="btn btn-outline-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
