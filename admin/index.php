<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (Facebook Color Scheme)
 * CMS Admin Dashboard Overview (admin/index.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$admin_page = 'overview';
require_once __DIR__ . '/includes/header.php';

// Fetch stats
$total_services = count(get_services('all'));
$total_projects = count(get_projects('all'));
$total_openings = count(get_job_openings('all'));
$total_leaders = count(get_leaders_mentors('all'));
$all_inquiries = get_inquiries('all');
$new_inquiries = array_filter($all_inquiries, function($i) { return $i['status'] === 'new'; });
$all_applications = get_job_applications('all');
$new_applications = array_filter($all_applications, function($a) { return $a['status'] === 'new'; });
?>

<!-- KPI STATS CARDS (FACEBOOK WHITE CARD LOOK) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(55, 106, 155,0.12); color: var(--primary);">🛠️</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: var(--text-main);"><?= $total_services; ?></h3>
      <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; margin: 0;">IT Capabilities</p>
    </div>
  </div>

  

  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(55, 106, 155,0.12); color: var(--primary);">🏛️</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: var(--text-main);"><?= $total_projects; ?></h3>
      <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; margin: 0;">Client Projects</p>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(43, 125, 95,0.12); color: var(--accent);">👥</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: var(--text-main);"><?= $total_leaders; ?></h3>
      <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; margin: 0;">Leaders &amp; Mentors</p>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(181, 133, 47,0.18); color: var(--warning-ink);">💼</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: var(--text-main);"><?= $total_openings; ?></h3>
      <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; margin: 0;">Job Openings</p>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(163, 77, 72,0.12); color: var(--danger);">📄</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: var(--danger);"><?= count($new_applications); ?> <small style="font-size:0.5em; color:var(--text-muted);">/ <?= count($all_applications); ?></small></h3>
      <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; margin: 0;">New Applicants</p>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(163, 77, 72,0.12); color: var(--danger);">📥</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: var(--danger);"><?= count($new_inquiries); ?> <small style="font-size:0.5em; color:var(--text-muted);">/ <?= count($all_inquiries); ?></small></h3>
      <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; margin: 0;">CRM Leads</p>
    </div>
  </div>
</div>

<!-- QUICK ACTIONS -->
<div class="grid grid-2" style="gap: 25px; margin-bottom: 30px;">
  <div class="admin-card" style="margin: 0;">
    <h3 style="font-size: 1.2rem; font-weight: 800; margin-top: 0; margin-bottom: 18px; color: var(--text-main);">⚡ Quick Management Actions</h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
      <a href="careers.php?action=new" class="btn" style="background: var(--primary-soft); color: var(--primary); text-decoration: none; justify-content: start; font-size: 0.85rem;">Add</a>
      <a href="projects.php?action=new" class="btn" style="background: var(--accent-soft); color: var(--accent-ink); text-decoration: none; justify-content: start; font-size: 0.85rem;">Add</a>
      <a href="services.php?action=new" class="btn" style="background: var(--primary-soft); color: var(--primary); text-decoration: none; justify-content: start; font-size: 0.85rem;">Add</a>
      <a href="leaders.php?action=new" class="btn" style="background: var(--accent-soft); color: var(--accent-ink); text-decoration: none; justify-content: start; font-size: 0.85rem;">Add</a>
    </div>
  </div>

  <div class="admin-card" style="margin: 0;">
    <h3 style="font-size: 1.2rem; font-weight: 800; margin-top: 0; margin-bottom: 15px; color: var(--text-main);">🛡️ System Health &amp; Theme Status</h3>
    <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.9rem; line-height: 2; color: var(--text-body);">
      <li>✅ <strong>Color Theme:</strong> Facebook.com Enterprise White/Blue (`var(--primary)`)</li>
      <li>✅ <strong>Database Schema:</strong> 15 Relational Tables Active (Leaders &amp; Mentors included)</li>
      <li>✅ <strong>New Portals:</strong> Careers, Projects &amp; Clients, Expertise</li>
      <li>📍 <strong>Company HQ:</strong> Raghuji Nagar, Nagpur, India</li>
    </ul>
  </div>
</div>

<!-- RECENT JOB APPLICATIONS FEED -->
<div class="admin-card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="font-size: 1.2rem; font-weight: 800; margin: 0; color: var(--text-main);">Recent Job Applications (Careers CRM)</h3>
    <a href="applications.php" class="btn btn-outline btn-sm" style="text-decoration: none;">Browse</a>
  </div>

  <div style="overflow-x: auto;">
    <table class="admin-table">
      <thead>
        <tr><th>Date</th><th>Applicant Name</th><th>Position Applied</th><th>Resume Link</th><th>Status</th><th>Action</th></tr>
      </thead>
      <tbody>
        <?php if (empty($all_applications)): ?>
          <tr><td colspan="6" style="text-align: center; padding: 25px; color: var(--text-muted);">No job applications submitted yet.</td></tr>
        <?php else: ?>
          <?php foreach (array_slice($all_applications, 0, 5) as $app): ?>
            <tr>
              <td style="color: var(--text-muted); font-size: 0.85rem;"><?= htmlspecialchars($app['created_at']); ?></td>
              <td><strong style="color: var(--text-main);"><?= htmlspecialchars($app['applicant_name']); ?></strong><br><a href="mailto:<?= htmlspecialchars($app['email']); ?>" style="color:var(--primary); font-size:0.85rem;"><?= htmlspecialchars($app['email']); ?></a></td>
              <td><strong><?= htmlspecialchars($app['job_title']); ?></strong></td>
              <td><a href="<?= htmlspecialchars($app['resume_link']); ?>" target="_blank" style="color:var(--primary); font-weight:700;">📄 View Resume</a></td>
              <td><span class="badge <?= $app['status'] === 'new' ? 'badge-warning' : 'badge-primary'; ?>"><?= strtoupper(htmlspecialchars($app['status'])); ?></span></td>
              <td><a href="applications.php?view=<?= $app['id']; ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Review</a></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- RECENT INQUIRIES FEED -->
<div class="admin-card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="font-size: 1.2rem; font-weight: 800; margin: 0; color: var(--text-main);">Recent Customer Inquiries &amp; Admission Leads</h3>
    <a href="inquiries.php" class="btn btn-outline btn-sm" style="text-decoration: none;">Browse</a>
  </div>

  <div style="overflow-x: auto;">
    <table class="admin-table">
      <thead>
        <tr><th>Date</th><th>Client Name</th><th>Subject / Service</th><th>Status</th><th>Action</th></tr>
      </thead>
      <tbody>
        <?php if (empty($all_inquiries)): ?>
          <tr><td colspan="5" style="text-align: center; padding: 25px; color: var(--text-muted);">No customer inquiries received yet.</td></tr>
        <?php else: ?>
          <?php foreach (array_slice($all_inquiries, 0, 5) as $inq): ?>
            <tr>
              <td style="color: var(--text-muted); font-size: 0.85rem;"><?= htmlspecialchars($inq['created_at']); ?></td>
              <td><strong style="color: var(--text-main);"><?= htmlspecialchars($inq['name']); ?></strong><br><a href="mailto:<?= htmlspecialchars($inq['email']); ?>" style="color:var(--primary); font-size:0.85rem;"><?= htmlspecialchars($inq['email']); ?></a></td>
              <td><strong style="color: var(--text-body);"><?= htmlspecialchars($inq['subject']); ?></strong></td>
              <td><span class="badge <?= $inq['status'] === 'new' ? 'badge-warning' : 'badge-primary'; ?>"><?= strtoupper(htmlspecialchars($inq['status'])); ?></span></td>
              <td><a href="inquiries.php?view=<?= $inq['id']; ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Review</a></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
