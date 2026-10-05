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
$all_inquiries = get_inquiries('all');
$new_inquiries = array_filter($all_inquiries, function($i) { return $i['status'] === 'new'; });
$all_applications = get_job_applications('all');
$new_applications = array_filter($all_applications, function($a) { return $a['status'] === 'new'; });
?>

<!-- KPI STATS CARDS (FACEBOOK WHITE CARD LOOK) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(24,119,242,0.12); color: #1877f2;">🛠️</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: #050505;"><?= $total_services; ?></h3>
      <p style="font-size: 0.85rem; color: #65676b; font-weight: 700; margin: 0;">IT Capabilities</p>
    </div>
  </div>

  

  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(24,119,242,0.12); color: #1877f2;">🏛️</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: #050505;"><?= $total_projects; ?></h3>
      <p style="font-size: 0.85rem; color: #65676b; font-weight: 700; margin: 0;">Client Projects</p>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(247,185,40,0.18); color: #b77904;">💼</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: #050505;"><?= $total_openings; ?></h3>
      <p style="font-size: 0.85rem; color: #65676b; font-weight: 700; margin: 0;">Job Openings</p>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(250,56,62,0.12); color: #fa383e;">📄</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: #fa383e;"><?= count($new_applications); ?> <small style="font-size:0.5em; color:#65676b;">/ <?= count($all_applications); ?></small></h3>
      <p style="font-size: 0.85rem; color: #65676b; font-weight: 700; margin: 0;">New Applicants</p>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(250,56,62,0.12); color: #fa383e;">📥</div>
    <div>
      <h3 style="font-size: 1.7rem; font-weight: 900; margin: 0; line-height: 1.1; color: #fa383e;"><?= count($new_inquiries); ?> <small style="font-size:0.5em; color:#65676b;">/ <?= count($all_inquiries); ?></small></h3>
      <p style="font-size: 0.85rem; color: #65676b; font-weight: 700; margin: 0;">CRM Leads</p>
    </div>
  </div>
</div>

<!-- QUICK ACTIONS -->
<div class="grid grid-2" style="gap: 25px; margin-bottom: 30px;">
  <div class="admin-card" style="margin: 0;">
    <h3 style="font-size: 1.2rem; font-weight: 800; margin-top: 0; margin-bottom: 18px; color: #050505;">⚡ Quick Management Actions</h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
      <a href="careers.php?action=new" class="btn" style="background: #e8f0fe; color: #1877f2; text-decoration: none; justify-content: start; font-size: 0.85rem;">+ Add Job Opening</a>
      <a href="projects.php?action=new" class="btn" style="background: #e6f4ea; color: #137333; text-decoration: none; justify-content: start; font-size: 0.85rem;">+ Add Project Showcase</a>
      <a href="services.php?action=new" class="btn" style="background: #e8f0fe; color: #1877f2; text-decoration: none; justify-content: start; font-size: 0.85rem;">+ Add IT Capability</a>
    </div>
  </div>

  <div class="admin-card" style="margin: 0;">
    <h3 style="font-size: 1.2rem; font-weight: 800; margin-top: 0; margin-bottom: 15px; color: #050505;">🛡️ System Health &amp; Theme Status</h3>
    <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.9rem; line-height: 2; color: #333;">
      <li>✅ <strong>Color Theme:</strong> Facebook.com Enterprise White/Blue (`#1877f2`)</li>
      <li>✅ <strong>Database Schema:</strong> 15 Relational Tables Active</li>
      <li>✅ <strong>New Portals:</strong> Careers, Projects &amp; Clients, Expertise</li>
      <li>📍 <strong>Company HQ:</strong> Raghuji Nagar, Nagpur, India</li>
    </ul>
  </div>
</div>

<!-- RECENT JOB APPLICATIONS FEED -->
<div class="admin-card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="font-size: 1.2rem; font-weight: 800; margin: 0; color: #050505;">Recent Job Applications (Careers CRM)</h3>
    <a href="applications.php" class="btn btn-outline btn-sm" style="text-decoration: none;">View All <?= count($all_applications); ?> Applications &rarr;</a>
  </div>

  <div style="overflow-x: auto;">
    <table class="admin-table">
      <thead>
        <tr><th>Date</th><th>Applicant Name</th><th>Position Applied</th><th>Resume Link</th><th>Status</th><th>Action</th></tr>
      </thead>
      <tbody>
        <?php if (empty($all_applications)): ?>
          <tr><td colspan="6" style="text-align: center; padding: 25px; color: #65676b;">No job applications submitted yet.</td></tr>
        <?php else: ?>
          <?php foreach (array_slice($all_applications, 0, 5) as $app): ?>
            <tr>
              <td style="color: #65676b; font-size: 0.85rem;"><?= htmlspecialchars($app['created_at']); ?></td>
              <td><strong style="color: #050505;"><?= htmlspecialchars($app['applicant_name']); ?></strong><br><a href="mailto:<?= htmlspecialchars($app['email']); ?>" style="color:#1877f2; font-size:0.85rem;"><?= htmlspecialchars($app['email']); ?></a></td>
              <td><strong><?= htmlspecialchars($app['job_title']); ?></strong></td>
              <td><a href="<?= htmlspecialchars($app['resume_link']); ?>" target="_blank" style="color:#1877f2; font-weight:700;">📄 View Resume</a></td>
              <td><span class="badge <?= $app['status'] === 'new' ? 'badge-warning' : 'badge-primary'; ?>"><?= strtoupper(htmlspecialchars($app['status'])); ?></span></td>
              <td><a href="applications.php?view=<?= $app['id']; ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Review Candidate</a></td>
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
    <h3 style="font-size: 1.2rem; font-weight: 800; margin: 0; color: #050505;">Recent Customer Inquiries &amp; Admission Leads</h3>
    <a href="inquiries.php" class="btn btn-outline btn-sm" style="text-decoration: none;">View All <?= count($all_inquiries); ?> Leads &rarr;</a>
  </div>

  <div style="overflow-x: auto;">
    <table class="admin-table">
      <thead>
        <tr><th>Date</th><th>Client Name</th><th>Subject / Service</th><th>Status</th><th>Action</th></tr>
      </thead>
      <tbody>
        <?php if (empty($all_inquiries)): ?>
          <tr><td colspan="5" style="text-align: center; padding: 25px; color: #65676b;">No customer inquiries received yet.</td></tr>
        <?php else: ?>
          <?php foreach (array_slice($all_inquiries, 0, 5) as $inq): ?>
            <tr>
              <td style="color: #65676b; font-size: 0.85rem;"><?= htmlspecialchars($inq['created_at']); ?></td>
              <td><strong style="color: #050505;"><?= htmlspecialchars($inq['name']); ?></strong><br><a href="mailto:<?= htmlspecialchars($inq['email']); ?>" style="color:#1877f2; font-size:0.85rem;"><?= htmlspecialchars($inq['email']); ?></a></td>
              <td><strong style="color: #333;"><?= htmlspecialchars($inq['subject']); ?></strong></td>
              <td><span class="badge <?= $inq['status'] === 'new' ? 'badge-warning' : 'badge-primary'; ?>"><?= strtoupper(htmlspecialchars($inq['status'])); ?></span></td>
              <td><a href="inquiries.php?view=<?= $inq['id']; ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Review Lead</a></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
