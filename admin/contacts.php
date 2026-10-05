<?php
$admin_title = 'Contact Messages';
require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/admin_sidebar.php';

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM contact_messages WHERE id = ?")->execute([$id]);
    set_flash('success', 'Message deleted.');
    redirect(admin_url('contacts.php'));
}

if (isset($_GET['mark'])) {
    $id = (int) $_GET['mark'];
    $status = $_GET['status'] ?? 'read';
    $pdo->prepare("UPDATE contact_messages SET status = ? WHERE id = ?")->execute([$status, $id]);
    set_flash('success', 'Status updated.');
    redirect(admin_url('contacts.php'));
}

$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
?>

<h4 class="fw-bold mb-4">Contact Messages</h4>

<div class="card admin-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                    <tr>
                        <td><?php echo date('d M Y H:i', strtotime($msg['created_at'])); ?></td>
                        <td><strong><?php echo sanitize($msg['name']); ?></strong></td>
                        <td><a href="mailto:<?php echo sanitize($msg['email']); ?>"><?php echo sanitize($msg['email']); ?></a></td>
                        <td><?php echo sanitize($msg['phone']); ?></td>
                        <td><?php echo sanitize($msg['subject']); ?></td>
                        <td><span class="badge bg-<?php echo $msg['status'] === 'new' ? 'danger' : ($msg['status'] === 'replied' ? 'success' : 'secondary'); ?>"><?php echo ucfirst($msg['status']); ?></span></td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#msg<?php echo $msg['id']; ?>">View</button>
                            <?php if ($msg['status'] === 'new'): ?>
                            <a href="<?php echo admin_url('contacts.php?mark=' . $msg['id'] . '&status=read'); ?>" class="btn btn-sm btn-success">Mark Read</a>
                            <?php endif; ?>
                            <a href="<?php echo admin_url('contacts.php?delete=' . $msg['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (empty($messages)): ?>
        <p class="text-muted mb-0">No messages yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php foreach ($messages as $msg): ?>
<div class="modal fade" id="msg<?php echo $msg['id']; ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message from <?php echo sanitize($msg['name']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Email:</strong> <a href="mailto:<?php echo sanitize($msg['email']); ?>"><?php echo sanitize($msg['email']); ?></a></p>
                <p><strong>Phone:</strong> <?php echo sanitize($msg['phone']); ?></p>
                <p><strong>Subject:</strong> <?php echo sanitize($msg['subject']); ?></p>
                <p><strong>Date:</strong> <?php echo date('d M Y H:i', strtotime($msg['created_at'])); ?></p>
                <hr>
                <p><?php echo nl2br(sanitize($msg['message'])); ?></p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo admin_url('contacts.php?mark=' . $msg['id'] . '&status=read'); ?>" class="btn btn-success">Mark as Read</a>
                <a href="<?php echo admin_url('contacts.php?mark=' . $msg['id'] . '&status=replied'); ?>" class="btn btn-primary">Mark as Replied</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
