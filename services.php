<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (LP Geometric Logo Theme)
 * Complete Multipage CMS Portal - IT Services Catalog Page (services.php)
 * Pure Corporate IT Consulting, Website & Mobile App Dev, & Client Projects
 */
require_once __DIR__ . '/includes/functions.php';

$current_page = 'services';
$page_title = 'Our IT & Software Development Capabilities';
require_once __DIR__ . '/includes/header.php';

$services = get_services('active', 'all');
?>

<!-- PAGE HEADER -->
<section style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%); color: white; padding: 70px 0; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <div class="container" style="max-width: 800px;">
    <span class="badge" style="background: rgba(26,133,232,0.2); color: #60a5fa; margin-bottom: 15px;">Domain Expertise</span>
    <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 15px; color: white;">IT Capabilities &amp; Services</h1>
    <p style="font-size: 1.15rem; color: #cbd5e1; line-height: 1.7;">
      We provide a variety of software services to help our corporate customers in any part of the globe using the best of existing and new technologies, according to their strategic KPIs.
    </p>
  </div>
</section>

<!-- SERVICES CATALOG -->
<section style="background: var(--bg-light); padding: 80px 0;">
  <div class="container">
    
    <!-- FILTER TABS -->
    <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 50px; flex-wrap: wrap;">
      <button class="filter-tab active btn btn-primary" onclick="filterServices('All', this)" style="border-radius: 99px; padding: 10px 24px;">All Capabilities</button>
      <button class="filter-tab btn btn-outline" onclick="filterServices('Web & Mobile', this)" style="border-radius: 99px; padding: 10px 24px;">Web &amp; Mobile Dev</button>
      <button class="filter-tab btn btn-outline" onclick="filterServices('Corporate IT', this)" style="border-radius: 99px; padding: 10px 24px;">Corporate IT Solutions</button>
      <button class="filter-tab btn btn-outline" onclick="filterServices('AI & Platforms', this)" style="border-radius: 99px; padding: 10px 24px;">AI &amp; Cognitive Platforms</button>
    </div>

    <!-- SERVICES GRID -->
    <div class="grid grid-3" id="servicesGrid">
      <?php if (empty($services)): ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: white; border-radius: 12px; color: #64748b;">
          No active IT services found in the database.
        </div>
      <?php else: ?>
        <?php foreach ($services as $srv): ?>
          <div class="card service-card-item" data-category="<?= htmlspecialchars($srv['category']); ?>" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
              <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(26,133,232,0.12); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 800;">
                  <?= strtoupper(substr($srv['title'], 0, 1)); ?>
                </div>
                <span class="badge <?= $srv['category'] === 'Corporate IT' ? 'badge-primary' : 'badge-accent'; ?>"><?= htmlspecialchars($srv['category']); ?></span>
              </div>
              <h3 style="font-size: 1.35rem; font-weight: 700; margin-bottom: 12px; color: var(--text-main);"><?= htmlspecialchars($srv['title']); ?></h3>
              <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 25px; line-height: 1.6;"><?= htmlspecialchars($srv['short_desc']); ?></p>
            </div>
            
            <div style="padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">LIVEpro Capability</span>
              <button onclick="viewServiceDetail('<?= addslashes(htmlspecialchars($srv['title'])); ?>', '<?= addslashes(htmlspecialchars($srv['category'])); ?>', '<?= addslashes(htmlspecialchars($srv['short_desc'])); ?>', '<?= addslashes(htmlspecialchars($srv['full_desc'])); ?>', '')" class="btn btn-outline btn-sm">
                Learn More &rarr;
              </button>
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
          <h3 style="font-size: 2.2rem; font-weight: 900; margin: 4px 0 2px; color: white;" id="estCostDisplay">₹8L - ₹14L</h3>
          <p style="font-size: 0.95rem; color: #cbd5e1; margin: 0;">Estimated Timeline: <strong style="color: #34d399;" id="estTimeDisplay">3 - 4 Months</strong></p>
          <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 6px;" id="estDescDisplay">Estimated for: Website &amp; Web App Portal (Mid-Size Enterprise Scale) under Standard Delivery.</p>
        </div>
        <div>
          <button type="button" onclick="bookEstimateConsultation()" class="btn btn-accent" style="padding: 15px 30px; font-size: 1.05rem; box-shadow: 0 10px 20px rgba(88,179,46,0.4);">
            🔒 Lock In Estimate &amp; Book Consultation &rarr;
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- BOTTOM CTA -->
<section style="background: var(--bg-light); text-align: center;">
  <div class="container" style="max-width: 700px;">
    <h2 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 15px; color: var(--text-main);">Need a Customized IT Solution?</h2>
    <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 30px;">Our customer services business unit handles the business-critical IT needs of corporate organizations. Contact our engineering team for an immediate consultation.</p>
    <a href="contact.php" class="btn btn-primary" style="padding: 14px 32px; font-size: 1rem;">Request Technical Consultation &rarr;</a>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
