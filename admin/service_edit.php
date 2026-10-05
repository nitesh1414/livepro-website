<?php
$admin_title = isset($_GET['id']) ? 'Edit Service' : 'Add Service';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$service = ['title' => '', 'description' => '', 'icon' => 'code', 'order_sort' => 0, 'is_active' => 1];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $db = $stmt->fetch();
    if ($db) $service = $db;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $icon = $_POST['icon'] ?? 'code';
    $order_sort = (int) ($_POST['order_sort'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if ($id) {
        $stmt = $pdo->prepare("UPDATE services SET title=?, description=?, icon=?, order_sort=?, is_active=? WHERE id=?");
        $stmt->execute([$title, $description, $icon, $order_sort, $is_active, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO services (title, description, icon, order_sort, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $icon, $order_sort, $is_active]);
        $id = $pdo->lastInsertId();
    }

    set_flash('success', 'Service saved successfully.');
    redirect(admin_url('service_edit.php?id=' . $id));
}

$icons = ['code', 'mobile', 'trending_up', 'support', 'security', 'home', 'school', 'cloud', 'web', 'storage', 'integration_instructions', 'network_check', 'dashboard', 'speed', 'design_services'];
?>

<h4 class="fw-bold mb-4"><?php echo $id ? 'Edit' : 'Add'; ?> Service</h4>

<div class="card admin-card">
    <div class="card-body">
        <form method="POST" action="">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Service Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo sanitize($service['title']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Icon</label>
                    <select name="icon" class="form-select">
                        <?php foreach ($icons as $icon): ?>
                        <option value="<?php echo $icon; ?>" <?php echo $service['icon'] === $icon ? 'selected' : ''; ?>><?php echo $icon; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Material icon name</small>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" rows="5" class="form-control tinymce"><?php echo htmlentities($service['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Order</label>
                    <input type="number" name="order_sort" class="form-control" value="<?php echo $service['order_sort']; ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" <?php echo $service['is_active'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-livepro">Save Service</button>
                <a href="<?php echo admin_url('services.php'); ?>" class="btn btn-outline-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
