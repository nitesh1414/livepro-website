<?php
require_once __DIR__ . '/functions.php';
$settings = get_all_settings();
$company_name = $settings['company_name'] ?? 'LIVEpro Software Solutions';
$tagline = $settings['tagline'] ?? 'RIGHT TIME... RIGHT PLACE... RIGHT PEOPLE...';
$phone = $settings['phone_numbers'] ?? '+91-712-274-0470';
$email = $settings['email_addresses'] ?? 'admin@liveprosolutions.com';
$current_page = $current_page ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title ?? $company_name); ?> | LP Geometric Logo Portal</title>
  <meta name="description" content="<?= htmlspecialchars($settings['seo_meta_desc'] ?? ''); ?>">
  <!-- FAVICON MATCHING UPLOADED LOGO-LP.PNG -->
  <link rel="icon" type="image/png" href="assets/images/logo-LP.png" onerror="this.href='/home/user/uploads/logo-LP.png';">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php display_flash_message(); ?>

<header>
  <!-- TOP CONTACT & SOCIAL MEDIA BAR -->
  <div class="top-bar">
    <div class="container top-bar-container">
      <div class="top-bar-contact">
        <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $phone)); ?>" title="Call LIVEpro HQ"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#38bdf8;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> <?= htmlspecialchars($phone); ?></a>
        <span class="top-bar-divider">|</span>
        <a href="mailto:<?= htmlspecialchars($email); ?>" title="Email LIVEpro"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#f2c10d;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> <?= htmlspecialchars($email); ?></a>
        <span class="top-bar-divider">|</span>
        <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#c92020;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> <?= htmlspecialchars($settings['address'] ?? 'Nagpur, Maharashtra, India'); ?></span>
      </div>
      <div class="top-bar-social">
        <a href="<?= htmlspecialchars($settings['linkedin_url'] ?? 'https://www.linkedin.com/company/livepro-solutions'); ?>" target="_blank" aria-label="LinkedIn" title="LinkedIn" class="social-icon-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg></a>
        <a href="<?= htmlspecialchars($settings['twitter_url'] ?? 'https://twitter.com/liveprosolutions'); ?>" target="_blank" aria-label="Twitter / X" title="Twitter / X" class="social-icon-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
        <a href="<?= htmlspecialchars($settings['facebook_url'] ?? 'https://www.facebook.com/liveprosolutions'); ?>" target="_blank" aria-label="Facebook" title="Facebook" class="social-icon-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
        <a href="<?= htmlspecialchars($settings['instagram_url'] ?? 'https://www.instagram.com/liveprosolutions'); ?>" target="_blank" aria-label="Instagram" title="Instagram" class="social-icon-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
        <a href="https://wa.me/<?= htmlspecialchars(preg_replace('/[^0-9]/', '', $phone)); ?>" target="_blank" aria-label="WhatsApp" title="WhatsApp 24/7 Support" class="social-icon-btn whatsapp"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></a>
      </div>
    </div>
  </div>
  <div class="container nav-container">
    <a href="index.php" class="logo">
      <!-- UPLOADED LOGO-LP.PNG AS ICON -->
      <img src="assets/images/logo-LP.png" alt="LIVEpro Geometric Logo" class="logo-img" onerror="this.onerror=null; this.src='/home/user/uploads/logo-LP.png';">
      <!-- COMPANY NAME IN MATCHING FONTS FROM LOGO.PNG -->
      <div class="logo-text-wrapper">
        <div class="logo-main-text">
          <span class="logo-live">LIVE</span><span class="logo-pro">pro</span>
        </div>
        <span class="logo-software-solutions">Software Solutions</span>
        <span class="logo-tag">Right People, Right Time, Right Place</span>
      </div>
    </a>

    <ul class="nav-links" id="navLinks">
      <li><a href="index.php" class="<?= $current_page === 'home' ? 'active' : ''; ?>">Home</a></li>
      <li><a href="about.php" class="<?= $current_page === 'about' ? 'active' : ''; ?>">About Us</a></li>
      <li><a href="expertise.php" class="<?= $current_page === 'expertise' ? 'active' : ''; ?>">Our Expertise</a></li>
      <li><a href="services.php" class="<?= $current_page === 'services' ? 'active' : ''; ?>">IT Services</a></li>
      <li><a href="projects.php" class="<?= $current_page === 'projects' ? 'active' : ''; ?>">Clients &amp; Projects</a></li>
      <li><a href="industries.php" class="<?= $current_page === 'industries' ? 'active' : ''; ?>">Industries</a></li>
      <li><a href="careers.php" class="<?= $current_page === 'careers' ? 'active' : ''; ?>">Careers</a></li>
      <li><a href="blog.php" class="<?= $current_page === 'blog' ? 'active' : ''; ?>">Insights</a></li>
      <li><a href="contact.php" class="<?= $current_page === 'contact' ? 'active' : ''; ?>">Contact</a></li>
    </ul>

    <div style="display: flex; align-items: center; gap: 12px;">
      
      <button id="mobileHamburger" class="hamburger" aria-label="Toggle Navigation Menu">☰</button>
    </div>
  </div>
</header>
