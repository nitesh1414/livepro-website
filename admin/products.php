<?php
$admin_title = 'Manage Products';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    // Get product image before deleting
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    if ($product && !empty($product['image'])) {
        delete_image($product['image']);
    }
    $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
    set_flash('success', 'Product deleted.');
    redirect(admin_url('products.php'));
}

if (isset($_GET['toggle'])) {
    $id = (int) $_GET['toggle'];
    $pdo->prepare("UPDATE products SET is_active = NOT is_active WHERE id = ?")->execute([$id]);
    set_flash('success', 'Status updated.');
    redirect(admin_url('products.php'));
}

$products = $pdo->query("SELECT * FROM products ORDER BY order_sort ASC, id ASC")->fetchAll();
?>

<h4 class="fw-bold mb-4">Manage Products</h4>

<a href="<?php echo admin_url('product_edit.php'); ?>" class="btn btn-livepro mb-3">Add</a>

<div class="card admin-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">No products found. Add your first product!</td></tr>
                    <?php endif; ?>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td>
                            <?php if (!empty($p['image'])): ?>
                            <img src="<?php echo (strpos($p['image'], 'http') === 0) ? $p['image'] : assets_url($p['image']); ?>" class="thumb" alt="">
                            <?php else: ?>
                            <span class="text-muted"><i class="material-icons">image</i></span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo sanitize($p['title']); ?></strong></td>
                        <td><?php echo !empty($p['category']) ? '<span class="badge bg-info">' . sanitize($p['category']) . '</span>' : '-'; ?></td>
                        <td><?php echo !empty($p['price']) ? sanitize($p['price']) : '-'; ?></td>
                        <td><?php echo $p['order_sort']; ?></td>
                        <td>
                            <a href="<?php echo admin_url('products.php?toggle=' . $p['id']); ?>" class="badge bg-<?php echo $p['is_active'] ? 'success' : 'secondary'; ?> text-decoration-none"><?php echo $p['is_active'] ? 'Active' : 'Inactive'; ?></a>
                        </td>
                        <td>
                            <a href="<?php echo admin_url('product_edit.php?id=' . $p['id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="<?php echo base_url('products.php'); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="<?php echo admin_url('products.php?delete=' . $p['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
