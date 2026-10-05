<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme
 * Hero Carousel Banners CRUD Manager (admin/banners.php)
 * Supports Background Image File Uploads & Custom Paths
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM hero_banners WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Hero Carousel Banner deleted successfully.", "success");
    header("Location: banners.php");
    exit;
}

// HANDLE SAVE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $badge_text = trim($_POST['badge_text'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $cta_text = trim($_POST['cta_text'] ?? 'Learn More');
    $cta_url = trim($_POST['cta_url'] ?? 'services.php');
    $bg_image = trim($_POST['bg_image'] ?? 'assets/images/banner1.jpg');
    $bg_gradient = $_POST['bg_gradient'] ?? 'navy-blue';
    $display_order = intval($_POST['display_order'] ?? 10);
    $status = $_POST['status'] ?? 'active';

    // Handle Image File Upload if provided
    if (isset($_FILES['banner_file']) && $_FILES['banner_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../assets/images/banners/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_ext = strtolower(pathinfo($_FILES['banner_file']['name'], PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($file_ext, $allowed_exts)) {
            $new_filename = 'bnr-' . time() . '-' . rand(100, 999) . '.' . $file_ext;
            if (move_uploaded_file($_FILES['banner_file']['tmp_name'], $upload_dir . $new_filename)) {
                $bg_image = 'assets/images/banners/' . $new_filename;
            }
        }
    }

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE hero_banners SET badge_text = ?, title = ?, subtitle = ?, cta_text = ?, cta_url = ?, bg_image = ?, bg_gradient = ?, display_order = ?, status = ? WHERE id = ?");
        $stmt->execute([$badge_text, $title, $subtitle, $cta_text, $cta_url, $bg_image, $bg_gradient, $display_order, $status, $id]);
        flash_message("🎉 Hero Banner '{$title}' updated successfully with background image!", "success");
    } else {
        $stmt = $pdo->prepare("INSERT INTO hero_banners (badge_text, title, subtitle, cta_text, cta_url, bg_image, bg_gradient, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$badge_text, $title, $subtitle, $cta_text, $cta_url, $bg_image, $bg_gradient, $display_order, $status]);
        flash_message("🎉 New Hero Banner created successfully with background image!", "success");
    }
    header("Location: banners.php");
    exit;
}

$admin_page = 'banners';
require_once __DIR__ . '/includes/header.php';

// VIEW FORM: ADD OR EDIT
if ($action === 'new' || $action === 'edit'):
    $banner = ['badge_text' => 'ENTERPRISE IT', 'title' => '', 'subtitle' => '', 'cta_text' => 'Explore Solutions', 'cta_url' => 'services.php', 'bg_image' => 'assets/images/banner1.jpg', 'bg_gradient' => 'navy-blue', 'display_order' => 10, 'status' => 'active'];
    if ($action === 'edit' && $id > 0) {
        $banner = get_banner_by_id($id);
        if (!$banner) {
            flash_message("Banner not found.", "error");
            header("Location: banners.php");
            exit;
        }
    }
