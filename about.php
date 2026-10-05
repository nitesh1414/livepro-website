<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme
 * About Us Page (about.php)
 * Pure Corporate IT Consulting, Website & Mobile App Dev, & Client Projects
 */
require_once __DIR__ . '/includes/functions.php';

$current_page = 'about';
$page_title = 'About LIVEpro Software Solutions';
require_once __DIR__ . '/includes/header.php';
$settings = get_all_settings();
?>

<!-- PAGE HEADER -->
<section style="background: linear-gradient(135deg, var(--dark-3) 0%, var(--dark-2) 50%, var(--dark-3) 100%); color: white; padding: 70px 0; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <div class="container" style="max-width: 800px;">
    <div class="font-tagline-script" style="margin-bottom: 15px; font-size: 1.8rem; color: var(--warning);"><?= htmlspecialchars($settings['tagline'] ?? 'Right People, Right Time, Right Place'); ?></div>
    <span class="badge" style="background: rgba(255,255,255,0.2); color: white; margin-bottom: 15px;">Who We Are</span>
    <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 15px; color: white;">About</h1>
    <p style="font-size: 1.15rem; color: var(--text-on-dark-muted); line-height: 1.7;">
      We provide a wide range of solutions and services across various verticals in Information Technologies like Custom Website Development, Mobile App Development, Systems Implementation, Testing, Onsite Support, Platform Delivery, Networking, Outsourcing, and Application Management AMC Support.
    </p>
  </div>
</section>

<!-- MAIN CONTENT -->
<section style="background: white; padding: 80px 0;">
  <div class="container">
    <div class="grid grid-2" style="gap: 50px; align-items: center;">
      <div>
        <span class="badge badge-primary" style="margin-bottom: 15px;">Welcome to LIVEpro</span>
        <h2 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 20px; color: var(--text-main); line-height: 1.3;">
          Providing Best Corporate IT Solutions &amp; Engineering Insight
        </h2>
        <p style="color: var(--text-muted); font-size: 1.05rem; line-height: 1.8; margin-bottom: 20px;">
          We have zeroed-in to serve two basic enterprise sectors: <strong>Custom Software &amp; Web/Mobile App Development</strong> and <strong>Onsite Support, AMC &amp; Systems Integration</strong>. Our goal is to achieve the best combination of Cost, Quality, and Speed of development process for the maximum benefit of corporate customers.
        </p>
        <p style="color: var(--text-muted); font-size: 1.05rem; line-height: 1.8; margin-bottom: 30px;">
          We have a perfect blend of Indian and International perspective which provides the necessary insight and skills for tackling business situations both in domestic Indian and International markets. We work on the perception of strategic consultation and robust engineering, providing high quality teams to clients worldwide.
        </p>
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
          <div style="background: var(--bg-subtle); border: 1px solid var(--border-color); padding: 15px 20px; border-radius: 8px; flex: 1; min-width: 200px;">
            <strong style="color: var(--primary); font-size: 1.2rem; display: block; margin-bottom: 4px;">100% Quality</strong>
            <span style="font-size: 0.85rem; color: var(--text-muted);">ISO Certified Standards</span>
          </div>
          <div style="background: var(--bg-subtle); border: 1px solid var(--border-color); padding: 15px 20px; border-radius: 8px; flex: 1; min-width: 200px;">
            <strong style="color: var(--accent); font-size: 1.2rem; display: block; margin-bottom: 4px;">Nagpur HQ</strong>
            <span style="font-size: 0.85rem; color: var(--text-muted);">Raghuji Nagar Engineering Hub</span>
          </div>
        </div>
      </div>

      <div style="background: var(--bg-subtle); border: 1px solid var(--border-color); padding: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 25px; color: var(--text-main); border-bottom: 2px solid var(--primary); padding-bottom: 12px;">
          How We Achieve Excellence
        </h3>
        <div style="margin-bottom: 25px;">
          <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">1. Flexible Client Engagement Models</h4>
          <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">We tailor pricing, dedicated engineering team scaling, and project deliverables according to client agility requirements.</p>
        </div>
        <div style="margin-bottom: 25px;">
          <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">2. Well-Defined Development Methodologies</h4>
          <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">Proven Agile and DevOps practices ensuring rapid deployment, high code quality, automated testing, and continuous integration.</p>
        </div>
        <div>
          <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">3. Rigorous Project Management Approach</h4>
          <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">Dedicated sprint planning, risk mitigation, and transparent progress reporting from inception to post-deployment maintenance.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- DUAL PILLAR DEEP DIVE -->
