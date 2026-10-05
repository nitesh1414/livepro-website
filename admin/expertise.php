<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (Facebook Color Scheme)
 * Technological Expertise & Stack CRUD Manager (admin/expertise.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM expertise_areas WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Expertise area deleted successfully.", "success");
    header("Location: expertise.php");
    exit;
}

// HANDLE SAVE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'Core Engineering');
    $description = trim($_POST['description'] ?? '');
    $tech_list = trim($_POST['tech_list'] ?? 'React, Node, Java, AWS');
    $icon = $_POST['icon'] ?? 'code';
    $proficiency = intval($_POST['proficiency'] ?? 95);
    $status = $_POST['status'] ?? 'active';
    $display_order = intval($_POST['display_order'] ?? 10);

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE expertise_areas SET title = ?, category = ?, description = ?, tech_list = ?, icon = ?, proficiency = ?, status = ?, display_order = ? WHERE id = ?");
        $stmt->execute([$title, $category, $description, $tech_list, $icon, $proficiency, $status, $display_order, $id]);
        flash_message("🎉 Expertise Area '{$title}' updated successfully!", "success");
    } else {
        $stmt = $pdo->prepare("INSERT INTO expertise_areas (title, category, description, tech_list, icon, proficiency, status, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $category, $description, $tech_list, $icon, $proficiency, $status, $display_order]);
        flash_message("🎉 New Expertise Area '{$title}' created successfully!", "success");
    }
    header("Location: expertise.php");
    exit;
}

$admin_page = 'expertise';
require_once __DIR__ . '/includes/header.php';

// VIEW FORM: ADD OR EDIT
if ($action === 'new' || $action === 'edit'):
    $exp = ['title' => '', 'category' => 'Core Engineering', 'description' => '', 'tech_list' => 'React.js, Node.js, Spring Boot, AWS', 'icon' => 'code', 'proficiency' => 95, 'status' => 'active', 'display_order' => 10];
    if ($action === 'edit' && $id > 0) {
        $exp = get_expertise_by_id($id);
        if (!$exp) {
            flash_message("Expertise entry not found.", "error");
            header("Location: expertise.php");
            exit;
        }
    }
