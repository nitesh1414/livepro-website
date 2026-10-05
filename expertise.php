<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (LP Geometric Logo Theme)
 * Technological Expertise & Methodologies (expertise.php)
 */
require_once __DIR__ . '/includes/functions.php';

$current_page = 'expertise';
$page_title = 'Technological Expertise & Stack';
require_once __DIR__ . '/includes/header.php';

$filter_cat = $_GET['cat'] ?? 'All';
$expertise = get_expertise_areas('active', $filter_cat);
?>

<!-- PAGE HEADER -->
<section style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%); color: white; padding: 70px 0; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <div class="container" style="max-width: 850px;">
    <span class="badge" style="background: rgba(26,133,232,0.2); color: #60a5fa; margin-bottom: 15px;">Technical Mastery</span>
    <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 15px; color: white;">Technological Expertise</h1>
    <p style="font-size: 1.15rem; color: #cbd5e1; line-height: 1.7;">
      We provide corporate software services using the best of existing and emerging technologies across website development, mobile app development, cloud DevOps, AI, and embedded hardware.
    </p>
  </div>
</section>

<!-- CATEGORY FILTER TABS & LIVE SEARCH -->
<section style="background: var(--bg-light); padding: 80px 0;">
  <div class="container">
    
    <!-- LIVE SEARCH BOX -->
    <div class="live-search-box">
      <span class="live-search-icon">🔍</span>
      <input type="text" class="live-search-input" placeholder="Search expertise domains, frameworks, or tools..." onkeyup="liveSearchExpertise(this.value)">
    </div>

    <div style="display: flex; justify-content: center; gap: 12px; margin-bottom: 50px; flex-wrap: wrap;">
      <a href="expertise.php?cat=All" class="btn <?= $filter_cat === 'All' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">All Domains</a>
      <a href="expertise.php?cat=Core Engineering" class="btn <?= $filter_cat === 'Core Engineering' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">Core Engineering</a>
      <a href="expertise.php?cat=Cloud DevOps" class="btn <?= $filter_cat === 'Cloud DevOps' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">Cloud DevOps</a>
      <a href="expertise.php?cat=AI & Intelligence" class="btn <?= $filter_cat === 'AI & Intelligence' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">AI &amp; Intelligence</a>
      <a href="expertise.php?cat=Embedded Hardware" class="btn <?= $filter_cat === 'Embedded Hardware' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">Embedded Hardware</a>
      <a href="expertise.php?cat=Quality Assurance" class="btn <?= $filter_cat === 'Quality Assurance' ? 'btn-primary' : 'btn-outline'; ?>" style="border-radius: 99px; padding: 10px 24px;">Quality Assurance</a>
    </div>

    <!-- EXPERTISE GRID -->
    <div class="grid grid-3" style="gap: 30px;" id="expertiseGrid">
      <?php if (empty($expertise)): ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: white; border-radius: 12px; color: #64748b; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
          <div style="font-size: 2rem; margin-bottom: 10px;">🧠</div>
          <h3 style="font-size: 1.3rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">No Expertise Domains Found</h3>
          <p style="margin: 0;">We currently don't have any expertise entries matching this category filter.</p>
        </div>
      <?php else: ?>
        <?php foreach ($expertise as $exp): ?>
          <div class="card expertise-card-item" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 4px solid var(--primary);">
            <div>
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <span class="badge badge-primary"><?= htmlspecialchars($exp['category']); ?></span>
                <span style="font-size: 0.85rem; font-weight: 800; color: #1a85e8; background: rgba(26,133,232,0.1); padding: 4px 10px; border-radius: 6px; border: 1px solid rgba(26,133,232,0.25);">
                  <?= intval($exp['proficiency'] ?? 95); ?>% PROFICIENCY
                </span>
              </div>

              <h3 style="font-size: 1.35rem; font-weight: 800; color: var(--text-main); margin-bottom: 12px;">
                <?= htmlspecialchars($exp['title']); ?>
              </h3>

              <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                <?= htmlspecialchars($exp['description']); ?>
              </p>

              <!-- PROFICIENCY BAR -->
              <div style="background: rgba(15,23,42,0.06); height: 8px; border-radius: 99px; overflow: hidden; margin-bottom: 25px;">
                <div style="height: 100%; width: <?= intval($exp['proficiency'] ?? 95); ?>%; background: linear-gradient(90deg, #1a85e8, #58b32e); border-radius: 99px;"></div>
              </div>

              <!-- TECH STACK TAGS -->
              <div style="margin-bottom: 10px;">
                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; display: block; margin-bottom: 8px; text-transform: uppercase;">TOOLS &amp; TECHNOLOGIES:</span>
                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                  <?php foreach (explode(',', $exp['tech_list']) as $t): ?>
                    <span style="font-size: 0.75rem; font-weight: 700; background: white; color: #1a85e8; padding: 4px 10px; border-radius: 6px; border: 1px solid var(--border-color);">
                      <?= htmlspecialchars(trim($t)); ?>
                    </span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

            <div style="padding-top: 20px; border-top: 1px solid var(--border-color); margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">LIVEpro Tech Stack</span>
              <a href="contact.php?subject=Technical+Consultation" class="btn btn-outline btn-sm">Consult Our Team &rarr;</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- INTERACTIVE PROJECT COST & TIMELINE ESTIMATOR CALCULATOR -->
