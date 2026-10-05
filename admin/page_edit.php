<?php
$admin_title = 'Edit Page';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';

$slug = $_GET['slug'] ?? '';
// Allow editing inactive pages too
$stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ? LIMIT 1");
$stmt->execute([$slug]);
$page = $stmt->fetch();

if (!$page) {
    set_flash('danger', 'Page not found.');
    redirect(admin_url('pages.php'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'] ?? $page['title'],
        'meta_description' => $_POST['meta_description'] ?? '',
        'meta_keywords' => $_POST['meta_keywords'] ?? '',
        'content' => $_POST['content'] ?? '',
        'is_active' => isset($_POST['is_active']) ? 1 : 0
    ];

    if (update_page($pdo, $slug, $data)) {
        set_flash('success', 'Page updated successfully.');
        redirect(admin_url('page_edit.php?slug=' . $slug));
    } else {
        set_flash('danger', 'Failed to update page.');
    }

    $page = array_merge($page, $data);
}
?>

<h4 class="fw-bold mb-4">Edit Page: <?php echo sanitize($page['title']); ?></h4>

<div class="card admin-card">
    <div class="card-body">
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label fw-bold">Page Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo sanitize($page['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Meta Description</label>
                <textarea name="meta_description" rows="2" class="form-control"><?php echo sanitize($page['meta_description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control" value="<?php echo sanitize($page['meta_keywords']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Page Content</label>
                <textarea name="content" class="form-control tinymce"><?php echo htmlentities($page['content'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" <?php echo $page['is_active'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-livepro">Save</button>
                <a href="<?php echo admin_url('pages.php'); ?>" class="btn btn-outline-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
