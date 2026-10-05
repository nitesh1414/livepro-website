<?php
$admin_title = 'Manage Pages';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';

$pages = get_all_pages($pdo);
?>

<h4 class="fw-bold mb-4">Manage Pages</h4>

<div class="card admin-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Meta Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $p): ?>
                    <tr>
                        <td><strong><?php echo sanitize($p['title']); ?></strong></td>
                        <td><code><?php echo sanitize($p['slug']); ?></code></td>
                        <td><?php echo sanitize(truncate($p['meta_description'], 60)); ?></td>
                        <td>
                            <?php if ($p['is_active']): ?>
                            <span class="badge bg-success">Active</span>
                            <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo admin_url('page_edit.php?slug=' . $p['slug']); ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="<?php echo base_url($p['slug'] === 'home' ? 'index.php' : $p['slug'] . '.php'); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
