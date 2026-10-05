<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme
 * Complete Multipage CMS Portal - Public Home Page (index.php)
 * Pure Corporate IT Consulting, Website & Mobile App Dev, & Client Projects
 */
require_once __DIR__ . '/includes/functions.php';

$current_page = 'home';
$page_title = 'Home - Corporate IT Consulting, Website & Mobile App Development';
require_once __DIR__ . '/includes/header.php';

// Fetch MySQL Data
$settings = get_all_settings();
$banners = get_hero_banners('active');
$why_us_panels = get_feature_panels('why_us', 'active');
$capabilities = get_feature_panels('capabilities', 'active');
$case_studies = get_case_studies('active', 3);
$featured_projects = get_projects('active', null, 2);
$featured_expertise = get_expertise_areas('active', null);
$featured_services = get_services('active', null, 3);
$featured_jobs = get_job_openings('active', null);
$recent_testimonials = get_testimonials('all', 3);
?>

<!-- TOP ANNOUNCEMENT BAR -->
<?php if (!empty($settings['announcement_active']) && $settings['announcement_active'] == '1'): ?>
<div class="news-ticker">
  <span class="news-badge">WHAT'S NEW</span>
  <span><?= htmlspecialchars($settings['announcement_text'] ?? '🚀 Custom Website Development, Mobile Apps & 24/7 AMC Maintenance Services in Nagpur & Global'); ?></span>
  <?php if (!empty($settings['announcement_url'])): ?>
    <a href="<?= htmlspecialchars($settings['announcement_url']); ?>" style="color: var(--primary); text-decoration: underline; font-weight: 700; margin-left: 5px;">Explore</a>
  <?php endif; ?>
</div>
<?php endif; ?>

