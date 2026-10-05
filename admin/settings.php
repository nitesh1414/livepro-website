<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * CMS Site Settings & Branding Manager (admin/settings.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    save_setting('company_name', $_POST['company_name'] ?? '', 'branding');
    save_setting('tagline', $_POST['tagline'] ?? '', 'branding');
    save_setting('sub_tagline', $_POST['sub_tagline'] ?? '', 'branding');
    save_setting('office_address', $_POST['office_address'] ?? '', 'contact');
    save_setting('phone_numbers', $_POST['phone_numbers'] ?? '', 'contact');
    save_setting('email_addresses', $_POST['email_addresses'] ?? '', 'contact');
    save_setting('copyright_year', $_POST['copyright_year'] ?? '', 'general');
    save_setting('stat_years', $_POST['stat_years'] ?? '', 'stats');
    save_setting('stat_projects', $_POST['stat_projects'] ?? '', 'stats');
    save_setting('stat_engineers', $_POST['stat_engineers'] ?? '', 'stats');
    save_setting('stat_industries', $_POST['stat_industries'] ?? '', 'stats');
    save_setting('seo_meta_desc', $_POST['seo_meta_desc'] ?? '', 'seo');

    flash_message("🎉 Site settings updated and published to the live multipage portal!", "success");
    header("Location: settings.php");
    exit;
}

$admin_page = 'settings';
require_once __DIR__ . '/includes/header.php';
$settings = get_all_settings();
?>

<form method="POST" action="settings.php">
  <!-- BRANDING & IDENTITY -->
  <div class="admin-card">
    <h3 style="font-size: 1.3rem; font-weight: 700; margin-top: 0; margin-bottom: 20px; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
      1. Company Identity &amp; Header Branding
    </h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Company Name</label>
        <input type="text" name="company_name" value="<?= htmlspecialchars($settings['company_name'] ?? 'LIVEpro Software Solutions'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
      </div>
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Header Tagline (Top Pill)</label>
        <input type="text" name="tagline" value="<?= htmlspecialchars($settings['tagline'] ?? 'RIGHT TIME... RIGHT PLACE... RIGHT PEOPLE...'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
      </div>
    </div>
    <div>
      <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Sub-Tagline / About Overview Description</label>
      <textarea name="sub_tagline" rows="3" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;"><?= htmlspecialchars($settings['sub_tagline'] ?? ''); ?></textarea>
    </div>
  </div>

  <!-- CONTACT & NAGPUR HQ -->
  <div class="admin-card">
    <h3 style="font-size: 1.3rem; font-weight: 700; margin-top: 0; margin-bottom: 20px; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
      2. Contact Information &amp; Headquarters
    </h3>
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Office Address (Nagpur HQ)</label>
        <input type="text" name="office_address" value="<?= htmlspecialchars($settings['office_address'] ?? 'G-9B, Sidhhesh Sai Darshan Apartment, Raghuji Nagar, Nagpur, Maharashtra, India'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
      </div>
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Copyright Year</label>
        <input type="text" name="copyright_year" value="<?= htmlspecialchars($settings['copyright_year'] ?? '2026'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
      </div>
    </div>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Phone Numbers (Comma separated)</label>
        <input type="text" name="phone_numbers" value="<?= htmlspecialchars($settings['phone_numbers'] ?? '+91-712-274-0470, +91-940-448-4560, +91-956-107-9560'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
      </div>
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Email Addresses (Comma separated)</label>
        <input type="text" name="email_addresses" value="<?= htmlspecialchars($settings['email_addresses'] ?? 'admin@liveprosolutions.com, niteshg@liveprosolutions.com'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
      </div>
    </div>
  </div>

  <!-- HERO STATS COUNTERS -->
  <div class="admin-card">
    <h3 style="font-size: 1.3rem; font-weight: 700; margin-top: 0; margin-bottom: 20px; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
      3. Hero Stat Counters (Homepage Display)
    </h3>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Years of Excellence</label>
        <input type="text" name="stat_years" value="<?= htmlspecialchars($settings['stat_years'] ?? '15+'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 700; color: #2563eb;">
      </div>
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Enterprise Projects</label>
        <input type="text" name="stat_projects" value="<?= htmlspecialchars($settings['stat_projects'] ?? '500+'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 700; color: #2563eb;">
      </div>
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Engineers Trained</label>
        <input type="text" name="stat_engineers" value="<?= htmlspecialchars($settings['stat_engineers'] ?? '1,200+'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 700; color: #2563eb;">
      </div>
      <div>
        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: #334155;">Industry Verticals</label>
        <input type="text" name="stat_industries" value="<?= htmlspecialchars($settings['stat_industries'] ?? '16+'); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 700; color: #2563eb;">
      </div>
    </div>
  </div>

  <div style="text-align: right; margin-bottom: 40px;">
    <button type="submit" class="btn" style="background: #2563eb; color: white; padding: 15px 35px; font-size: 1.05rem; font-weight: 700; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(37,99,235,0.3);">
      💾 Save Settings &amp; Update Live Site
    </button>
  </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