<section style="background: var(--bg-subtle); padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <span class="badge badge-primary">Our Core Sectors</span>
      <h2 class="section-title">Deep Dive: Our Two Foundations</h2>
      <p class="section-desc">We have zeroed-in to serve two foundational corporate IT pillars.</p>
    </div>

    <div class="grid grid-2" style="gap: 40px;">
      <div class="card" style="background: white; border-top: 5px solid var(--primary);">
        <span class="badge badge-primary" style="margin-bottom: 15px;">Sector 01</span>
        <h3 style="font-size: 1.7rem; font-weight: 800; margin-bottom: 15px; color: var(--text-main);">Custom Software &amp; Web/Mobile Dev</h3>
        <p style="color: var(--text-muted); line-height: 1.8; margin-bottom: 20px;">
          We deliver comprehensive systems development services from requirement analysis and architectural design to full-cycle development and deployment. Our team builds robust enterprise web portals, e-commerce platforms, progressive web apps (PWAs), and native iOS/Android mobile applications.
        </p>
        <p style="color: var(--text-muted); line-height: 1.8; margin-bottom: 25px;">
          Our customer services business unit handles the business-critical software needs of corporate organizations utilizing React, Node.js, PHP, Python Django, Java Spring Boot, and Flutter.
        </p>
        <a href="expertise.php" class="btn btn-primary">Explore</a>
      </div>

      <div class="card" style="background: white; border-top: 5px solid var(--accent);">
        <span class="badge badge-accent" style="margin-bottom: 15px;">Sector 02</span>
        <h3 style="font-size: 1.7rem; font-weight: 800; margin-bottom: 15px; color: var(--text-main);">Onsite Support, AMC &amp; Re-Engineering</h3>
        <p style="color: var(--text-muted); line-height: 1.8; margin-bottom: 20px;">
          Ensure continuous uptime and optimal performance for your business-critical systems. We provide scheduled hardware diagnostics, software version management, database tuning, and immediate incident troubleshooting under 24/7 Annual Maintenance Contracts (AMC).
        </p>
        <p style="color: var(--text-muted); line-height: 1.8; margin-bottom: 25px;">
          We also transform monolithic legacy IT infrastructures into agile cloud microservices without business disruption through API orchestration and database migration.
        </p>
        <a href="services.php" class="btn btn-accent">Explore</a>
      </div>
    </div>
  </div>
</section>

<?php
// ============================================================================
// LEADERSHIP & MENTORSHIP PROFILES
// 100% managed from the CMS admin panel (admin/leaders.php)
// ============================================================================
$leaders = get_leaders_mentors('active', 'Leader');
$mentors = get_leaders_mentors('active', 'Mentor');
$all_members = array_merge($leaders, $mentors);
usort($all_members, function ($a, $b) {
    $order_a = intval($a['display_order'] ?? 0);
    $order_b = intval($b['display_order'] ?? 0);
    if ($order_a === $order_b) {
        return intval($a['id'] ?? 0) <=> intval($b['id'] ?? 0);
    }
    return $order_a <=> $order_b;
});
// The section is always visible to logged-in admins (so they can verify their
// CMS entries); visitors only see it once at least one profile is published.
$show_members_section = !empty($all_members) || is_admin_logged_in();
?>