<section style="background: white;">
  <div class="container">
    <div class="section-header">
      <span class="badge badge-primary">Interactive Estimator</span>
      <h2 class="section-title">Calculate Your Project Cost &amp; Timeline</h2>
      <p class="section-desc">Select your service requirements, scale, and desired delivery speed below for an instant interactive estimate.</p>
    </div>

    <div class="estimator-widget" id="estimatorWidget">
      <!-- Step 1: Service Type -->
      <div class="estimator-step">
        <h4>1. What type of software solution do you require?</h4>
        <div class="option-pills">
          <button type="button" class="option-pill active" onclick="selectEstOption('service', 'Website & Web App Portal', this)">🌐 Website &amp; Web App Portal</button>
          <button type="button" class="option-pill" onclick="selectEstOption('service', 'Mobile App Dev (iOS & Android)', this)">📱 Mobile App Dev (iOS &amp; Android)</button>
          <button type="button" class="option-pill" onclick="selectEstOption('service', 'Systems Integration & Re-Engineering', this)">🔄 Systems Re-Engineering</button>
          <button type="button" class="option-pill" onclick="selectEstOption('service', 'AI & Cognitive Business Operations', this)">🤖 AI &amp; Generative LLMs</button>
          <button type="button" class="option-pill" onclick="selectEstOption('service', '24/7 AMC Support & Maintenance', this)">🖥️ 24/7 AMC Support</button>
        </div>
      </div>

      <!-- Step 2: Project Scale -->
      <div class="estimator-step">
        <h4>2. What is the target scale and complexity?</h4>
        <div class="option-pills">
          <button type="button" class="option-pill" onclick="selectEstOption('scale', 'Startup MVP / Fast Track', this)">🚀 Startup MVP / Fast Track</button>
          <button type="button" class="option-pill active" onclick="selectEstOption('scale', 'Mid-Size Enterprise Scale', this)">🏢 Mid-Size Enterprise Scale</button>
          <button type="button" class="option-pill" onclick="selectEstOption('scale', 'Global MNC Scale & High Concurrency', this)">🌍 Global MNC Scale &amp; High Traffic</button>
        </div>
      </div>

      <!-- Step 3: Delivery Timeline -->
      <div class="estimator-step">
        <h4>3. What is your desired deployment timeline?</h4>
        <div class="option-pills">
          <button type="button" class="option-pill" onclick="selectEstOption('timeline', 'Rush Delivery (1-2 Months)', this)">⚡ Rush Delivery (1-2 Months)</button>
          <button type="button" class="option-pill active" onclick="selectEstOption('timeline', 'Standard Delivery (3-4 Months)', this)">⏱️ Standard Delivery (3-4 Months)</button>
          <button type="button" class="option-pill" onclick="selectEstOption('timeline', 'Long-term Partnership / Retainer', this)">🤝 Long-term Retainer / AMC</button>
        </div>
      </div>

      <!-- Result Box -->
      <div class="estimate-result-box">
        <div>
          <span style="font-size: 0.8rem; color: #38bdf8; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">INSTANT INTERACTIVE ESTIMATE</span>
          <h3 style="font-size: 2.2rem; font-weight: 900; margin: 4px 0 2px; color: white;" id="estCostDisplay">₹80K - ₹150K</h3>
          <p style="font-size: 0.95rem; color: #cbd5e1; margin: 0;">Estimated Timeline: <strong style="color: #34d399;" id="estTimeDisplay">3 - 4 Months</strong></p>
          <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 6px;" id="estDescDisplay">Estimated for: Website &amp; Web App Portal (Mid-Size Enterprise Scale) under Standard Delivery.</p>
        </div>
        <div>
          <button type="button" onclick="bookEstimateConsultation()" class="btn btn-accent" style="padding: 15px 30px; font-size: 1.05rem; box-shadow: 0 10px 20px rgba(34,163,22,0.4);">
            🔒 Lock In Estimate &amp; Book Consultation &rarr;
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- METHODOLOGY PILLARS -->
<section style="background: white;">
  <div class="container">
    <div class="section-header">
      <span class="badge badge-primary">How We Work</span>
      <h2 class="section-title">Well-Defined Development Methodologies</h2>
      <p class="section-desc">Our goal is to achieve the best combination of cost, quality, and speed of development through rigorous engineering frameworks.</p>
    </div>

    <div class="grid grid-3">
      <div class="card" style="background: var(--bg-light); border-top: 4px solid #1a85e8;">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 10px; color: var(--text-main);">1. Agile &amp; Sprint Ceremonies</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">We deploy continuous integration sprints, iterative backlog grooming, and transparent Jira reporting to keep stakeholders aligned at every development phase.</p>
      </div>
      <div class="card" style="background: var(--bg-light); border-top: 4px solid #58b32e;">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 10px; color: var(--text-main);">2. Zero-Defect DevOps</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">Automated regression testing, SonarQube static code audits, and containerized Docker deployments eliminate production bottlenecks and security flaws.</p>
      </div>
      <div class="card" style="background: var(--bg-light); border-top: 4px solid #f5d118;">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 10px; color: var(--text-main);">3. ISO-Certified Governance</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">We maintain the utmost level of customer satisfaction by offering world-class services that adhere to international quality benchmarks.</p>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
