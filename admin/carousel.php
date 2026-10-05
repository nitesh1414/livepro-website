<?php
$admin_title = 'Manage Carousel';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM carousel WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        delete_image($item['image']);
        $pdo->prepare("DELETE FROM carousel WHERE id = ?")->execute([$id]);
        set_flash('success', 'Carousel slide deleted.');
    }
    redirect(admin_url('carousel.php'));
}

if (isset($_GET['toggle'])) {
    $id = (int) $_GET['toggle'];
    $pdo->prepare("UPDATE carousel SET is_active = NOT is_active WHERE id = ?")->execute([$id]);
    set_flash('success', 'Status updated.');
    redirect(admin_url('carousel.php'));
}

$items = $pdo->query("SELECT * FROM carousel ORDER BY order_sort ASC, id ASC")->fetchAll();
?>

<h4 class="fw-bold mb-4">Manage Hero Carousel</h4>

<a href="<?php echo admin_url('carousel_edit.php'); ?>" class="btn btn-livepro mb-3">Add</a>

<div class="card admin-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <?php if ($item['image']): ?>
                            <img src="<?php echo (strpos($item['image'], 'http') === 0) ? $item['image'] : assets_url($item['image']); ?>" alt="" class="thumb">
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo sanitize($item['title']); ?></strong></td>
                        <td><?php echo sanitize($item['subtitle']); ?></td>
                        <td><?php echo $item['order_sort']; ?></td>
                        <td>
                            <a href="<?php echo admin_url('carousel.php?toggle=' . $item['id']); ?>" class="badge bg-<?php echo $item['is_active'] ? 'success' : 'secondary'; ?> text-decoration-none"><?php echo $item['is_active'] ? 'Active' : 'Inactive'; ?></a>
                        </td>
                        <td>
                            <a href="<?php echo admin_url('carousel_edit.php?id=' . $item['id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="<?php echo admin_url('carousel.php?delete=' . $item['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (empty($items)): ?>
        <p class="text-muted">No carousel slides found. <a href="<?php echo admin_url('carousel_edit.php'); ?>">Add</a>.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
