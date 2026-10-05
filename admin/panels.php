<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme
 * Feature Panels & Capabilities CRUD Manager (admin/panels.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);
$filter_group = $_GET['group'] ?? 'all';

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM feature_panels WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Feature Panel deleted successfully.", "success");
    header("Location: panels.php");
    exit;
}

// HANDLE SAVE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $panel_group = $_POST['panel_group'] ?? 'why_us';
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $icon = $_POST['icon'] ?? 'check';
    $link_text = trim($_POST['link_text'] ?? 'Learn More');
    $link_url = trim($_POST['link_url'] ?? 'about.php');
    $display_order = intval($_POST['display_order'] ?? 10);
    $status = $_POST['status'] ?? 'active';

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE feature_panels SET panel_group = ?, title = ?, description = ?, icon = ?, link_text = ?, link_url = ?, display_order = ?, status = ? WHERE id = ?");
        $stmt->execute([$panel_group, $title, $description, $icon, $link_text, $link_url, $display_order, $status, $id]);
        flash_message("🎉 Feature Panel '{$title}' updated successfully!", "success");
    } else {
        $stmt = $pdo->prepare("INSERT INTO feature_panels (panel_group, title, description, icon, link_text, link_url, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$panel_group, $title, $description, $icon, $link_text, $link_url, $display_order, $status]);
        flash_message("🎉 New Feature Panel created successfully!", "success");
    }
    header("Location: panels.php");
    exit;
}

$admin_page = 'panels';
require_once __DIR__ . '/includes/header.php';

// VIEW FORM: ADD OR EDIT
if ($action === 'new' || $action === 'edit'):
    $panel = ['panel_group' => 'why_us', 'title' => '', 'description' => '', 'icon' => 'check', 'link_text' => 'Learn More', 'link_url' => 'about.php', 'display_order' => 10, 'status' => 'active'];
    if ($action === 'edit' && $id > 0) {
        $panel = get_panel_by_id($id);
        if (!$panel) {
            flash_message("Panel not found.", "error");
            header("Location: panels.php");
            exit;
        }
    }
?>
    <div class="admin-card" style="max-width: 800px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: var(--text-main);">
          <?= $action === 'edit' ? '✏️ Edit Feature / Value Panel' : '➕ Add Feature / Value Panel'; ?>
        </h3>
        <a href="panels.php" class="btn" style="background: var(--bg-subtle); color: var(--text-body); text-decoration: none; font-size: 0.85rem;">Back</a>
      </div>

      <form method="POST" action="panels.php?<?= $action === 'edit' ? "action=edit&id={$id}" : "action=new"; ?>">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Panel Section Group *</label>
            <select name="panel_group" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; background: white;">
              <option value="why_us" <?= $panel['panel_group'] === 'why_us' ? 'selected' : ''; ?>>🏢 Why Choose Us / Methodologies</option>
              <option value="capabilities" <?= $panel['panel_group'] === 'capabilities' ? 'selected' : ''; ?>>⚡ Cutting-Edge Capabilities (TCS Style)</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Panel Title Headline *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($panel['title']); ?>" placeholder="e.g. Agile Client Engagement" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; font-weight: 700;">
          </div>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Panel Description Content *</label>
          <textarea name="description" rows="3" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;"><?= htmlspecialchars($panel['description']); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Link Text *</label>
            <input type="text" name="link_text" value="<?= htmlspecialchars($panel['link_text']); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Link Destination URL *</label>
            <input type="text" name="link_url" value="<?= htmlspecialchars($panel['link_url']); ?>" placeholder="about.php or services.php" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Icon Identifier</label>
            <select name="icon" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; background: white;">
              <option value="check" <?= $panel['icon'] === 'check' ? 'selected' : ''; ?>>✔ Checkmark</option>
              <option value="code" <?= $panel['icon'] === 'code' ? 'selected' : ''; ?>>💻 Code / Dev</option>
              <option value="refresh" <?= $panel['icon'] === 'refresh' ? 'selected' : ''; ?>>🔄 Re-Engineering</option>
              <option value="award" <?= $panel['icon'] === 'award' ? 'selected' : ''; ?>>🏆 Quality Award</option>
              <option value="globe" <?= $panel['icon'] === 'globe' ? 'selected' : ''; ?>>🌐 Global Reach</option>
              <option value="cpu" <?= $panel['icon'] === 'cpu' ? 'selected' : ''; ?>>🤖 AI &amp; Hardware</option>
              <option value="cloud" <?= $panel['icon'] === 'cloud' ? 'selected' : ''; ?>>☁️ Cloud Server</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Status</label>
            <select name="status" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; background: white;">
              <option value="active" <?= $panel['status'] === 'active' ? 'selected' : ''; ?>>Active (Published)</option>
              <option value="draft" <?= $panel['status'] === 'draft' ? 'selected' : ''; ?>>Draft (Hidden)</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Display Order</label>
            <input type="number" name="display_order" value="<?= intval($panel['display_order']); ?>" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
          <a href="panels.php" class="btn" style="background: var(--bg-subtle); color: var(--text-body); text-decoration: none;">Cancel</a>
          <button type="submit" class="btn" style="background: var(--primary); color: white; padding: 12px 30px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">Save</button>
        </div>
      </form>
    </div>