?>
    <div class="admin-card" style="max-width: 800px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: var(--text-main);">
          <?= $action === 'edit' ? '✏️ Edit Technological Expertise' : '➕ Add Technological Expertise'; ?>
        </h3>
        <a href="expertise.php" class="btn" style="background: var(--bg-subtle); color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">Back</a>
      </div>

      <form method="POST" action="expertise.php?<?= $action === 'edit' ? "action=edit&id={$id}" : "action=new"; ?>">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Expertise Domain Title *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($exp['title']); ?>" placeholder="e.g. Enterprise Backend & Microservices" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; font-weight: 700;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Category Group *</label>
            <select name="category" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: white;">
              <option value="Core Engineering" <?= $exp['category'] === 'Core Engineering' ? 'selected' : ''; ?>>Core</option>
              <option value="Cloud DevOps" <?= $exp['category'] === 'Cloud DevOps' ? 'selected' : ''; ?>>Cloud</option>
              <option value="AI & Intelligence" <?= $exp['category'] === 'AI & Intelligence' ? 'selected' : ''; ?>>AI &amp; Intelligence</option>
              <option value="Embedded Hardware" <?= $exp['category'] === 'Embedded Hardware' ? 'selected' : ''; ?>>Hardware</option>
              <option value="Quality Assurance" <?= $exp['category'] === 'Quality Assurance' ? 'selected' : ''; ?>>Quality</option>
            </select>
          </div>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Description &amp; Engineering Standards *</label>
          <textarea name="description" rows="3" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem;"><?= htmlspecialchars($exp['description']); ?></textarea>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Technology Stack / Tools (Comma separated) *</label>
          <input type="text" name="tech_list" value="<?= htmlspecialchars($exp['tech_list']); ?>" placeholder="e.g. Java 17, Spring Boot, Node.js, Python, Docker" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; font-family: monospace;">
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 30px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Proficiency Level (%)</label>
            <input type="number" name="proficiency" min="1" max="100" value="<?= intval($exp['proficiency']); ?>" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; font-weight: 700; color: var(--primary);">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Icon Identifier</label>
            <select name="icon" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: white;">
              <option value="code" <?= $exp['icon'] === 'code' ? 'selected' : ''; ?>>💻 Code</option>
              <option value="server" <?= $exp['icon'] === 'server' ? 'selected' : ''; ?>>🖥️ Server</option>
              <option value="cloud" <?= $exp['icon'] === 'cloud' ? 'selected' : ''; ?>>☁️ Cloud</option>
              <option value="cpu" <?= $exp['icon'] === 'cpu' ? 'selected' : ''; ?>>🤖 AI / Hardware</option>
              <option value="award" <?= $exp['icon'] === 'award' ? 'selected' : ''; ?>>🏆 Quality</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Status</label>
            <select name="status" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: white;">
              <option value="active" <?= $exp['status'] === 'active' ? 'selected' : ''; ?>>Active (Published)</option>
              <option value="draft" <?= $exp['status'] === 'draft' ? 'selected' : ''; ?>>Draft (Hidden)</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Display Order</label>
            <input type="number" name="display_order" value="<?= intval($exp['display_order']); ?>" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
          <a href="expertise.php" class="btn" style="background: var(--bg-subtle); color: var(--text-muted); text-decoration: none;">Cancel</a>
          <button type="submit" class="btn" style="background: var(--primary); color: white; padding: 12px 30px; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">Save</button>
        </div>
      </form>
    </div>

<?php else: 
    // LIST VIEW
    $expertise = get_expertise_areas('all');
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: var(--text-main);">Technological Expertise &amp; Stack Database</h3>
          <p style="color: var(--text-muted); font-size: 0.85rem; margin: 4px 0 0 0;">Total mastery domains: <?= count($expertise); ?></p>
        </div>
        <a href="expertise.php?action=new" class="btn" style="background: var(--primary); color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: 700;">Add</a>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Domain Title</th>
              <th>Category</th>
              <th>Proficiency</th>
              <th>Tech Stack Tags</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($expertise)): ?>
              <tr><td colspan="7" style="text-align: center; padding: 30px; color: var(--text-muted);">No expertise domains found. Click Add Expertise Area above.</td></tr>
            <?php else: ?>
              <?php foreach ($expertise as $exp): ?>
                <tr>
                  <td style="color: var(--text-muted); font-weight: 700;">#<?= intval($exp['display_order']); ?></td>
                  <td><strong style="color: var(--text-main); font-size: 1.05rem;"><?= htmlspecialchars($exp['title']); ?></strong></td>
                  <td><span class="badge badge-primary"><?= htmlspecialchars($exp['category']); ?></span></td>
                  <td><strong style="color: var(--primary); font-size: 1.05rem;"><?= intval($exp['proficiency']); ?>%</strong></td>
                  <td style="max-width: 250px; font-size: 0.8rem; color: var(--text-muted); font-family: monospace;"><?= htmlspecialchars($exp['tech_list']); ?></td>
                  <td>
                    <span class="badge <?= $exp['status'] === 'active' ? 'badge-accent' : 'badge-warning'; ?>">
                      <?= strtoupper(htmlspecialchars($exp['status'])); ?>
                    </span>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="expertise.php?action=edit&id=<?= $exp['id']; ?>" class="btn" style="background: var(--primary-soft); color: var(--primary); padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Edit</a>
                      <a href="expertise.php?action=delete&id=<?= $exp['id']; ?>" onclick="return confirm('Delete this expertise area permanently?')" class="btn" style="background: var(--danger-soft); color: var(--danger); padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
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