<!-- HERO CAROUSEL SHOWCASE WITH 100% COMPLETE-WIDTH BACKGROUND IMAGES -->
<section class="hero-section-wrapper" style="padding: 0; margin: 0; width: 100%; position: relative; overflow: hidden;" id="home">
  <?php if (empty($banners)): ?>
    <div style="width: 100%; min-height: 600px; background: linear-gradient(135deg, var(--dark-3), var(--dark-2)); display: flex; align-items: center; justify-content: center; text-align: center; padding: 100px 20px;">
      <div class="container" style="max-width: 900px;">
        <div class="font-tagline-script" style="margin-bottom: 20px;"><?= htmlspecialchars($settings['tagline'] ?? 'Right People, Right Time, Right Place'); ?></div>
        <h1 class="hero-title" style="font-size: 3.8rem; font-weight: 900; line-height: 1.15; color: white;">Empowering Corporate Enterprises Through Technology</h1>
      </div>
    </div>
  <?php else: ?>
    <div id="heroCarousel" style="width: 100%; position: relative;">
      <?php foreach ($banners as $idx => $bnr): ?>
        <div class="hero-slide" id="slide-<?= $idx; ?>" style="display: <?= $idx === 0 ? 'flex' : 'none'; ?>; width: 100%; min-height: 650px; background-image: linear-gradient(135deg, rgba(9, 13, 22, 0.82) 0%, rgba(24, 34, 53, 0.75) 50%, rgba(9, 13, 22, 0.88) 100%), url('<?= htmlspecialchars($bnr['bg_image'] ?? 'assets/images/banner1.jpg'); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; flex-direction: column; justify-content: center; align-items: center; position: relative; padding: 120px 20px 80px;">
          <div class="container" style="max-width: 1050px; text-align: center; position: relative; z-index: 2;">
            <!-- CURSIVE BRUSH TAGLINE MATCHING LOGO.PNG -->
            <div class="font-tagline-script" style="margin-bottom: 15px; font-size: 1.8rem; color: var(--warning);"><?= htmlspecialchars($settings['tagline'] ?? 'Right People, Right Time, Right Place'); ?></div>
            <div class="badge badge-primary" style="margin-bottom: 20px; background: rgba(55, 106, 155,0.25); color: var(--on-dark-accent); border: 1px solid rgba(55, 106, 155,0.5);"><?= htmlspecialchars($bnr['badge_text']); ?></div>
            <h1 class="hero-title" style="font-size: 3.8rem; font-weight: 900; line-height: 1.15; margin-bottom: 25px; color: white; text-shadow: 0 4px 10px rgba(0,0,0,0.5);"><?= htmlspecialchars($bnr['title']); ?></h1>
            <p class="hero-desc" style="font-size: 1.25rem; color: var(--border-color); margin: 0 auto 40px; max-width: 850px; line-height: 1.8; text-shadow: 0 2px 5px rgba(0,0,0,0.4);"><?= htmlspecialchars($bnr['subtitle']); ?></p>
            <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
              <a href="<?= htmlspecialchars($bnr['cta_url']); ?>" class="btn btn-primary" style="padding: 15px 34px; font-size: 1.05rem; box-shadow: 0 10px 25px rgba(55, 106, 155,0.4);"><?= htmlspecialchars(livepro_button_label($bnr['cta_text'], 'Explore')); ?> &rarr;</a>
              <a href="about.php" class="btn btn-outline-light" style="padding: 15px 34px; font-size: 1.05rem;">Foundation</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if (count($banners) > 1): ?>
        <div style="position: absolute; bottom: 30px; left: 0; right: 0; display: flex; justify-content: center; align-items: center; gap: 12px; z-index: 10;">
          <?php foreach ($banners as $idx => $bnr): ?>
            <button onclick="switchHeroSlide(<?= $idx; ?>)" class="hero-dot <?= $idx === 0 ? 'active' : ''; ?>" style="width: <?= $idx === 0 ? '40px' : '14px'; ?>; height: 14px; border-radius: 99px; background: <?= $idx === 0 ? 'var(--primary)' : 'rgba(255,255,255,0.4)'; ?>; border: 2px solid rgba(0,0,0,0.3); cursor: pointer; transition: 0.3s; box-shadow: 0 2px 6px rgba(0,0,0,0.4);"></button>
          <?php endforeach; ?>
        </div>
        <script>
          let currentHeroIdx = 0; const totalHeroSlides = <?= count($banners); ?>;
          function switchHeroSlide(idx) {
            document.querySelectorAll('.hero-slide').forEach((el, i) => { el.style.display = (i === idx ? 'flex' : 'none'); });
            document.querySelectorAll('.hero-dot').forEach((dot, i) => { dot.style.background = (i === idx ? 'var(--primary)' : 'rgba(255,255,255,0.4)'); dot.style.width = (i === idx ? '40px' : '14px'); });
            currentHeroIdx = idx;
          }
          setInterval(() => { switchHeroSlide((currentHeroIdx + 1) % totalHeroSlides); }, 6000);
        </script>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</section>

<!-- STATS COUNTER BAR -->
<section style="background: var(--dark-3); padding: 45px 0; border-bottom: 1px solid rgba(255,255,255,0.1); margin-top: 0;">
  <div class="container">
    <div class="hero-stats" style="margin: 0; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1);">
      <div style="text-align: center;"><div class="stat-value"><?= htmlspecialchars($settings['stat_years'] ?? '15+'); ?></div><div class="stat-label">Years of IT Excellence</div></div>
      <div style="text-align: center;"><div class="stat-value"><?= htmlspecialchars($settings['stat_projects'] ?? '500+'); ?></div><div class="stat-label">Enterprise Projects</div></div>
      <div style="text-align: center;"><div class="stat-value"><?= htmlspecialchars($settings['stat_engineers'] ?? '120+'); ?></div><div class="stat-label">Engineering Experts</div></div>
      <div style="text-align: center;"><div class="stat-value"><?= htmlspecialchars($settings['stat_industries'] ?? '16+'); ?></div><div class="stat-label">Domain Verticals</div></div>
    </div>
  </div>
</section>



