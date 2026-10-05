<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * Client Testimonials & Alumni Feedback CRUD Manager (admin/testimonials.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Testimonial deleted successfully.", "success");
    header("Location: testimonials.php");
    exit;
}

// HANDLE SAVE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $quote = trim($_POST['quote'] ?? '');
    $rating = intval($_POST['rating'] ?? 5);
    $type = $_POST['type'] ?? 'Client';
    $display_order = intval($_POST['display_order'] ?? 10);

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE testimonials SET name = ?, role = ?, quote = ?, rating = ?, type = ?, display_order = ? WHERE id = ?");
        $stmt->execute([$name, $role, $quote, $rating, $type, $display_order, $id]);
        flash_message("🎉 Testimonial from '{$name}' updated successfully!", "success");
    } else {
        $stmt = $pdo->prepare("INSERT INTO testimonials (name, role, quote, rating, type, display_order) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $role, $quote, $rating, $type, $display_order]);
        flash_message("🎉 New Testimonial added successfully!", "success");
    }
    header("Location: testimonials.php");
    exit;
}

$admin_page = 'testimonials';
require_once __DIR__ . '/includes/header.php';

// VIEW FORM: ADD OR EDIT
if ($action === 'new' || $action === 'edit'):
    $test = ['name' => '', 'role' => '', 'quote' => '', 'rating' => 5, 'type' => 'Client', 'display_order' => 10];
    if ($action === 'edit' && $id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
        $stmt->execute([$id]);
        $test = $stmt->fetch();
        if (!$test) {
            flash_message("Testimonial not found.", "error");
            header("Location: testimonials.php");
            exit;
        }
    }
?>
    <div class="admin-card" style="max-width: 700px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: #0f172a;">
          <?= $action === 'edit' ? '✏️ Edit Testimonial' : '➕ Add Client/Alumni Testimonial'; ?>
        </h3>
        <a href="testimonials.php" class="btn" style="background: #f1f5f9; color: #475569; text-decoration: none; font-size: 0.85rem;">&larr; Back to List</a>
      </div>

      <form method="POST" action="testimonials.php?<?= $action === 'edit' ? "action=edit&id={$id}" : "action=new"; ?>">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Person Full Name *</label>
            <input type="text" name="name" value="<?= htmlspecialchars($test['name']); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Role / Organization or College *</label>
            <input type="text" name="role" value="<?= htmlspecialchars($test['role']); ?>" placeholder="e.g. IT Director, Infosys" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Feedback Type *</label>
            <select name="type" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; background: white;">
              <option value="Client" <?= $test['type'] === 'Client' ? 'selected' : ''; ?>>Corporate Client</option>
              <option value="Student Alumni" <?= $test['type'] === 'Student Alumni' ? 'selected' : ''; ?>>Student Alumni</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Star Rating *</label>
            <select name="rating" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; background: white;">
              <option value="5" <?= intval($test['rating']) === 5 ? 'selected' : ''; ?>>⭐⭐⭐⭐⭐ (5 Stars)</option>
              <option value="4" <?= intval($test['rating']) === 4 ? 'selected' : ''; ?>>⭐⭐⭐⭐ (4 Stars)</option>
              <option value="3" <?= intval($test['rating']) === 3 ? 'selected' : ''; ?>>⭐⭐⭐ (3 Stars)</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Display Order</label>
            <input type="number" name="display_order" value="<?= intval($test['display_order']); ?>" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="margin-bottom: 30px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Quote / Testimonial Body *</label>
          <textarea name="quote" rows="4" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;"><?= htmlspecialchars($test['quote']); ?></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
          <a href="testimonials.php" class="btn" style="background: #f1f5f9; color: #475569; text-decoration: none;">Cancel</a>
          <button type="submit" class="btn" style="background: #059669; color: white; padding: 12px 30px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
            💾 Save Testimonial
          </button>
        </div>
      </form>
    </div>

<?php else: 
    // LIST VIEW
    $testimonials = get_testimonials('all');
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: #0f172a;">Client &amp; Student Testimonials Database</h3>
          <p style="color: #64748b; font-size: 0.85rem; margin: 4px 0 0 0;">Total feedback records: <?= count($testimonials); ?></p>
        </div>
        <a href="testimonials.php?action=new" class="btn" style="background: #059669; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: 700;">+ Add Testimonial</a>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Person Name</th>
              <th>Role / Organization</th>
              <th>Type</th>
              <th>Rating</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($testimonials)): ?>
              <tr><td colspan="6" style="text-align: center; padding: 30px; color: #64748b;">No testimonials found. Click Add Testimonial above.</td></tr>
            <?php else: ?>
              <?php foreach ($testimonials as $tst): ?>
                <tr>
                  <td style="color: #64748b; font-weight: 700;">#<?= intval($tst['display_order'] ?? 0); ?></td>
                  <td><strong style="color: #0f172a; font-size: 1.05rem;"><?= htmlspecialchars($tst['name']); ?></strong></td>
                  <td style="color: #334155;"><?= htmlspecialchars($tst['role']); ?></td>
                  <td><span class="badge <?= $tst['type'] === 'Client' ? 'badge-primary' : 'badge-accent'; ?>"><?= htmlspecialchars($tst['type']); ?></span></td>
                  <td style="color: #f59e0b;"><?= str_repeat('★', intval($tst['rating'] ?? 5)); ?></td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="testimonials.php?action=edit&id=<?= $tst['id']; ?>" class="btn" style="background: #f0fdf4; color: #059669; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Edit</a>
                      <a href="testimonials.php?action=delete&id=<?= $tst['id']; ?>" onclick="return confirm('Delete this testimonial permanently?')" class="btn" style="background: #fef2f2; color: #dc2626; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
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
