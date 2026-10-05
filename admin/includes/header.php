<?php
require_once __DIR__ . '/../../includes/functions.php';
require_admin();
$admin_page = $admin_page ?? 'overview';
$settings = get_all_settings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CMS Admin - <?= htmlspecialchars(ucfirst($admin_page)); ?> | LIVEpro Portal</title>
  <!-- FAVICON MATCHING UPLOADED LOGO-LP.PNG -->
  <link rel="icon" type="image/png" href="../assets/images/logo-LP.png" onerror="this.href='/home/user/uploads/logo-LP.png';">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-body">

<?php display_flash_message(); ?>

<aside class="admin-sidebar">
  <div class="admin-sidebar-header">
    <div style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
      <img src="../assets/images/logo-LP.png" alt="LIVEpro Geometric Logo" style="height: 42px; width: auto; object-fit: contain;" onerror="this.onerror=null; this.src='/home/user/uploads/logo-LP.png';">
      <div style="display: flex; flex-direction: column; justify-content: center; line-height: 1;">
        <div>
          <span style="font-family: 'Arial Black', 'Impact', sans-serif; color: var(--primary); font-size: 1.3rem; font-weight: 900;">LIVE</span><span style="font-family: 'Times New Roman', Georgia, serif; color: var(--danger); font-size: 1.3rem; font-weight: bold;">pro</span>
        </div>
        <span style="font-family: 'Monotype Corsiva', 'Apple Chancery', 'Lucida Calligraphy', cursive; color: var(--accent); font-size: 0.75rem; font-style: italic; display: block; margin-top: -2px;">Software Solutions</span>
      </div>
    </div>
  </div>

  <ul class="admin-nav">
    <li><a href="index.php" class="<?= $admin_page === 'overview' ? 'active' : ''; ?>">📊 Dashboard Overview</a></li>
    <li><a href="settings.php" class="<?= $admin_page === 'settings' ? 'active' : ''; ?>">⚙️ Site Brand &amp; Top Ticker</a></li>
    <li><a href="banners.php" class="<?= $admin_page === 'banners' ? 'active' : ''; ?>">🎠 Hero Banners Carousel</a></li>
    <li><a href="panels.php" class="<?= $admin_page === 'panels' ? 'active' : ''; ?>">🧩 Feature &amp; Value Panels</a></li>
    <li><a href="casestudies.php" class="<?= $admin_page === 'casestudies' ? 'active' : ''; ?>">📈 Enterprise Case Studies</a></li>
    <li><a href="projects.php" class="<?= $admin_page === 'projects' ? 'active' : ''; ?>">🏛️ Projects &amp; Clients Portfolio</a></li>
    <li><a href="leaders.php" class="<?= $admin_page === 'leaders' ? 'active' : ''; ?>">👥 Leaders &amp; Mentors (About)</a></li>
    <li><a href="expertise.php" class="<?= $admin_page === 'expertise' ? 'active' : ''; ?>">🧠 Tech Expertise &amp; Stack</a></li>
    <li><a href="services.php" class="<?= $admin_page === 'services' ? 'active' : ''; ?>">🛠️ IT Capabilities &amp; Services</a></li>
    <li><a href="careers.php" class="<?= $admin_page === 'careers' ? 'active' : ''; ?>">💼 Careers &amp; Job Openings</a></li>
    <li><a href="applications.php" class="<?= $admin_page === 'applications' ? 'active' : ''; ?>">
      <span>📄 Job Applications</span>
      <?php 
        $unread_apps = count(get_job_applications('new')); 
        if ($unread_apps > 0) echo "<span class='badge' style='background:var(--danger); color:white; margin-left:auto; padding: 2px 8px; border-radius: 99px; font-size: 0.75rem;'>{$unread_apps}</span>";
      ?>
    </a></li>
    <li><a href="blog.php" class="<?= $admin_page === 'blog' ? 'active' : ''; ?>">📰 Thought Leadership Blog</a></li>
    <li><a href="testimonials.php" class="<?= $admin_page === 'testimonials' ? 'active' : ''; ?>">💬 Testimonials &amp; Reviews</a></li>
    <li><a href="inquiries.php" class="<?= $admin_page === 'inquiries' ? 'active' : ''; ?>">
      <span>📥 CRM Leads Engine</span>
      <?php 
        $unread_inq = count(get_inquiries('new')); 
        if ($unread_inq > 0) echo "<span class='badge' style='background:var(--danger); color:white; margin-left:auto; padding: 2px 8px; border-radius: 99px; font-size: 0.75rem;'>{$unread_inq}</span>";
      ?>
    </a></li>
  </ul>

  <div style="padding: 15px; border-top: 1px solid rgba(255,255,255,0.1); margin-top: auto;">
    <a href="../index.php" target="_blank" style="display: flex; align-items: center; justify-content: center; gap: 8px; background: rgba(255,255,255,0.1); color: white; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 0.85rem; transition: 0.2s;">
      🌐 View Live Portal
    </a>
  </div>
</aside>

<main class="admin-main">
  <header class="admin-topbar">
    <div>
      <h2 style="font-size: 1.4rem; font-weight: 900; margin: 0; color: var(--text-main);"><?= htmlspecialchars(ucfirst($admin_page)); ?> Control Panel</h2>
      <span style="font-size: 0.85rem; color: var(--text-muted);">Managing corporate IT consulting &amp; client projects for <?= htmlspecialchars($settings['company_name'] ?? 'LIVEpro'); ?></span>
    </div>

    <div style="display: flex; align-items: center; gap: 15px;">
      <div style="text-align: right; font-size: 0.85rem;">
        <strong style="display: block; color: var(--text-main);"><?= htmlspecialchars($_SESSION['admin_full_name'] ?? 'System Administrator'); ?></strong>
        <span style="color: var(--primary); font-weight: 800;"><?= htmlspecialchars(strtoupper($_SESSION['admin_role'] ?? 'SUPERADMIN')); ?></span>
      </div>
      <a href="logout.php" class="btn" style="background: var(--danger); color: white; text-decoration: none; padding: 8px 16px; font-size: 0.85rem; border-radius: 6px; font-weight: 700;">Logout</a>
    </div>
  </header>
  <div class="admin-content">
