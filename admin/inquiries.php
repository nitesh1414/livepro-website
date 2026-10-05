<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * Customer Inquiries & Admission Leads CRM (admin/inquiries.php)
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
    $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Customer inquiry deleted.", "success");
    header("Location: inquiries.php");
    exit;
}

// HANDLE STATUS UPDATE
if ($action === 'status' && $id > 0 && isset($_GET['status'])) {
    update_inquiry_status($id, $_GET['status']);
    flash_message("⚡ Inquiry status updated to " . strtoupper(htmlspecialchars($_GET['status'])), "info");
    header("Location: inquiries.php?view=" . $id);
    exit;
}

$admin_page = 'inquiries';
require_once __DIR__ . '/includes/header.php';

// VIEW SINGLE INQUIRY
if ($view_id > 0):
    $stmt = $pdo->prepare("SELECT * FROM inquiries WHERE id = ?");
    $stmt->execute([$view_id]);
    $inq = $stmt->fetch();
    
    if (!$inq) {
        flash_message("Inquiry record not found.", "error");
        header("Location: inquiries.php");
        exit;
    }

    // Auto mark 'new' as 'read'
    if ($inq['status'] === 'new') {
        update_inquiry_status($view_id, 'read');
        $inq['status'] = 'read';
    }
?>
    <div class="admin-card" style="max-width: 800px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
        <div>
          <span class="badge badge-primary">Lead ID: #<?= $inq['id']; ?></span>
          <h3 style="font-size: 1.5rem; font-weight: 800; margin: 6px 0 0 0; color: #0f172a;">Customer CRM Lead Review</h3>
        </div>
        <a href="inquiries.php" class="btn" style="background: #f1f5f9; color: #475569; text-decoration: none; font-size: 0.85rem;">&larr; Back to Leads Table</a>
      </div>

      <!-- SENDER DETAILS BOX -->
      <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 25px; border-radius: 10px; margin-bottom: 25px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
          <span style="font-size: 0.8rem; color: #64748b; font-weight: 600; display: block;">CLIENT NAME</span>
          <strong style="font-size: 1.15rem; color: #0f172a;"><?= htmlspecialchars($inq['name']); ?></strong>
        </div>
        <div>
          <span style="font-size: 0.8rem; color: #64748b; font-weight: 600; display: block;">CURRENT LEAD STATUS</span>
          <?php 
            $badges = ['new' => 'badge-warning', 'read' => 'badge-primary', 'contacted' => 'badge-accent', 'replied' => 'badge-accent'];
            $b_class = $badges[$inq['status']] ?? 'badge-primary';
          ?>
          <span class="badge <?= $b_class; ?>" style="font-size: 0.85rem; padding: 6px 14px; margin-top: 4px;"><?= strtoupper(htmlspecialchars($inq['status'])); ?></span>
        </div>
        <div>
          <span style="font-size: 0.8rem; color: #64748b; font-weight: 600; display: block;">EMAIL ADDRESS</span>
          <a href="mailto:<?= htmlspecialchars($inq['email']); ?>" style="color: #2563eb; font-weight: 600; text-decoration: none; font-size: 1.05rem;"><?= htmlspecialchars($inq['email']); ?></a>
        </div>
        <div>
          <span style="font-size: 0.8rem; color: #64748b; font-weight: 600; display: block;">MOBILE NUMBER</span>
          <a href="tel:<?= htmlspecialchars($inq['phone']); ?>" style="color: #059669; font-weight: 600; text-decoration: none; font-size: 1.05rem;"><?= htmlspecialchars($inq['phone']); ?></a>
        </div>
      </div>

      <!-- MESSAGE BOX -->
      <div style="margin-bottom: 30px;">
        <span style="font-size: 0.8rem; color: #64748b; font-weight: 600; display: block; margin-bottom: 6px;">INQUIRY SUBJECT / SERVICE REQUESTED</span>
        <h4 style="font-size: 1.25rem; font-weight: 800; color: #2563eb; margin: 0 0 15px 0; background: #eff6ff; padding: 12px 18px; border-radius: 8px; border-left: 4px solid #2563eb;">
          <?= htmlspecialchars($inq['subject']); ?>
        </h4>
        
        <span style="font-size: 0.8rem; color: #64748b; font-weight: 600; display: block; margin-bottom: 6px;">MESSAGE / PROJECT REQUIREMENTS</span>
        <div style="background: white; border: 1px solid #e2e8f0; padding: 25px; border-radius: 8px; font-size: 1.05rem; line-height: 1.8; color: #334155; white-space: pre-line;">
          <?= htmlspecialchars($inq['message']); ?>
        </div>
      </div>

      <!-- CRM ACTION BAR -->
      <div style="background: #1e293b; color: white; padding: 25px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
        <div>
          <span style="font-size: 0.85rem; color: #94a3b8; display: block; margin-bottom: 6px;">Update Lead Status:</span>
          <div style="display: flex; gap: 8px;">
            <a href="inquiries.php?action=status&id=<?= $inq['id']; ?>&status=read" class="btn btn-sm" style="background: #334155; color: white; text-decoration: none;">Mark Read</a>
            <a href="inquiries.php?action=status&id=<?= $inq['id']; ?>&status=contacted" class="btn btn-sm" style="background: #34d399; color: #0f172a; text-decoration: none; font-weight: 800;">Mark Contacted</a>
            <a href="inquiries.php?action=status&id=<?= $inq['id']; ?>&status=replied" class="btn btn-sm" style="background: #60a5fa; color: #0f172a; text-decoration: none; font-weight: 800;">Mark Replied</a>
          </div>
        </div>

        <div style="display: flex; gap: 12px;">
          <a href="mailto:<?= htmlspecialchars($inq['email']); ?>?subject=RE: <?= urlencode($inq['subject']); ?>&body=Dear <?= urlencode($inq['name']); ?>,%0D%0A%0D%0AThank you for contacting LIVEpro Software Solutions.%0D%0A%0D%0A" class="btn btn-primary" style="text-decoration: none;">
            ✉️ Reply via Email
          </a>
          <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $inq['phone']); ?>" target="_blank" class="btn btn-accent" style="text-decoration: none; background: #059669;">
            💬 WhatsApp Client
          </a>
          <a href="inquiries.php?action=delete&id=<?= $inq['id']; ?>" onclick="return confirm('Delete this CRM lead permanently?')" class="btn btn-danger" style="text-decoration: none;">
            🗑️ Delete
          </a>
        </div>
      </div>
    </div>