<!-- FEATURED PROJECTS & CLIENTS SHOWCASE -->
<section style="background: var(--bg-light);">
  <div class="container">
    <div class="section-header">
      <span class="badge badge-primary">Proven Deliverables</span>
      <h2 class="section-title">Featured Projects &amp; Enterprise Clients</h2>
      <p class="section-desc">Our engineering domain knowledge enables us to concentrate specifically on our clients' business needs across banking, industrial IoT, logistics, and retail e-commerce.</p>
    </div>

    <div class="grid grid-2" style="gap: 30px;">
      <?php foreach ($featured_projects as $prj): ?>
        <div class="card" style="border-top: 5px solid var(--primary);">
          <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
              <span class="badge badge-primary"><?= htmlspecialchars($prj['client_name']); ?></span>
              <span class="badge badge-accent"><?= htmlspecialchars($prj['industry']); ?></span>
            </div>
            <h3 style="font-size: 1.4rem; font-weight: 800; color: var(--text-main); margin-bottom: 12px;"><?= htmlspecialchars($prj['title']); ?></h3>
            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 18px;">
              <?php foreach (explode(',', $prj['tech_stack']) as $t): ?>
                <span style="font-size: 0.75rem; font-weight: 700; background: var(--bg-light); color: var(--text-body); padding: 3px 8px; border-radius: 4px; border: 1px solid var(--border-color);"><?= htmlspecialchars(trim($t)); ?></span>
              <?php endforeach; ?>
            </div>
            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;"><?= htmlspecialchars(substr($prj['solution'], 0, 160)); ?>...</p>
          </div>
          <div style="padding-top: 15px; border-top: 1px dashed var(--border-color); background: rgba(43, 125, 95,0.06); padding: 14px; border-radius: 6px; border: 1px solid rgba(43, 125, 95,0.2);">
            <strong style="font-size: 0.8rem; color: var(--accent-hover); text-transform: uppercase; display: block; margin-bottom: 4px;">📈 MEASURABLE IMPACT:</strong>
            <p style="font-size: 0.95rem; font-weight: 700; color: var(--text-main); margin: 0;"><?= htmlspecialchars($prj['results']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <a href="projects.php" class="btn btn-primary" style="padding: 14px 32px;">Explore</a>
    </div>
  </div>
</section>

<!-- TECHNOLOGICAL EXPERTISE & METHODOLOGIES -->
<section style="background: white;">
  <div class="container">
    <div class="section-header">
      <span class="badge badge-primary">Technical Mastery</span>
      <h2 class="section-title">Our Technological Expertise</h2>
      <p class="section-desc">We provide software services using the best of existing and emerging technologies across website development, mobile app development, cloud DevOps, AI, and embedded hardware.</p>
    </div>

    <div class="grid grid-3">
      <?php foreach (array_slice($featured_expertise, 0, 3) as $exp): ?>
        <div class="card">
          <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
              <span class="badge badge-primary"><?= htmlspecialchars($exp['category']); ?></span>
              <span style="font-size: 0.8rem; font-weight: 800; color: var(--primary); background: rgba(55, 106, 155,0.1); padding: 3px 8px; border-radius: 4px;"><?= intval($exp['proficiency']); ?>% PROFICIENCY</span>
            </div>
            <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--text-main); margin-bottom: 10px;"><?= htmlspecialchars($exp['title']); ?></h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 18px;"><?= htmlspecialchars($exp['description']); ?></p>
            <div style="background: var(--bg-light); height: 8px; border-radius: 99px; overflow: hidden; margin-bottom: 20px;">
              <div style="height: 100%; width: <?= intval($exp['proficiency']); ?>%; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 99px;"></div>
            </div>
            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
              <?php foreach (explode(',', $exp['tech_list']) as $t): ?>
                <span style="font-size: 0.75rem; font-weight: 700; background: rgba(55, 106, 155,0.08); color: var(--primary); padding: 3px 8px; border-radius: 4px;"><?= htmlspecialchars(trim($t)); ?></span>
              <?php endforeach; ?>
            </div>
          </div>
          <div style="padding-top: 18px; border-top: 1px solid var(--border-color); margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">LIVEpro Tech Stack</span>
            <a href="expertise.php" class="btn btn-outline btn-sm">Explore</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <a href="expertise.php" class="btn btn-outline" style="padding: 14px 32px;">Explore</a>
    </div>
  </div>