?>
    <div class="admin-card" style="max-width: 850px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #dddfe2; padding-bottom: 15px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: #050505;">
          <?= $action === 'edit' ? '✏️ Edit Hero Carousel Slide &amp; Background Image' : '➕ Add Hero Carousel Slide'; ?>
        </h3>
        <a href="banners.php" class="btn" style="background: #f0f2f5; color: #65676b; text-decoration: none; font-size: 0.85rem;">&larr; Back to List</a>
      </div>

      <form method="POST" action="banners.php?<?= $action === 'edit' ? "action=edit&id={$id}" : "action=new"; ?>" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Top Badge / Pillar Tag *</label>
            <input type="text" name="badge_text" value="<?= htmlspecialchars($banner['badge_text']); ?>" placeholder="e.g. PERPETUALLY ADAPTIVE IT" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Hero Headline Title *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($banner['title']); ?>" placeholder="e.g. Building on Belief: Enterprise AI & Systems Dev" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; font-weight: 700;">
          </div>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Hero Subtitle Description *</label>
          <textarea name="subtitle" rows="3" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;"><?= htmlspecialchars($banner['subtitle']); ?></textarea>
        </div>

        <!-- BACKGROUND IMAGE CONFIGURATION -->
        <div style="background: #f0f2f5; border: 1px solid #dddfe2; padding: 20px; border-radius: 8px; margin-bottom: 25px;">
          <h4 style="font-size: 1.05rem; font-weight: 800; color: #1877f2; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            🖼️ Carousel Background Image Settings
          </h4>
          <p style="font-size: 0.85rem; color: #65676b; margin-bottom: 15px;">You can either upload a new image file from your computer OR specify a relative/external image URL.</p>
          
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: center;">
            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Upload New Background Image File</label>
              <input type="file" name="banner_file" accept="image/*" style="background: white; padding: 10px; border: 1px dashed #ced0d4; border-radius: 6px; width: 100%;">
            </div>
            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Current Image Path / URL *</label>
              <input type="text" name="bg_image" value="<?= htmlspecialchars($banner['bg_image'] ?? 'assets/images/banner1.jpg'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; background: white;">
            </div>
          </div>
          <?php if (!empty($banner['bg_image'])): ?>
            <div style="margin-top: 15px; display: flex; align-items: center; gap: 12px;">
              <span style="font-size: 0.8rem; font-weight: 700; color: #65676b;">Current Preview:</span>
              <img src="../<?= htmlspecialchars($banner['bg_image']); ?>" style="width: 140px; height: 75px; object-fit: cover; border-radius: 6px; border: 2px solid #1877f2; box-shadow: 0 2px 6px rgba(0,0,0,0.15);" onerror="this.style.display='none';">
            </div>
          <?php endif; ?>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">CTA Button Text *</label>
            <input type="text" name="cta_text" value="<?= htmlspecialchars($banner['cta_text']); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">CTA Button URL Link *</label>
            <input type="text" name="cta_url" value="<?= htmlspecialchars($banner['cta_url']); ?>" placeholder="services.php or projects.php" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Overlay Tint Accent</label>
            <select name="bg_gradient" style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; background: white;">
              <option value="navy-blue" <?= $banner['bg_gradient'] === 'navy-blue' ? 'selected' : ''; ?>>🌌 Deep Tech Navy Tint</option>
              <option value="emerald-teal" <?= $banner['bg_gradient'] === 'emerald-teal' ? 'selected' : ''; ?>>🟢 Emerald Green Tint</option>
              <option value="purple-indigo" <?= $banner['bg_gradient'] === 'purple-indigo' ? 'selected' : ''; ?>>🟣 Enterprise Purple Tint</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Status</label>
            <select name="status" style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; background: white;">
              <option value="active" <?= $banner['status'] === 'active' ? 'selected' : ''; ?>>Active (Published)</option>
              <option value="draft" <?= $banner['status'] === 'draft' ? 'selected' : ''; ?>>Draft (Hidden)</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Display Order</label>
            <input type="number" name="display_order" value="<?= intval($banner['display_order']); ?>" style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
          <a href="banners.php" class="btn" style="background: #f0f2f5; color: #65676b; text-decoration: none;">Cancel</a>
          <button type="submit" class="btn" style="background: #1877f2; color: white; padding: 12px 30px; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">
            💾 Save Hero Slide &amp; Background Image
          </button>
        </div>
      </form>
    </div>

<?php else: 
    // LIST VIEW
    $banners = get_hero_banners('all');
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: #050505;">Hero Carousel Banners &amp; Background Images</h3>
          <p style="color: #65676b; font-size: 0.85rem; margin: 4px 0 0 0;">Total active slides: <?= count($banners); ?> (You can upload custom background images for each slide)</p>
        </div>
        <a href="banners.php?action=new" class="btn" style="background: #1877f2; color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: 700;">+ Add Carousel Slide</a>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Preview BG</th>
              <th>Badge Pillar</th>
              <th>Headline Title &amp; Subtitle</th>
              <th>CTA Button</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($banners)): ?>
              <tr><td colspan="7" style="text-align: center; padding: 30px; color: #65676b;">No hero banners found. Click Add Carousel Slide above.</td></tr>
            <?php else: ?>
              <?php foreach ($banners as $bnr): ?>
                <tr>
                  <td style="color: #65676b; font-weight: 700;">#<?= intval($bnr['display_order']); ?></td>
                  <td>
                    <img src="../<?= htmlspecialchars($bnr['bg_image'] ?? 'assets/images/banner1.jpg'); ?>" style="width: 85px; height: 48px; object-fit: cover; border-radius: 6px; border: 1px solid #dddfe2; box-shadow: 0 1px 3px rgba(0,0,0,0.1);" onerror="this.onerror=null; this.src='../assets/images/banner1.jpg';">
                  </td>
                  <td><span class="badge badge-primary"><?= htmlspecialchars($bnr['badge_text']); ?></span></td>
                  <td style="max-width: 260px;">
                    <strong style="color: #050505; font-size: 1rem; display: block; margin-bottom: 4px;"><?= htmlspecialchars($bnr['title']); ?></strong>
                    <span style="font-size: 0.85rem; color: #65676b; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= htmlspecialchars($bnr['subtitle']); ?></span>
                  </td>
                  <td><a href="<?= htmlspecialchars($bnr['cta_url']); ?>" style="color: #1877f2; font-weight: 700; font-size: 0.85rem; text-decoration: none;"><?= htmlspecialchars($bnr['cta_text']); ?> &rarr;</a></td>
                  <td>
                    <span class="badge <?= $bnr['status'] === 'active' ? 'badge-accent' : 'badge-warning'; ?>">
                      <?= strtoupper(htmlspecialchars($bnr['status'])); ?>
                    </span>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="banners.php?action=edit&id=<?= $bnr['id']; ?>" class="btn" style="background: #e8f0fe; color: #1877f2; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Edit BG</a>
                      <a href="banners.php?action=delete&id=<?= $bnr['id']; ?>" onclick="return confirm('Delete this hero banner permanently?')" class="btn" style="background: #ffebe9; color: #fa383e; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
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