<?php else: 
    // LIST VIEW
    $inquiries = get_inquiries($filter_status);
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: #0f172a;">Customer CRM &amp; Admission Leads Database</h3>
          <p style="color: #64748b; font-size: 0.85rem; margin: 4px 0 0 0;">Total records found: <?= count($inquiries); ?></p>
        </div>

        <!-- FILTER DROPDOWN -->
        <div style="display: flex; align-items: center; gap: 10px;">
          <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Filter Status:</span>
          <select onchange="window.location.href='inquiries.php?filter=' + this.value" style="padding: 8px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-weight: 600; background: white; color: #0f172a;">
            <option value="all" <?= $filter_status === 'all' ? 'selected' : ''; ?>>All Leads</option>
            <option value="new" <?= $filter_status === 'new' ? 'selected' : ''; ?>>🔴 New Unread</option>
            <option value="read" <?= $filter_status === 'read' ? 'selected' : ''; ?>>🔵 Read</option>
            <option value="contacted" <?= $filter_status === 'contacted' ? 'selected' : ''; ?>>🟢 Contacted</option>
            <option value="replied" <?= $filter_status === 'replied' ? 'selected' : ''; ?>>🟣 Replied</option>
          </select>
        </div>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Date Received</th>
              <th>Client Information</th>
              <th>Subject &amp; Message Snippet</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($inquiries)): ?>
              <tr><td colspan="5" style="text-align: center; padding: 35px; color: #64748b;">No inquiries found matching this status filter.</td></tr>
            <?php else: ?>
              <?php foreach ($inquiries as $inq): ?>
                <tr style="<?= $inq['status'] === 'new' ? 'background: #fef2f2;' : ''; ?>">
                  <td style="color: #64748b; font-size: 0.85rem; white-space: nowrap;"><?= htmlspecialchars($inq['created_at']); ?></td>
                  <td>
                    <strong style="color: #0f172a; font-size: 1.05rem;"><?= htmlspecialchars($inq['name']); ?></strong><br>
                    <a href="mailto:<?= htmlspecialchars($inq['email']); ?>" style="color: #2563eb; font-size: 0.85rem; text-decoration: none;"><?= htmlspecialchars($inq['email']); ?></a><br>
                    <span style="color: #64748b; font-size: 0.8rem;"><?= htmlspecialchars($inq['phone']); ?></span>
                  </td>
                  <td style="max-width: 320px;">
                    <strong style="color: #1e293b; font-size: 0.95rem; display: block; margin-bottom: 4px;"><?= htmlspecialchars($inq['subject']); ?></strong>
                    <span style="color: #64748b; font-size: 0.85rem; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= htmlspecialchars($inq['message']); ?></span>
                  </td>
                  <td>
                    <?php 
                      $badges = ['new' => 'badge-warning', 'read' => 'badge-primary', 'contacted' => 'badge-accent', 'replied' => 'badge-accent'];
                      $b_class = $badges[$inq['status']] ?? 'badge-primary';
                    ?>
                    <span class="badge <?= $b_class; ?>" style="background: <?= $inq['status'] === 'new' ? '#fee2e2' : ''; ?>; color: <?= $inq['status'] === 'new' ? '#dc2626' : ''; ?>;">
                      <?= strtoupper(htmlspecialchars($inq['status'])); ?>
                    </span>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="inquiries.php?view=<?= $inq['id']; ?>" class="btn" style="background: #2563eb; color: white; padding: 6px 14px; font-size: 0.8rem; text-decoration: none; font-weight: 700;">Review</a>
                      <a href="inquiries.php?action=delete&id=<?= $inq['id']; ?>" onclick="return confirm('Delete this inquiry permanently?')" class="btn" style="background: #fef2f2; color: #dc2626; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
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
