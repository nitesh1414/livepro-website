<?php
$admin_title = isset($_GET['id']) ? 'Edit Carousel Slide' : 'Add Carousel Slide';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$item = ['title' => '', 'subtitle' => '', 'description' => '', 'image' => '', 'button_text' => '', 'button_link' => '', 'order_sort' => 0, 'is_active' => 1];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM carousel WHERE id = ?");
    $stmt->execute([$id]);
    $db_item = $stmt->fetch();
    if ($db_item) $item = $db_item;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $subtitle = $_POST['subtitle'] ?? '';
    $description = $_POST['description'] ?? '';
    $button_text = $_POST['button_text'] ?? '';
    $button_link = $_POST['button_link'] ?? '';
    $order_sort = (int) ($_POST['order_sort'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $image = $item['image'];

    if (!empty($_FILES['image']['name'])) {
        $upload = upload_image($_FILES['image'], 'carousel');
        if ($upload['success']) {
            if ($id && $image) delete_image($image);
            $image = $upload['path'];
        } else {
            set_flash('danger', $upload['message']);
        }
    }

    if ($id) {
        $stmt = $pdo->prepare("UPDATE carousel SET title=?, subtitle=?, description=?, image=?, button_text=?, button_link=?, order_sort=?, is_active=? WHERE id=?");
        $stmt->execute([$title, $subtitle, $description, $image, $button_text, $button_link, $order_sort, $is_active, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO carousel (title, subtitle, description, image, button_text, button_link, order_sort, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $subtitle, $description, $image, $button_text, $button_link, $order_sort, $is_active]);
        $id = $pdo->lastInsertId();
    }

    set_flash('success', 'Carousel slide saved successfully.');
    redirect(admin_url('carousel_edit.php?id=' . $id));
}
?>

<h4 class="fw-bold mb-4"><?php echo $id ? 'Edit' : 'Add'; ?> Carousel Slide</h4>

<div class="card admin-card">
    <div class="card-body">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo sanitize($item['title']); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Subtitle</label>
                    <input type="text" name="subtitle" class="form-control" value="<?php echo sanitize($item['subtitle']); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" rows="3" class="form-control"><?php echo sanitize($item['description']); ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Button Text</label>
                    <input type="text" name="button_text" class="form-control" value="<?php echo sanitize($item['button_text']); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Button Link</label>
                    <input type="text" name="button_link" class="form-control" value="<?php echo sanitize($item['button_link']); ?>" placeholder="e.g. contact.php or #">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <?php if ($item['image']): ?>
                    <div class="mt-2">
                        <img src="<?php echo (strpos($item['image'], 'http') === 0) ? $item['image'] : assets_url($item['image']); ?>" alt="" class="thumb">
                        <small class="text-muted d-block">Current image</small>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Order</label>
                    <input type="number" name="order_sort" class="form-control" value="<?php echo $item['order_sort']; ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" <?php echo $item['is_active'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-livepro">Save</button>
                <a href="<?php echo admin_url('carousel.php'); ?>" class="btn btn-outline-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
