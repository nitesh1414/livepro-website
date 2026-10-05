<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * Contact Us & CRM Inquiry Submission (contact.php)
 */
require_once __DIR__ . '/includes/functions.php';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        if (save_inquiry($_POST)) {
            flash_message("🎉 Thank you, {$name}! Your inquiry has been saved into the CMS CRM database and our Nagpur team has been notified.", "success");
            header("Location: contact.php");
            exit;
        } else {
            flash_message("❌ Error saving inquiry. Please try again.", "error");
        }
    } else {
        flash_message("⚠️ Please fill in all required fields (Name, Email, Message).", "warning");
    }
}

$current_page = 'contact';
$page_title = 'Contact Support & Office Location';
require_once __DIR__ . '/includes/header.php';

$settings = get_all_settings();
$prefill_subject = $_GET['subject'] ?? '';
$prefill_course = $_GET['course'] ?? '';
$prefill_msg = '';
if (!empty($prefill_course)) {
    $prefill_msg = "Hello LIVEpro Team,\n\nI would like to apply for admission to the \"{$prefill_course}\" incubator program. Please guide me on batch starting dates and enrollment procedure.";
}
?>

<!-- PAGE HEADER -->
<section style="background: linear-gradient(135deg, var(--text-main), var(--text-main)); color: white; padding: 70px 0; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <div class="container" style="max-width: 800px;">
    <span class="badge badge-primary" style="margin-bottom: 15px;">Get In Touch</span>
    <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 15px; color: white;">Connect With LIVEpro</h1>
    <p style="font-size: 1.15rem; color: var(--text-on-dark-muted); line-height: 1.7;">
      Whether you have an enterprise project, AMC inquiry, or wish to enroll in our student incubator programs, our Nagpur office is ready to assist.
    </p>
  </div>
</section>

<!-- CONTACT GRID -->
<section style="background: var(--text-main); color: white; padding: 80px 0;">
  <div class="container">
    <div class="grid" style="grid-template-columns: 1fr 1.2fr; gap: 50px; align-items: start;">
      
      <!-- LEFT COLUMN: OFFICE INFO & MAPS -->
      <div style="background: var(--text-main); border: 1px solid var(--text-body); padding: 40px; border-radius: 16px;">
        <h2 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 25px; color: white; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">
          Nagpur Headquarters
        </h2>
        
        <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 25px;">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(55, 106, 155,0.15); color: var(--on-dark-accent); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">📍</div>
          <div>
            <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 4px; color: white;">Office Address</h4>
            <p style="color: var(--text-on-dark-muted); font-size: 0.95rem; line-height: 1.6; margin: 0;">
              <?= htmlspecialchars($settings['office_address'] ?? 'G-9B, Sidhhesh Sai Darshan Apartment, Raghuji Nagar, Nagpur, Maharashtra, India'); ?>
            </p>
          </div>
        </div>

        <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 25px;">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(55, 106, 155,0.15); color: var(--on-dark-accent); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">📞</div>
          <div>
            <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 4px; color: white;">Direct Phones</h4>
            <p style="color: var(--text-on-dark-muted); font-size: 0.95rem; line-height: 1.6; margin: 0;">
              <?= implode('<br>', array_map('trim', explode(',', $settings['phone_numbers'] ?? '+91-712-274-0470, +91-940-448-4560, +91-956-107-9560'))); ?>
            </p>
          </div>
        </div>

        <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 30px;">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(55, 106, 155,0.15); color: var(--on-dark-accent); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">✉️</div>
          <div>
            <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 4px; color: white;">Email Addresses</h4>
            <p style="color: var(--text-on-dark-muted); font-size: 0.95rem; line-height: 1.6; margin: 0;">
              <?= implode('<br>', array_map('trim', explode(',', $settings['email_addresses'] ?? 'admin@liveprosolutions.com, niteshg@liveprosolutions.com'))); ?>
            </p>
          </div>
        </div>

        <div style="padding-top: 25px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
          <span style="font-size: 0.85rem; color: var(--text-on-dark-muted);">🕒 Mon - Sat: 9:30 AM to 7:30 PM</span>
          <a href="<?= htmlspecialchars($settings['google_maps_url'] ?? 'https://maps.google.com/?q=Raghuji+Nagar+Nagpur'); ?>" target="_blank" class="btn btn-outline-light btn-sm" style="text-decoration: none;">Map</a>
        </div>
      </div>

      <!-- RIGHT COLUMN: INTERACTIVE PHP POST FORM -->
      <div style="background: white; color: var(--text-main); padding: 40px; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);">
        <h2 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 10px; color: var(--text-main);">Send Us an Inquiry</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 25px;">Fill out the form below and our team will get back to you within 24 business hours. Submissions are inserted directly into the MySQL CRM database.</p>

        <form method="POST" action="contact.php">
          <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Your Full Name *</label>
            <input type="text" name="name" placeholder="e.g. Rahul Sharma" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
          </div>

          <div class="grid grid-2" style="gap: 16px; margin-bottom: 20px;">
            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Email Address *</label>
              <input type="email" name="email" placeholder="rahul@example.com" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
            </div>
            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Mobile Number *</label>
              <input type="tel" name="phone" placeholder="+91 98765 43210" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
            </div>
          </div>

          <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Subject / Service Needed *</label>
            <select name="subject" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; background: white; box-sizing: border-box;">
              <option value="">-- Select an option --</option>
              <option value="Systems Development Inquiry" <?= $prefill_subject === 'Systems Development Inquiry' ? 'selected' : ''; ?>>Systems Development Inquiry</option>
              <option value="Hardware & Software Maintenance AMC" <?= $prefill_subject === 'Hardware & Software Maintenance AMC' ? 'selected' : ''; ?>>Hardware &amp; Software Maintenance AMC</option>
              <option value="Systems Integration & Re-Engineering" <?= $prefill_subject === 'Systems Integration & Re-Engineering' ? 'selected' : ''; ?>>Systems Integration &amp; Re-Engineering</option>
              <option value="Network Services & Infrastructure" <?= $prefill_subject === 'Network Services & Infrastructure' ? 'selected' : ''; ?>>Network Services &amp; Infrastructure</option>
              <option value="Incubator Course Admission" <?= $prefill_subject === 'Incubator Course Admission' || !empty($prefill_course) ? 'selected' : ''; ?>>Incubator Course Admission</option>
              <option value="Corporate Training Request" <?= $prefill_subject === 'Corporate Training Request' ? 'selected' : ''; ?>>Corporate Training Request</option>
              <option value="Other Business Consultation">Other Business Consultation</option>
            </select>
          </div>

          <div style="margin-bottom: 25px;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Your Message / Requirements *</label>
            <textarea name="message" rows="4" placeholder="Please describe your project requirements, course questions, or preferred batch timing..." required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;"><?= htmlspecialchars($prefill_msg); ?></textarea>
          </div>

          <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1rem; background: var(--primary); cursor: pointer; border: none; border-radius: 8px; color: white; font-weight: 700;">Send</button>
        </form>
      </div>

    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