</section>

<!-- TWO ZEROED-IN SECTORS -->
<section style="background: var(--bg-light);">
  <div class="container">
    <div class="section-header">
      <span class="badge badge-primary">Foundation</span>
      <h2 class="section-title">Zeroed-In to Serve Two Corporate IT Sectors</h2>
      <p class="section-desc">We have a perfect blend of Indian and International perspective providing the necessary insight and skills for business situations worldwide.</p>
    </div>

    <div class="grid grid-2" style="gap: 40px;">
      <div class="card" style="border-top: 5px solid var(--primary);">
        <span class="badge badge-primary" style="margin-bottom: 15px;">Corporate IT Sector 01</span>
        <h3 style="font-size: 1.7rem; font-weight: 800; margin-bottom: 15px; color: var(--text-main);">Custom Software &amp; Web/Mobile Dev</h3>
        <p style="color: var(--text-muted); margin-bottom: 20px; line-height: 1.7;">We deliver comprehensive systems development services from requirement analysis and architectural design to full-cycle coding and cloud deployment. Our team builds high-performance website portals, progressive web apps, and native iOS/Android mobile apps.</p>
        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 30px;">
          <div style="display: flex; align-items: flex-start; gap: 12px; font-size: 0.95rem; color: var(--text-body);"><span style="color: var(--primary); font-weight: 800;">✔</span><div><strong>Website Development:</strong> React, Next.js, Node.js, PHP Laravel, &amp; Spring Boot portals.</div></div>
          <div style="display: flex; align-items: flex-start; gap: 12px; font-size: 0.95rem; color: var(--text-body);"><span style="color: var(--primary); font-weight: 800;">✔</span><div><strong>Mobile App Development:</strong> Native iOS/Android &amp; Flutter cross-platform enterprise apps.</div></div>
          <div style="display: flex; align-items: flex-start; gap: 12px; font-size: 0.95rem; color: var(--text-body);"><span style="color: var(--primary); font-weight: 800;">✔</span><div><strong>Custom Software:</strong> Standalone ERPs, WMS inventory tracking, &amp; workflow automation.</div></div>
        </div>
        <a href="expertise.php" class="btn btn-primary">Explore</a>
      </div>

      <div class="card" style="border-top: 5px solid var(--accent);">
        <span class="badge badge-accent" style="margin-bottom: 15px;">Corporate IT Sector 02</span>
        <h3 style="font-size: 1.7rem; font-weight: 800; margin-bottom: 15px; color: var(--text-main);">Onsite Support, AMC &amp; Re-Engineering</h3>
        <p style="color: var(--text-muted); margin-bottom: 20px; line-height: 1.7;">Ensure continuous uptime and optimal performance for your business-critical systems. We provide scheduled hardware diagnostics, software version management, database tuning, and immediate incident troubleshooting under 24/7 AMC contracts.</p>
        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 30px;">
          <div style="display: flex; align-items: flex-start; gap: 12px; font-size: 0.95rem; color: var(--text-body);"><span style="color: var(--accent); font-weight: 800;">✔</span><div><strong>24/7 AMC Maintenance:</strong> Proactive hardware/software monitoring & SLA uptime guarantee.</div></div>
          <div style="display: flex; align-items: flex-start; gap: 12px; font-size: 0.95rem; color: var(--text-body);"><span style="color: var(--accent); font-weight: 800;">✔</span><div><strong>Legacy Re-Engineering:</strong> Monolithic modernization into cloud microservices.</div></div>
          <div style="display: flex; align-items: flex-start; gap: 12px; font-size: 0.95rem; color: var(--text-body);"><span style="color: var(--accent); font-weight: 800;">✔</span><div><strong>Network Cybersecurity:</strong> VPN administration, multi-layer firewalls, & security audits.</div></div>
        </div>
        <a href="services.php" class="btn btn-accent">Explore</a>
      </div>
    </div>
  </div>
</section>

