<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme
 * Enterprise Case Studies & Analyst Reports CRUD Manager (admin/casestudies.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM case_studies WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Case Study deleted successfully.", "success");
    header("Location: casestudies.php");
    exit;
}

// HANDLE SAVE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $client_industry = trim($_POST['client_industry'] ?? 'Banking & Financial Services');
    $metric_highlight = trim($_POST['metric_highlight'] ?? '40% Efficiency Boost');
    $summary = trim($_POST['summary'] ?? '');
    $full_details = trim($_POST['full_details'] ?? '');
    $display_order = intval($_POST['display_order'] ?? 10);
    $status = $_POST['status'] ?? 'active';

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE case_studies SET title = ?, client_industry = ?, metric_highlight = ?, summary = ?, full_details = ?, display_order = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $client_industry, $metric_highlight, $summary, $full_details, $display_order, $status, $id]);
        flash_message("🎉 Case Study '{$title}' updated successfully!", "success");
    } else {
        $stmt = $pdo->prepare("INSERT INTO case_studies (title, client_industry, metric_highlight, summary, full_details, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $client_industry, $metric_highlight, $summary, $full_details, $display_order, $status]);
        flash_message("🎉 New Case Study created successfully!", "success");
    }
    header("Location: casestudies.php");
    exit;
}

$admin_page = 'casestudies';
require_once __DIR__ . '/includes/header.php';

// VIEW FORM: ADD OR EDIT
if ($action === 'new' || $action === 'edit'):
    $cs = ['title' => '', 'client_industry' => 'Banking & Financial Services', 'metric_highlight' => '40% Speed Boost', 'summary' => '', 'full_details' => '', 'display_order' => 10, 'status' => 'active'];
    if ($action === 'edit' && $id > 0) {
        $cs = get_case_study_by_id($id);
        if (!$cs) {
            flash_message("Case study not found.", "error");
            header("Location: casestudies.php");
            exit;
        }
    }
?>
    <div class="admin-card" style="max-width: 800px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: #0f172a;">
          <?= $action === 'edit' ? '✏️ Edit Enterprise Case Study' : '➕ Add Enterprise Case Study'; ?>
        </h3>
        <a href="casestudies.php" class="btn" style="background: #f1f5f9; color: #475569; text-decoration: none; font-size: 0.85rem;">&larr; Back to List</a>
      </div>

      <form method="POST" action="casestudies.php?<?= $action === 'edit' ? "action=edit&id={$id}" : "action=new"; ?>">
        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Case Study Headline Title *</label>
          <input type="text" name="title" value="<?= htmlspecialchars($cs['title']); ?>" placeholder="e.g. Core Banking System Re-Engineering & API Decoupling" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 700;">
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Client Industry Domain *</label>
            <input type="text" name="client_industry" value="<?= htmlspecialchars($cs['client_industry']); ?>" placeholder="e.g. Banking & Financial Services" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Key Metric Highlight *</label>
            <input type="text" name="metric_highlight" value="<?= htmlspecialchars($cs['metric_highlight']); ?>" placeholder="e.g. 40% Speed Boost" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 700; color: #059669;">
          </div>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Executive Summary (for Homepage Cards) *</label>
          <textarea name="summary" rows="3" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;"><?= htmlspecialchars($cs['summary']); ?></textarea>
        </div>

        <div style="margin-bottom: 25px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Full Transformation Details &amp; Results *</label>
          <textarea name="full_details" rows="5" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;"><?= htmlspecialchars($cs['full_details']); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Status</label>
            <select name="status" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; background: white;">
              <option value="active" <?= $cs['status'] === 'active' ? 'selected' : ''; ?>>Active (Published)</option>
              <option value="draft" <?= $cs['status'] === 'draft' ? 'selected' : ''; ?>>Draft (Hidden)</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Display Order</label>
            <input type="number" name="display_order" value="<?= intval($cs['display_order']); ?>" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
          <a href="casestudies.php" class="btn" style="background: #f1f5f9; color: #475569; text-decoration: none;">Cancel</a>
          <button type="submit" class="btn" style="background: #2563eb; color: white; padding: 12px 30px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
            💾 Save Case Study
          </button>
        </div>
      </form>
    </div>

<?php else: 
    // LIST VIEW
    $studies = get_case_studies('all');
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: #0f172a;">Enterprise Case Studies &amp; Client Impact Database</h3>
          <p style="color: #64748b; font-size: 0.85rem; margin: 4px 0 0 0;">Total transformation reports: <?= count($studies); ?></p>
        </div>
        <a href="casestudies.php?action=new" class="btn" style="background: #2563eb; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: 700;">+ Add Case Study</a>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Headline Title</th>
              <th>Industry Domain</th>
              <th>Metric Impact</th>
              <th>Executive Summary</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($studies)): ?>
              <tr><td colspan="7" style="text-align: center; padding: 30px; color: #64748b;">No case studies found. Click Add Case Study above.</td></tr>
            <?php else: ?>
              <?php foreach ($studies as $cs): ?>
                <tr>
                  <td style="color: #64748b; font-weight: 700;">#<?= intval($cs['display_order']); ?></td>
                  <td><strong style="color: #0f172a; font-size: 1rem;"><?= htmlspecialchars($cs['title']); ?></strong></td>
                  <td><span class="badge badge-primary"><?= htmlspecialchars($cs['client_industry']); ?></span></td>
                  <td><span class="badge badge-accent" style="font-size: 0.85rem;"><?= htmlspecialchars($cs['metric_highlight']); ?></span></td>
                  <td style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #64748b; font-size: 0.9rem;"><?= htmlspecialchars($cs['summary']); ?></td>
                  <td>
                    <span class="badge <?= $cs['status'] === 'active' ? 'badge-accent' : 'badge-warning'; ?>">
                      <?= strtoupper(htmlspecialchars($cs['status'])); ?>
                    </span>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="casestudies.php?action=edit&id=<?= $cs['id']; ?>" class="btn" style="background: #eff6ff; color: #2563eb; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Edit</a>
                      <a href="casestudies.php?action=delete&id=<?= $cs['id']; ?>" onclick="return confirm('Delete this case study permanently?')" class="btn" style="background: #fef2f2; color: #dc2626; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
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
