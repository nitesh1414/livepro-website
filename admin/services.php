<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * IT Services CRUD Manager (admin/services.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ IT Service deleted successfully.", "success");
    header("Location: services.php");
    exit;
}

// HANDLE SAVE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? 'Corporate IT';
    $short_desc = trim($_POST['short_desc'] ?? '');
    $full_desc = trim($_POST['full_desc'] ?? '');
    $icon = $_POST['icon'] ?? 'code';
    $status = $_POST['status'] ?? 'active';
    $display_order = intval($_POST['display_order'] ?? 10);

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE services SET title = ?, category = ?, short_desc = ?, full_desc = ?, icon = ?, status = ?, display_order = ? WHERE id = ?");
        $stmt->execute([$title, $category, $short_desc, $full_desc, $icon, $status, $display_order, $id]);
        flash_message("🎉 IT Service '{$title}' updated successfully!", "success");
    } else {
        $stmt = $pdo->prepare("INSERT INTO services (title, category, short_desc, full_desc, icon, status, display_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $category, $short_desc, $full_desc, $icon, $status, $display_order]);
        flash_message("🎉 New IT Service '{$title}' created successfully!", "success");
    }
    header("Location: services.php");
    exit;
}

$admin_page = 'services';
require_once __DIR__ . '/includes/header.php';

// VIEW FORM: ADD OR EDIT
if ($action === 'new' || $action === 'edit'):
    $service = ['title' => '', 'category' => 'Corporate IT', 'short_desc' => '', 'full_desc' => '', 'icon' => 'code', 'status' => 'active', 'display_order' => 10];
    if ($action === 'edit' && $id > 0) {
        $service = get_service_by_id($id);
        if (!$service) {
            flash_message("Service not found.", "error");
            header("Location: services.php");
            exit;
        }
    }
?>
    <div class="admin-card" style="max-width: 800px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: var(--text-main);">
          <?= $action === 'edit' ? '✏️ Edit IT Service' : '➕ Add New IT Service'; ?>
        </h3>
        <a href="services.php" class="btn" style="background: var(--bg-subtle); color: var(--text-body); text-decoration: none; font-size: 0.85rem;">Back</a>
      </div>

      <form method="POST" action="services.php?<?= $action === 'edit' ? "action=edit&id={$id}" : "action=new"; ?>">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Service Title *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($service['title']); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Category *</label>
            <select name="category" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; background: white;">
              <option value="Corporate IT" <?= $service['category'] === 'Corporate IT' ? 'selected' : ''; ?>>Corporate IT</option>
              <option value="Academic & Training" <?= $service['category'] === 'Academic & Training' ? 'selected' : ''; ?>>Academic &amp; Training</option>
            </select>
          </div>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Short Summary (for Homepage &amp; Cards) *</label>
          <textarea name="short_desc" rows="2" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;"><?= htmlspecialchars($service['short_desc']); ?></textarea>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Full Comprehensive Description (for Popup Modals) *</label>
          <textarea name="full_desc" rows="5" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;"><?= htmlspecialchars($service['full_desc']); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Icon Identifier</label>
            <select name="icon" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; background: white;">
              <option value="code" <?= $service['icon'] === 'code' ? 'selected' : ''; ?>>💻 Code / Development</option>
              <option value="server" <?= $service['icon'] === 'server' ? 'selected' : ''; ?>>🖥️ Server / Hardware</option>
              <option value="refresh" <?= $service['icon'] === 'refresh' ? 'selected' : ''; ?>>🔄 Re-Engineering / Migrate</option>
              <option value="network" <?= $service['icon'] === 'network' ? 'selected' : ''; ?>>🌐 Network / Security</option>
              <option value="book" <?= $service['icon'] === 'book' ? 'selected' : ''; ?>>📚 Education / Academic</option>
              <option value="award" <?= $service['icon'] === 'award' ? 'selected' : ''; ?>>🏆 Corporate Training</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Status</label>
            <select name="status" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; background: white;">
              <option value="active" <?= $service['status'] === 'active' ? 'selected' : ''; ?>>Active (Published)</option>
              <option value="draft" <?= $service['status'] === 'draft' ? 'selected' : ''; ?>>Draft (Hidden)</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Display Order</label>
            <input type="number" name="display_order" value="<?= intval($service['display_order']); ?>" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
          <a href="services.php" class="btn" style="background: var(--bg-subtle); color: var(--text-body); text-decoration: none;">Cancel</a>
          <button type="submit" class="btn" style="background: var(--primary); color: white; padding: 12px 30px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">Save</button>
        </div>
      </form>
    </div>

<?php else: 
    // LIST VIEW
    $services = get_services('all');
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: var(--text-main);">IT &amp; Software Services Database</h3>
          <p style="color: var(--text-muted); font-size: 0.85rem; margin: 4px 0 0 0;">Total active services: <?= count($services); ?></p>
        </div>
        <a href="services.php?action=new" class="btn" style="background: var(--primary); color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: 700;">Add</a>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Service Title</th>
              <th>Category</th>
              <th>Summary</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($services)): ?>
              <tr><td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">No IT services found. Click Add New Service above.</td></tr>
            <?php else: ?>
              <?php foreach ($services as $srv): ?>
                <tr>
                  <td style="color: var(--text-muted); font-weight: 700;">#<?= intval($srv['display_order']); ?></td>
                  <td><strong style="color: var(--text-main); font-size: 1.05rem;"><?= htmlspecialchars($srv['title']); ?></strong></td>
                  <td><span class="badge <?= $srv['category'] === 'Corporate IT' ? 'badge-primary' : 'badge-accent'; ?>"><?= htmlspecialchars($srv['category']); ?></span></td>
                  <td style="max-width: 320px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-muted); font-size: 0.9rem;"><?= htmlspecialchars($srv['short_desc']); ?></td>
                  <td>
                    <span class="badge <?= $srv['status'] === 'active' ? 'badge-accent' : 'badge-warning'; ?>">
                      <?= strtoupper(htmlspecialchars($srv['status'])); ?>
                    </span>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="services.php?action=edit&id=<?= $srv['id']; ?>" class="btn" style="background: var(--primary-soft); color: var(--primary); padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Edit</a>
                      <a href="services.php?action=delete&id=<?= $srv['id']; ?>" onclick="return confirm('Delete this service permanently?')" class="btn" style="background: var(--danger-soft); color: var(--danger); padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
