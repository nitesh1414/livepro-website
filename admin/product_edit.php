<?php
$admin_title = isset($_GET['id']) ? 'Edit Product' : 'Add Product';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = [
    'title' => '', 'short_description' => '', 'description' => '', 'image' => '',
    'price' => '', 'category' => '', 'features' => '', 'button_text' => 'Learn More',
    'button_link' => '', 'order_sort' => 0, 'is_active' => 1
];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $db = $stmt->fetch();
    if ($db) $product = $db;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product['title'] = trim($_POST['title'] ?? '');
    $product['short_description'] = trim($_POST['short_description'] ?? '');
    $product['description'] = $_POST['description'] ?? '';
    $product['price'] = trim($_POST['price'] ?? '');
    $product['category'] = trim($_POST['category'] ?? '');
    $product['features'] = trim($_POST['features'] ?? '');
    $product['button_text'] = trim($_POST['button_text'] ?? 'Learn More');
    $product['button_link'] = trim($_POST['button_link'] ?? '');
    $product['order_sort'] = (int) ($_POST['order_sort'] ?? 0);
    $product['is_active'] = isset($_POST['is_active']) ? 1 : 0;

    if (empty($product['title'])) {
        set_flash('danger', 'Product title is required.');
        redirect(admin_url('product_edit.php' . ($id ? '?id=' . $id : '')));
    }

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $upload = upload_image($_FILES['image'], 'products');
        if ($upload['success']) {
            if ($id && !empty($product['image'])) {
                delete_image($product['image']);
            }
            $product['image'] = $upload['path'];
        } else {
            set_flash('danger', $upload['message']);
            redirect(admin_url('product_edit.php' . ($id ? '?id=' . $id : '')));
        }
    }

    if ($id) {
        $stmt = $pdo->prepare("UPDATE products SET title=?, short_description=?, description=?, image=?, price=?, category=?, features=?, button_text=?, button_link=?, order_sort=?, is_active=? WHERE id=?");
        $stmt->execute([
            $product['title'], $product['short_description'], $product['description'],
            $product['image'], $product['price'], $product['category'], $product['features'],
            $product['button_text'], $product['button_link'], $product['order_sort'],
            $product['is_active'], $id
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (title, short_description, description, image, price, category, features, button_text, button_link, order_sort, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $product['title'], $product['short_description'], $product['description'],
            $product['image'], $product['price'], $product['category'], $product['features'],
            $product['button_text'], $product['button_link'], $product['order_sort'],
            $product['is_active']
        ]);
        $id = $pdo->lastInsertId();
    }

    set_flash('success', 'Product saved successfully.');
    redirect(admin_url('product_edit.php?id=' . $id));
}

$categories = ['Enterprise', 'Sales & Marketing', 'Education', 'eCommerce', 'Human Resource', 'Mobile App', 'Other'];
?>

<h4 class="fw-bold mb-4"><?php echo $id ? 'Edit' : 'Add'; ?> Product</h4>

<div class="card admin-card">
    <div class="card-body">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Product Title *</label>
                    <input type="text" name="title" class="form-control" value="<?php echo sanitize($product['title']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category" class="form-select">
                        <option value="">-- Select --</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat; ?>" <?php echo $product['category'] === $cat ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Short Description</label>
                    <input type="text" name="short_description" class="form-control" value="<?php echo sanitize($product['short_description']); ?>" maxlength="500" placeholder="Brief description shown in product cards">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Price / Pricing Label</label>
                    <input type="text" name="price" class="form-control" value="<?php echo sanitize($product['price']); ?>" placeholder="e.g. Contact for Pricing">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Full Description (Rich Text)</label>
                    <textarea name="description" rows="8" class="form-control tinymce"><?php echo htmlentities($product['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Key Features (one per line)</label>
                    <textarea name="features" rows="6" class="form-control" placeholder="Enter each feature on a new line&#10;e.g. User Authentication&#10;Payment Gateway&#10;Analytics Dashboard"><?php echo sanitize($product['features']); ?></textarea>
                    <small class="text-muted">Each line will be displayed as a bullet point on the product page.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Product Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <?php if (!empty($product['image'])): ?>
                    <div class="mt-2">
                        <img src="<?php echo (strpos($product['image'], 'http') === 0) ? $product['image'] : assets_url($product['image']); ?>" alt="" height="80" class="rounded">
                        <small class="text-muted d-block">Current image</small>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Button Text</label>
                    <input type="text" name="button_text" class="form-control" value="<?php echo sanitize($product['button_text']); ?>" placeholder="Learn More">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Button Link</label>
                    <input type="text" name="button_link" class="form-control" value="<?php echo sanitize($product['button_link']); ?>" placeholder="contact.php or https://...">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Display Order</label>
                    <input type="number" name="order_sort" class="form-control" value="<?php echo $product['order_sort']; ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" <?php echo $product['is_active'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_active">Active (visible on site)</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-livepro">Save Product</button>
                <a href="<?php echo admin_url('products.php'); ?>" class="btn btn-outline-secondary">Back to Products</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
