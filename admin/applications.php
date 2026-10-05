<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (Facebook Color Scheme)
 * Job Applications Recruitment CRM (admin/applications.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);
$view_id = intval($_GET['view'] ?? 0);
$filter_status = $_GET['filter'] ?? 'all';

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM job_applications WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Job application deleted successfully.", "success");
    header("Location: applications.php");
    exit;
}

// HANDLE STATUS UPDATE
if ($action === 'status' && $id > 0 && isset($_GET['status'])) {
    update_job_application_status($id, $_GET['status']);
    flash_message("⚡ Candidate status updated to " . strtoupper(htmlspecialchars($_GET['status'])), "info");
    header("Location: applications.php?view=" . $id);
    exit;
}

$admin_page = 'applications';
require_once __DIR__ . '/includes/header.php';

// VIEW SINGLE APPLICATION
if ($view_id > 0):
    $stmt = $pdo->prepare("SELECT * FROM job_applications WHERE id = ?");
    $stmt->execute([$view_id]);
    $app = $stmt->fetch();
    
    if (!$app) {
        flash_message("Application record not found.", "error");
        header("Location: applications.php");
        exit;
    }

    if ($app['status'] === 'new') {
        update_job_application_status($view_id, 'reviewed');
        $app['status'] = 'reviewed';
    }
?>
    <div class="admin-card" style="max-width: 800px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #dddfe2; padding-bottom: 15px;">
        <div>
          <span class="badge badge-primary">Candidate ID: #<?= $app['id']; ?></span>
          <h3 style="font-size: 1.5rem; font-weight: 800; margin: 6px 0 0 0; color: #050505;">Candidate Application Review</h3>
        </div>
        <a href="applications.php" class="btn" style="background: #f0f2f5; color: #65676b; text-decoration: none; font-size: 0.85rem;">&larr; Back to Applications Table</a>
      </div>

      <!-- CANDIDATE BOX -->
      <div style="background: #f0f2f5; border: 1px solid #dddfe2; padding: 25px; border-radius: 8px; margin-bottom: 25px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
          <span style="font-size: 0.8rem; color: #65676b; font-weight: 700; display: block;">APPLICANT NAME</span>
          <strong style="font-size: 1.15rem; color: #050505;"><?= htmlspecialchars($app['applicant_name']); ?></strong>
        </div>
        <div>
          <span style="font-size: 0.8rem; color: #65676b; font-weight: 700; display: block;">CURRENT APPLICATION STATUS</span>
          <?php 
            $badges = ['new' => 'badge-warning', 'reviewed' => 'badge-primary', 'shortlisted' => 'badge-accent', 'rejected' => 'badge-warning'];
            $b_class = $badges[$app['status']] ?? 'badge-primary';
          ?>
          <span class="badge <?= $b_class; ?>" style="font-size: 0.85rem; padding: 6px 14px; margin-top: 4px;"><?= strtoupper(htmlspecialchars($app['status'])); ?></span>
        </div>
        <div>
          <span style="font-size: 0.8rem; color: #65676b; font-weight: 700; display: block;">EMAIL ADDRESS</span>
          <a href="mailto:<?= htmlspecialchars($app['email']); ?>" style="color: #1877f2; font-weight: 600; text-decoration: none; font-size: 1.05rem;"><?= htmlspecialchars($app['email']); ?></a>
        </div>
        <div>
          <span style="font-size: 0.8rem; color: #65676b; font-weight: 700; display: block;">MOBILE NUMBER</span>
          <a href="tel:<?= htmlspecialchars($app['phone']); ?>" style="color: #42b72a; font-weight: 600; text-decoration: none; font-size: 1.05rem;"><?= htmlspecialchars($app['phone']); ?></a>
        </div>
      </div>

      <!-- POSITION & RESUME -->
      <div style="margin-bottom: 25px;">
        <span style="font-size: 0.8rem; color: #65676b; font-weight: 700; display: block; margin-bottom: 6px;">POSITION APPLIED FOR</span>
        <h4 style="font-size: 1.25rem; font-weight: 800; color: #1877f2; margin: 0 0 15px 0; background: #e8f0fe; padding: 12px 18px; border-radius: 6px; border-left: 4px solid #1877f2;">
          <?= htmlspecialchars($app['job_title']); ?>
        </h4>

        <span style="font-size: 0.8rem; color: #65676b; font-weight: 700; display: block; margin-bottom: 6px;">RESUME / PORTFOLIO LINK</span>
        <div style="background: white; border: 1px solid #dddfe2; padding: 15px 20px; border-radius: 6px; margin-bottom: 20px;">
          <a href="<?= htmlspecialchars($app['resume_link']); ?>" target="_blank" style="color: #1877f2; font-weight: 700; text-decoration: underline; font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
            📄 Open Candidate Resume &rarr;
          </a>
        </div>
        
        <?php if (!empty($app['cover_letter'])): ?>
          <span style="font-size: 0.8rem; color: #65676b; font-weight: 700; display: block; margin-bottom: 6px;">COVER LETTER / INTRODUCTION</span>
          <div style="background: white; border: 1px solid #dddfe2; padding: 25px; border-radius: 6px; font-size: 1.05rem; line-height: 1.8; color: #333; white-space: pre-line;">
            <?= htmlspecialchars($app['cover_letter']); ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- RECRUITMENT ACTION BAR -->
      <div style="background: #050505; color: white; padding: 25px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
        <div>
          <span style="font-size: 0.85rem; color: #e4e6eb; display: block; margin-bottom: 6px;">Update Recruitment Status:</span>
          <div style="display: flex; gap: 8px;">
            <a href="applications.php?action=status&id=<?= $app['id']; ?>&status=reviewed" class="btn btn-sm" style="background: #333; color: white; text-decoration: none;">Mark Reviewed</a>
            <a href="applications.php?action=status&id=<?= $app['id']; ?>&status=shortlisted" class="btn btn-sm" style="background: #42b72a; color: white; text-decoration: none; font-weight: 800;">⭐ Shortlist Candidate</a>
            <a href="applications.php?action=status&id=<?= $app['id']; ?>&status=rejected" class="btn btn-sm" style="background: #fa383e; color: white; text-decoration: none;">Reject</a>
          </div>
        </div>

        <div style="display: flex; gap: 12px;">
          <a href="mailto:<?= htmlspecialchars($app['email']); ?>?subject=RE: Application for <?= urlencode($app['job_title']); ?> at LIVEpro Software Solutions&body=Dear <?= urlencode($app['applicant_name']); ?>,%0D%0A%0D%0AThank you for applying to LIVEpro Software Solutions.%0D%0A%0D%0A" class="btn btn-primary" style="text-decoration: none;">
            ✉️ Email Candidate
          </a>
          <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $app['phone']); ?>" target="_blank" class="btn btn-accent" style="text-decoration: none;">
            💬 WhatsApp
          </a>
          <a href="applications.php?action=delete&id=<?= $app['id']; ?>" onclick="return confirm('Delete this candidate record permanently?')" class="btn btn-danger" style="text-decoration: none;">
            🗑️ Delete
          </a>
        </div>
      </div>
    </div>