<?php else: 
    // LIST VIEW
    $panels = get_feature_panels($filter_group, 'all');
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: var(--text-main);">Feature Panels &amp; Capabilities Database</h3>
          <p style="color: var(--text-muted); font-size: 0.85rem; margin: 4px 0 0 0;">Total active panels: <?= count($panels); ?></p>
        </div>

        <div style="display: flex; align-items: center; gap: 10px;">
          <span style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted);">Filter Group:</span>
          <select onchange="window.location.href='panels.php?group=' + this.value" style="padding: 8px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.9rem; font-weight: 600; background: white;">
            <option value="all" <?= $filter_group === 'all' ? 'selected' : ''; ?>>All Groups</option>
            <option value="why_us" <?= $filter_group === 'why_us' ? 'selected' : ''; ?>>🏢 Why Choose Us</option>
            <option value="capabilities" <?= $filter_group === 'capabilities' ? 'selected' : ''; ?>>⚡ TCS Capabilities</option>
          </select>
          <a href="panels.php?action=new" class="btn" style="background: var(--primary); color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: 700;">Add</a>
        </div>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Section Group</th>
              <th>Headline Title</th>
              <th>Description Snippet</th>
              <th>Link Destination</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($panels)): ?>
              <tr><td colspan="7" style="text-align: center; padding: 30px; color: var(--text-muted);">No feature panels found matching filter.</td></tr>
            <?php else: ?>
              <?php foreach ($panels as $pnl): ?>
                <tr>
                  <td style="color: var(--text-muted); font-weight: 700;">#<?= intval($pnl['display_order']); ?></td>
                  <td><span class="badge <?= $pnl['panel_group'] === 'why_us' ? 'badge-primary' : 'badge-accent'; ?>"><?= htmlspecialchars($pnl['panel_group']); ?></span></td>
                  <td><strong style="color: var(--text-main); font-size: 1rem;"><?= htmlspecialchars($pnl['title']); ?></strong></td>
                  <td style="max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-muted); font-size: 0.9rem;"><?= htmlspecialchars($pnl['description']); ?></td>
                  <td><a href="<?= htmlspecialchars($pnl['link_url']); ?>" style="color: var(--primary); font-size: 0.85rem; text-decoration: none; font-weight: 600;"><?= htmlspecialchars($pnl['link_text']); ?> &rarr;</a></td>
                  <td>
                    <span class="badge <?= $pnl['status'] === 'active' ? 'badge-accent' : 'badge-warning'; ?>">
                      <?= strtoupper(htmlspecialchars($pnl['status'])); ?>
                    </span>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="panels.php?action=edit&id=<?= $pnl['id']; ?>" class="btn" style="background: var(--primary-soft); color: var(--primary); padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Edit</a>
                      <a href="panels.php?action=delete&id=<?= $pnl['id']; ?>" onclick="return confirm('Delete this panel permanently?')" class="btn" style="background: var(--danger-soft); color: var(--danger); padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
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