<!-- CAREERS & JOB OPENINGS PORTAL -->
<section style="background: white;">
  <div class="container">
    <div class="section-header">
      <span class="badge badge-accent">Join</span>
      <h2 class="section-title">Careers &amp; Engineering Openings</h2>
      <p class="section-desc">Explore open corporate engineering positions in Nagpur and hybrid across India. Click any role to apply instantly.</p>
    </div>

    <div class="grid grid-2" style="gap: 30px;">
      <?php foreach (array_slice($featured_jobs, 0, 2) as $job): ?>
        <div class="card" style="border-left: 5px solid var(--primary);">
          <div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
              <span class="badge badge-primary"><?= htmlspecialchars($job['department']); ?></span>
              <span style="font-size: 0.8rem; font-weight: 700; color: var(--accent-hover); background: rgba(43, 125, 95,0.15); padding: 4px 10px; border-radius: 4px;"><?= htmlspecialchars($job['salary']); ?></span>
            </div>
            <h3 style="font-size: 1.35rem; font-weight: 800; color: var(--text-main); margin-bottom: 10px;"><?= htmlspecialchars($job['title']); ?></h3>
            <div style="display: flex; gap: 15px; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 15px; flex-wrap: wrap;">
              <span>📍 <strong><?= htmlspecialchars($job['location']); ?></strong></span><span>🕒 <strong><?= htmlspecialchars($job['type']); ?></strong></span><span>🎓 <strong><?= htmlspecialchars($job['experience']); ?></strong></span>
            </div>
            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 25px;"><?= htmlspecialchars($job['description']); ?></p>
          </div>
          <div style="padding-top: 18px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">LIVEpro Engineering</span>
            <a href="careers.php" class="btn btn-primary">Apply</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <a href="careers.php" class="btn btn-accent" style="padding: 14px 32px;">Explore</a>
    </div>
  </div>
</section>

<!-- TESTIMONIALS ROW -->
<section style="background: var(--bg-light);">
  <div class="container">
    <div class="section-header">
      <span class="badge badge-warning">Success Stories</span>
      <h2 class="section-title">What Our Enterprise Clients Say</h2>
      <p class="section-desc">Feedback from corporate leaders who trust our website development, mobile apps, and 24/7 AMC maintenance.</p>
    </div>

    <div class="grid grid-3">
      <?php foreach ($recent_testimonials as $tst): ?>
        <div class="card" style="background: white;">
          <div style="color: var(--warning); margin-bottom: 12px; font-size: 1.1rem;">
            <?= str_repeat('★', intval($tst['rating'] ?? 5)) . str_repeat('☆', 5 - intval($tst['rating'] ?? 5)); ?>
          </div>
          <p style="font-style: italic; color: var(--text-main); margin-bottom: 20px; line-height: 1.7;">&ldquo;<?= htmlspecialchars($tst['quote']); ?>&rdquo;</p>
          <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem;">
              <?= strtoupper(substr($tst['name'], 0, 1)); ?>
            </div>
            <div>
              <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0; color: var(--text-main);"><?= htmlspecialchars($tst['name']); ?></h4>
              <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;"><?= htmlspecialchars($tst['role']); ?> &bull; <strong style="color: var(--primary);"><?= htmlspecialchars($tst['type']); ?></strong></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA SECTION -->
<section style="background: linear-gradient(135deg, var(--dark-3), var(--dark-2)); color: white; text-align: center;">
  <div class="container" style="max-width: 750px;">
    <span class="badge" style="background: rgba(55, 106, 155,0.2); color: var(--on-dark-accent); margin-bottom: 15px;">Perpetually Adaptive IT</span>
    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 20px; color: white;">Ready to Accelerate Your Corporate IT Transformation?</h2>
    <p style="font-size: 1.1rem; color: var(--text-on-dark-muted); margin-bottom: 35px; line-height: 1.8;">
      Whether you need custom website development, mobile app development, systems re-engineering, or 24/7 AMC maintenance support, our Nagpur team is ready to assist.
    </p>
    <a href="contact.php" class="btn btn-accent" style="padding: 16px 36px; font-size: 1.1rem; box-shadow: 0 10px 20px rgba(43, 125, 95,0.35);">Contact</a>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