<?php else: 
    // LIST VIEW
    $apps = get_job_applications($filter_status);
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: #050505;">Recruitment CRM &amp; Job Applications Database</h3>
          <p style="color: #65676b; font-size: 0.85rem; margin: 4px 0 0 0;">Total submitted applications: <?= count($apps); ?></p>
        </div>

        <!-- FILTER DROPDOWN -->
        <div style="display: flex; align-items: center; gap: 10px;">
          <span style="font-size: 0.85rem; font-weight: 700; color: #65676b;">Filter Status:</span>
          <select onchange="window.location.href='applications.php?filter=' + this.value" style="padding: 8px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.9rem; font-weight: 700; background: white; color: #050505;">
            <option value="all" <?= $filter_status === 'all' ? 'selected' : ''; ?>>All Applications</option>
            <option value="new" <?= $filter_status === 'new' ? 'selected' : ''; ?>>🔴 New Unreviewed</option>
            <option value="reviewed" <?= $filter_status === 'reviewed' ? 'selected' : ''; ?>>🔵 Reviewed</option>
            <option value="shortlisted" <?= $filter_status === 'shortlisted' ? 'selected' : ''; ?>>🟢 Shortlisted</option>
            <option value="rejected" <?= $filter_status === 'rejected' ? 'selected' : ''; ?>>🟡 Rejected</option>
          </select>
        </div>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Applicant Name &amp; Contact</th>
              <th>Position Applied</th>
              <th>Resume Link</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($apps)): ?>
              <tr><td colspan="6" style="text-align: center; padding: 35px; color: #65676b;">No job applications found matching this status filter.</td></tr>
            <?php else: ?>
              <?php foreach ($apps as $app): ?>
                <tr style="<?= $app['status'] === 'new' ? 'background: #ffebe9;' : ''; ?>">
                  <td style="color: #65676b; font-size: 0.85rem; white-space: nowrap;"><?= htmlspecialchars($app['created_at']); ?></td>
                  <td>
                    <strong style="color: #050505; font-size: 1.05rem;"><?= htmlspecialchars($app['applicant_name']); ?></strong><br>
                    <a href="mailto:<?= htmlspecialchars($app['email']); ?>" style="color: #1877f2; font-size: 0.85rem; text-decoration: none;"><?= htmlspecialchars($app['email']); ?></a><br>
                    <span style="color: #65676b; font-size: 0.8rem;"><?= htmlspecialchars($app['phone']); ?></span>
                  </td>
                  <td><strong style="color: #050505;"><?= htmlspecialchars($app['job_title']); ?></strong></td>
                  <td><a href="<?= htmlspecialchars($app['resume_link']); ?>" target="_blank" style="color: #1877f2; font-weight: 700; font-size: 0.85rem; text-decoration: underline;">📄 View Resume</a></td>
                  <td>
                    <?php 
                      $badges = ['new' => 'badge-warning', 'reviewed' => 'badge-primary', 'shortlisted' => 'badge-accent', 'rejected' => 'badge-warning'];
                      $b_class = $badges[$app['status']] ?? 'badge-primary';
                    ?>
                    <span class="badge <?= $b_class; ?>" style="<?= $app['status'] === 'new' ? 'background: #fa383e; color: white;' : ''; ?>">
                      <?= strtoupper(htmlspecialchars($app['status'])); ?>
                    </span>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="applications.php?view=<?= $app['id']; ?>" class="btn" style="background: #1877f2; color: white; padding: 6px 14px; font-size: 0.8rem; text-decoration: none; font-weight: 700;">Review</a>
                      <a href="applications.php?action=delete&id=<?= $app['id']; ?>" onclick="return confirm('Delete this application permanently?')" class="btn" style="background: #ffebe9; color: #fa383e; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
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
