<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (LP Geometric Logo Theme)
 * Careers & Job Seekers Portal (careers.php)
 */
require_once __DIR__ . '/includes/functions.php';

// Handle Job Application Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = intval($_POST['job_id'] ?? 0);
    $job_title = trim($_POST['job_title'] ?? '');
    $applicant_name = trim($_POST['applicant_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $resume_link = trim($_POST['resume_link'] ?? '');
    $cover_letter = trim($_POST['cover_letter'] ?? '');

    if ($job_id > 0 && !empty($applicant_name) && !empty($email) && !empty($resume_link)) {
        if (save_job_application($_POST)) {
            flash_message("🎉 Congratulations, {$applicant_name}! Your application for \"{$job_title}\" has been submitted directly to our HR & Engineering Recruitment team in Nagpur.", "success");
            header("Location: careers.php");
            exit;
        } else {
            flash_message("❌ Error submitting application. Please try again.", "error");
        }
    } else {
        flash_message("⚠️ Please complete all required fields (Name, Email, Phone, Resume Link).", "warning");
    }
}

$current_page = 'careers';
$page_title = 'Careers & Job Openings Portal';
require_once __DIR__ . '/includes/header.php';

$filter_dept = $_GET['dept'] ?? 'All';
$openings = get_job_openings('active', $filter_dept);
?>

<!-- PAGE HEADER -->
<section style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%); color: white; padding: 70px 0; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <div class="container" style="max-width: 850px;">
    <span class="badge" style="background: rgba(88,179,46,0.25); color: #34d399; margin-bottom: 15px;">Join Our Team</span>
    <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 15px; color: white;">Build Your IT Career With LIVEpro</h1>
    <p style="font-size: 1.15rem; color: #cbd5e1; line-height: 1.7;">
      Whether you are an experienced software architect or an engineering specialist in AI, cloud DevOps, embedded firmware, or mobile apps, explore our open positions in Nagpur HQ and hybrid across India.
    </p>
  </div>
</section>

<!-- DEPARTMENT FILTER TABS & LIVE SEARCH -->
<section style="background: var(--bg-light); padding: 80px 0;">
  <div class="container">
    
    <!-- LIVE SEARCH BOX -->
    <div class="live-search-box">
      <span class="live-search-icon">🔍</span>
      <input type="text" class="live-search-input" placeholder="Search job roles, skills, or location..." onkeyup="liveSearchCareers(this.value)">
    </div>

    <div style="display: flex; justify-content: center; gap: 12px; margin-bottom: 50px; flex-wrap: wrap;">
      <a href="careers.php?dept=All" class="btn <?= $filter_dept === 'All' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">All Openings</a>
      <a href="careers.php?dept=Website Development" class="btn <?= $filter_dept === 'Website Development' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">Website Development</a>
      <a href="careers.php?dept=Mobile Development" class="btn <?= $filter_dept === 'Mobile Development' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">Mobile Development</a>
      <a href="careers.php?dept=AI & Data Science" class="btn <?= $filter_dept === 'AI & Data Science' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">AI &amp; Data Science</a>
      <a href="careers.php?dept=Embedded Hardware" class="btn <?= $filter_dept === 'Embedded Hardware' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">Embedded Hardware</a>
    </div>

    <!-- JOB OPENINGS GRID -->
    <div class="grid grid-2" style="gap: 30px;" id="careersGrid">
      <?php if (empty($openings)): ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: white; border-radius: 12px; color: #64748b; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
          <div style="font-size: 2rem; margin-bottom: 10px;">💼</div>
          <h3 style="font-size: 1.3rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">No Open Positions Found</h3>
          <p style="margin: 0;">We currently don't have any active openings matching this department filter. Please check back soon or submit a general application below.</p>
        </div>
      <?php else: ?>
        <?php foreach ($openings as $job): ?>
          <div class="card career-card-item" style="display: flex; flex-direction: column; justify-content: space-between; border-left: 5px solid var(--primary);">
            <div>
              <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                <span class="badge badge-primary"><?= htmlspecialchars($job['department']); ?></span>
                <span style="font-size: 0.8rem; font-weight: 800; color: #3a8a1a; background: rgba(88,179,46,0.15); padding: 4px 12px; border-radius: 6px; border: 1px solid rgba(88,179,46,0.3);"><?= htmlspecialchars($job['salary']); ?></span>
              </div>
              <h3 style="font-size: 1.4rem; font-weight: 800; color: var(--text-main); margin-bottom: 10px;"><?= htmlspecialchars($job['title']); ?></h3>
              
              <div style="display: flex; gap: 15px; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 18px; flex-wrap: wrap;">
                <span>📍 <strong><?= htmlspecialchars($job['location']); ?></strong></span>
                <span>🕒 <strong><?= htmlspecialchars($job['type']); ?></strong></span>
                <span>🎓 <strong><?= htmlspecialchars($job['experience']); ?></strong></span>
              </div>

              <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 25px;">
                <?= htmlspecialchars($job['description']); ?>
              </p>
            </div>

            <div style="padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">LIVEpro Engineering Division</span>
              <button onclick="openJobApplyModal('<?= $job['id']; ?>', '<?= addslashes(htmlspecialchars($job['title'])); ?>', '<?= addslashes(htmlspecialchars($job['department'])); ?>', '<?= addslashes(htmlspecialchars($job['location'])); ?>', '<?= addslashes(htmlspecialchars($job['experience'])); ?>', '<?= addslashes(htmlspecialchars($job['salary'])); ?>', '<?= addslashes(htmlspecialchars($job['description'])); ?>', '<?= addslashes(htmlspecialchars($job['requirements'])); ?>')" class="btn btn-primary" style="padding: 10px 22px;">
                View Role &amp; Apply &rarr;
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- GENERAL APPLICATION CALL -->
<section style="background: white; text-align: center;">
  <div class="container" style="max-width: 750px;">
    <span class="badge badge-accent" style="margin-bottom: 15px;">Talent Network</span>
    <h2 style="font-size: 2.3rem; font-weight: 900; margin-bottom: 15px; color: var(--text-main);">Don't See Your Exact Role?</h2>
    <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 30px; line-height: 1.7;">
      We are always looking for exceptional software architects, mobile developers, AI engineers, and DevOps specialists to join our engineering hub in Nagpur.
    </p>
    <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
      <a href="contact.php?subject=General+Job+Application" class="btn btn-accent" style="padding: 14px 30px; font-size: 1rem;">Submit General Application &rarr;</a>
      <a href="about.php" class="btn btn-outline" style="padding: 14px 30px; font-size: 1rem;">Why Work With Us</a>
    </div>
  </div>
