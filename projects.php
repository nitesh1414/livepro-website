<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (LP Geometric Logo Theme)
 * Enterprise Clients & Projects Portfolio Showcase (projects.php)
 */
require_once __DIR__ . '/includes/functions.php';

$current_page = 'projects';
$page_title = 'Enterprise Clients & Projects Showcase';
require_once __DIR__ . '/includes/header.php';

$filter_cat = $_GET['cat'] ?? 'All';
$projects = get_projects('active', $filter_cat);
?>

<!-- PAGE HEADER -->
<section style="background: linear-gradient(135deg, var(--text-main) 0%, var(--text-main) 50%, var(--text-main) 100%); color: white; padding: 70px 0; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <div class="container" style="max-width: 850px;">
    <span class="badge" style="background: rgba(55, 106, 155,0.2); color: var(--on-dark-accent); margin-bottom: 15px;">Proven Deliverables</span>
    <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 15px; color: white;">Enterprise Clients &amp; Projects</h1>
    <p style="font-size: 1.15rem; color: var(--text-on-dark-muted); line-height: 1.7;">
      Our in-depth engineering industry knowledge enables us to concentrate specifically on our clients' business needs across banking, industrial automation, logistics, and omnichannel retail.
    </p>
  </div>
</section>

<!-- PROJECT CATEGORY FILTER & LIVE SEARCH -->
<section style="background: var(--bg-light); padding: 80px 0;">
  <div class="container">
    
    <!-- LIVE SEARCH BOX -->
    <div class="live-search-box">
      <span class="live-search-icon">🔍</span>
      <input type="text" class="live-search-input" placeholder="Search projects by title, client, or technology..." onkeyup="liveSearchProjects(this.value)">
    </div>

    <!-- FILTER TABS -->
    <div style="display: flex; justify-content: center; gap: 12px; margin-bottom: 50px; flex-wrap: wrap;">
      <a href="projects.php?cat=All" class="btn <?= $filter_cat === 'All' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">All</a>
      <a href="projects.php?cat=Web & Cloud Portals" class="btn <?= $filter_cat === 'Web & Cloud Portals' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">Web</a>
      <a href="projects.php?cat=Mobile Enterprise Apps" class="btn <?= $filter_cat === 'Mobile Enterprise Apps' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">Mobile</a>
      <a href="projects.php?cat=Industrial IoT & Automation" class="btn <?= $filter_cat === 'Industrial IoT & Automation' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">IoT</a>
      <a href="projects.php?cat=Cloud & AMC" class="btn <?= $filter_cat === 'Cloud & AMC' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">Cloud</a>
    </div>

    <!-- PROJECTS GRID -->
    <div class="grid grid-2" style="gap: 35px;" id="projectsGrid">
      <?php if (empty($projects)): ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: white; border-radius: 12px; color: var(--text-muted); box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
          <div style="font-size: 2rem; margin-bottom: 10px;">🏛️</div>
          <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">No Projects Found</h3>
          <p style="margin: 0;">We currently don't have any projects matching this category filter. Please check back soon.</p>
        </div>
      <?php else: ?>
        <?php foreach ($projects as $prj): ?>
          <div class="card project-card-item" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 5px solid var(--primary);">
            <div>
              <!-- CLIENT BADGE ROW -->
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                <span class="badge badge-primary"><?= htmlspecialchars($prj['client_name']); ?></span>
                <span class="badge badge-accent"><?= htmlspecialchars($prj['industry']); ?></span>
              </div>

              <h3 style="font-size: 1.45rem; font-weight: 800; color: var(--text-main); margin-bottom: 12px; line-height: 1.3;">
                <?= htmlspecialchars($prj['title']); ?>
              </h3>

              <!-- TECH STACK TAGS -->
              <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 20px;">
                <?php foreach (explode(',', $prj['tech_stack']) as $tech): ?>
                  <span style="font-size: 0.75rem; font-weight: 700; background: var(--bg-light); color: var(--text-body); padding: 3px 10px; border-radius: 6px; border: 1px solid var(--border-color);">
                    <?= htmlspecialchars(trim($tech)); ?>
                  </span>
                <?php endforeach; ?>
              </div>

              <!-- CHALLENGE & SOLUTION -->
              <div style="margin-bottom: 18px; background: var(--bg-soft); padding: 16px; border-radius: 8px; border: 1px solid var(--border-color);">
                <h4 style="font-size: 0.85rem; font-weight: 800; color: var(--primary); text-transform: uppercase; margin-bottom: 4px;">THE CHALLENGE:</h4>
                <p style="font-size: 0.95rem; color: var(--text-muted); margin: 0; line-height: 1.6;"><?= htmlspecialchars($prj['challenge']); ?></p>
              </div>

              <div style="margin-bottom: 22px;">
                <h4 style="font-size: 0.85rem; font-weight: 800; color: var(--text-main); text-transform: uppercase; margin-bottom: 4px;">OUR ENGINEERING SOLUTION:</h4>
                <p style="font-size: 0.95rem; color: var(--text-main); margin: 0; line-height: 1.6;"><?= htmlspecialchars($prj['solution']); ?></p>
              </div>
            </div>

            <!-- MEASURABLE RESULTS -->
            <div style="padding-top: 18px; border-top: 1px dashed var(--border-color); background: rgba(43, 125, 95, 0.08); padding: 16px; border-radius: 8px; border: 1px solid rgba(43, 125, 95, 0.25);">
              <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <span style="font-size: 1.1rem;">📈</span>
                <strong style="font-size: 0.85rem; color: var(--accent-hover); text-transform: uppercase;">MEASURABLE ENTERPRISE IMPACT:</strong>
              </div>
              <p style="font-size: 0.95rem; font-weight: 800; color: var(--text-main); margin: 0; line-height: 1.5;">
                <?= htmlspecialchars($prj['results']); ?>
              </p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- CLIENT COLLABORATION CALL -->
<section style="background: white; text-align: center;">
  <div class="container" style="max-width: 750px;">
    <span class="badge badge-primary" style="margin-bottom: 15px;">Partner With Us</span>
    <h2 style="font-size: 2.3rem; font-weight: 900; margin-bottom: 15px; color: var(--text-main);">Have a Business-Critical IT Requirement?</h2>
    <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 30px; line-height: 1.7;">
      Our customer services business unit delivers end-to-end solutions that build, manage, and support corporate organizations with ISO-certified quality and rapid deployment.
    </p>
    <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
      <a href="contact.php?subject=Enterprise+Project+Inquiry" class="btn btn-primary" style="padding: 14px 32px; font-size: 1rem;">Consult</a>
      <a href="services.php" class="btn btn-outline" style="padding: 14px 32px; font-size: 1rem;">Explore</a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