<?php if ($show_members_section): ?>
<!-- LEADERSHIP & MENTORSHIP (POPULATED FROM ADMIN PANEL) -->
<section id="leadership" style="background: white; padding: 80px 0;">
  <div class="container">
    <div class="section-header">
      <span class="badge badge-primary">Leadership &amp; Mentorship</span>
      <h2 class="section-title">The Leaders &amp; Mentors Behind LIVEpro</h2>
      <p class="section-desc">
        Our leadership team owns strategy, architecture and delivery governance, while our mentors coach every
        engineering pod &mdash; from campus incubator graduates to senior architects. Every profile below is
        published and updated directly from the LIVEpro admin panel.
      </p>
    </div>

    <?php if (!empty($all_members)): ?>
      <?php if (!empty($leaders) && !empty($mentors)): ?>
        <div class="member-filter-bar" id="memberFilterTabs">
          <button type="button" class="btn btn-primary" onclick="filterMembers('All', this)">All <span class="badge badge-primary"><?= count($all_members); ?></span></button>
          <button type="button" class="btn btn-outline" onclick="filterMembers('Leader', this)">Leaders <span class="badge badge-primary"><?= count($leaders); ?></span></button>
          <button type="button" class="btn btn-outline" onclick="filterMembers('Mentor', this)">Mentors <span class="badge badge-primary"><?= count($mentors); ?></span></button>
        </div>
      <?php endif; ?>

      <div class="member-grid" id="memberGrid">
        <?php foreach ($all_members as $member):
            $type = ($member['member_type'] === 'Mentor') ? 'Mentor' : 'Leader';
            $photo = trim($member['photo'] ?? '');
            if ($photo !== '' && strpos($photo, 'data:') !== 0 && !preg_match('~^(https?:)?//~i', $photo)) {
                $photo = ltrim($photo, '/');
            }
            $tags = leader_mentor_expertise_list($member['expertise'] ?? '');
            $initials_id = 'memberInitials' . intval($member['id']);
        ?>
          <article class="member-card member-<?= strtolower($type); ?>" data-member-type="<?= $type; ?>">
            <?php if ($photo !== ''): ?>
              <img class="member-photo" src="<?= htmlspecialchars($photo); ?>" alt="<?= htmlspecialchars($member['name']); ?>" loading="lazy"
                   onerror="this.style.display='none'; var f=document.getElementById('<?= $initials_id; ?>'); if(f){f.style.display='flex';}">
              <div class="member-avatar" id="<?= $initials_id; ?>" style="display:none;"><?= htmlspecialchars(leader_mentor_initials($member['name'])); ?></div>
            <?php else: ?>
              <div class="member-avatar"><?= htmlspecialchars(leader_mentor_initials($member['name'])); ?></div>
            <?php endif; ?>

            <span class="member-type-badge"><?= $type; ?></span>
            <h3 class="member-name"><?= htmlspecialchars($member['name']); ?></h3>
            <p class="member-designation"><?= htmlspecialchars($member['designation']); ?></p>

            <?php if (!empty($member['experience_years'])): ?>
              <span class="member-experience">⭐ <?= htmlspecialchars($member['experience_years']); ?> of experience</span>
            <?php endif; ?>

            <?php if (!empty($member['bio'])): ?>
              <p class="member-bio"><?= nl2br(htmlspecialchars($member['bio'])); ?></p>
            <?php endif; ?>

            <?php if (!empty($tags)): ?>
              <div class="member-tags">
                <?php foreach ($tags as $tag): ?>
                  <span class="member-tag"><?= htmlspecialchars($tag); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($member['email']) || !empty($member['phone']) || !empty($member['linkedin_url']) || !empty($member['twitter_url'])): ?>
              <div class="member-contact">
                <?php if (!empty($member['email'])): ?>
                  <a href="mailto:<?= htmlspecialchars($member['email']); ?>" title="Email <?= htmlspecialchars($member['name']); ?>">✉️ Email</a>
                <?php endif; ?>
                <?php if (!empty($member['phone'])): ?>
                  <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $member['phone'])); ?>" title="Call <?= htmlspecialchars($member['name']); ?>">📞 Call</a>
                <?php endif; ?>
                <?php if (!empty($member['linkedin_url'])): ?>
                  <a href="<?= htmlspecialchars($member['linkedin_url']); ?>" target="_blank" rel="noopener" title="LinkedIn Profile">in LinkedIn</a>
                <?php endif; ?>
                <?php if (!empty($member['twitter_url'])): ?>
                  <a href="<?= htmlspecialchars($member['twitter_url']); ?>" target="_blank" rel="noopener" title="X / Twitter Profile">𝕏 Profile</a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="member-empty-state">
        <strong>Leadership &amp; mentor profiles are being updated.</strong><br>
        Add your first profile from the admin panel (<code>Leaders &amp; Mentors</code> module) &mdash; it will appear here instantly.
      </div>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 45px;">
      <a href="careers.php" class="btn btn-outline" style="margin-right: 10px;">Join</a>
      <a href="contact.php" class="btn btn-primary">Contact</a>
    </div>
  </div>
</section>

<script>
  function filterMembers(type, btn) {
    var tabs = document.querySelectorAll('#memberFilterTabs button');
    tabs.forEach(function (b) { b.className = 'btn btn-outline'; });
    if (btn) { btn.className = 'btn btn-primary'; }
    document.querySelectorAll('#memberGrid .member-card').forEach(function (card) {
      var isMatch = (type === 'All' || card.getAttribute('data-member-type') === type);
      card.classList.toggle('is-filtered-out', !isMatch);
    });
  }
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