</section>

<!-- MODAL: JOB DETAILS & 1-CLICK APPLICATION FORM -->
<div class="modal-overlay" id="jobApplyModal">
  <div class="modal-content" style="max-width: 700px;">
    <div class="modal-header">
      <div>
        <span class="badge badge-primary" id="applyModalDept">Department</span>
        <h3 style="font-size: 1.5rem; font-weight: 800; margin-top: 6px; color: var(--text-main);" id="applyModalTitle">Job Title</h3>
      </div>
      <button class="modal-close" onclick="closeModal('jobApplyModal')">&times;</button>
    </div>

    <!-- JOB SUMMARY BOX -->
    <div style="background: var(--bg-light); padding: 18px; border-radius: 8px; margin-bottom: 25px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; text-align: center; border: 1px solid var(--border-color);">
      <div><span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; display: block;">LOCATION</span><strong style="font-size: 0.95rem; color: var(--text-main);" id="applyModalLoc">Nagpur</strong></div>
      <div style="border-left: 1px solid var(--border-color); border-right: 1px solid var(--border-color);"><span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; display: block;">EXPERIENCE</span><strong style="font-size: 0.95rem; color: var(--text-main);" id="applyModalExp">2-5 Years</strong></div>
      <div><span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; display: block;">COMPENSATION</span><strong style="font-size: 0.95rem; color: #3a8a1a;" id="applyModalSal">Best in Industry</strong></div>
    </div>

    <div style="margin-bottom: 25px;">
      <h4 style="font-size: 1.05rem; font-weight: 800; color: var(--text-main); margin-bottom: 8px;">Role Overview:</h4>
      <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;" id="applyModalDesc"></p>
    </div>

    <div style="margin-bottom: 30px;">
      <h4 style="font-size: 1.05rem; font-weight: 800; color: var(--text-main); margin-bottom: 8px;">Required Skills &amp; Qualifications:</h4>
      <div style="background: #ffffff; border: 1px solid var(--border-color); padding: 16px; border-radius: 8px; font-size: 0.95rem; color: #334155; white-space: pre-line; line-height: 1.7;" id="applyModalReq"></div>
    </div>

    <!-- APPLICATION FORM -->
    <div style="background: #f8fafc; border: 1px solid var(--border-color); padding: 25px; border-radius: 12px;">
      <h4 style="font-size: 1.2rem; font-weight: 800; color: var(--primary); margin-bottom: 6px;">Apply For This Position</h4>
      <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">Your application will be sent directly into our MySQL Recruitment CRM for admin review.</p>

      <form method="POST" action="careers.php">
        <input type="hidden" name="job_id" id="formJobId">
        <input type="hidden" name="job_title" id="formJobTitle">

        <div style="margin-bottom: 15px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Your Full Name *</label>
          <input type="text" name="applicant_name" placeholder="e.g. Amit Kulkarni" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.95rem;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Email Address *</label>
            <input type="email" name="email" placeholder="amit@example.com" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Mobile Number *</label>
            <input type="tel" name="phone" placeholder="+91 98765 43210" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="margin-bottom: 15px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Resume / LinkedIn / GitHub Portfolio URL *</label>
          <input type="url" name="resume_link" placeholder="https://linkedin.com/in/your-profile or Google Drive link" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.95rem;">
        </div>

        <div style="margin-bottom: 25px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Cover Letter / Introduction</label>
          <textarea name="cover_letter" rows="3" placeholder="Tell us why you are a great fit for the LIVEpro Nagpur team..." style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.95rem;"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1rem; cursor: pointer; border: none; border-radius: 8px; color: white; font-weight: 700;">
          🚀 Submit Application to HR Database
        </button>
      </form>
    </div>
  </div>
</div>

<script>
function openJobApplyModal(id, title, dept, loc, exp, sal, desc, req) {
  document.getElementById('applyModalDept').textContent = dept;
  document.getElementById('applyModalTitle').textContent = title;
  document.getElementById('applyModalLoc').textContent = loc;
  document.getElementById('applyModalExp').textContent = exp;
  document.getElementById('applyModalSal').textContent = sal;
  document.getElementById('applyModalDesc').textContent = desc;
  document.getElementById('applyModalReq').textContent = req;
  document.getElementById('formJobId').value = id;
  document.getElementById('formJobTitle').value = title;
  openModal('jobApplyModal');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
