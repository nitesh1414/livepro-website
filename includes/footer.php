<?php
$settings = $settings ?? get_all_settings();
$company_name = $settings['company_name'] ?? 'LIVEpro Software Solutions';
$address = $settings['office_address'] ?? 'G-9B, Sidhhesh Sai Darshan Apartment, Raghuji Nagar, Nagpur, Maharashtra, India';
$phone = $settings['phone_numbers'] ?? '+91-712-274-0470, +91-940-448-4560, +91-956-107-9560';
$email = $settings['email_addresses'] ?? 'admin@liveprosolutions.com, niteshg@liveprosolutions.com';
$copyright_year = $settings['copyright_year'] ?? '2026';
?>
<!-- FOOTER (DEEP BLACK / NAVY BACKGROUND MATCHING LOGO.PNG) -->
<footer style="background: var(--dark-3); color: var(--text-on-dark-muted); padding: 65px 0 35px; border-top: 1px solid rgba(255,255,255,0.08); margin-top: 70px;">
  <div class="container">
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 40px; margin-bottom: 50px;">
      <div>
        <!-- BRAND WITH LOGO-LP.PNG AND MATCHING TYPOGRAPHY -->
        <div class="logo" style="margin-bottom: 18px; display: flex; align-items: center; gap: 12px; text-decoration: none;">
          <img src="assets/images/logo-LP.png" alt="LIVEpro Geometric Logo" style="height: 50px; width: auto; object-fit: contain;" onerror="this.onerror=null; this.src='/home/user/uploads/logo-LP.png';">
          <div style="display: flex; flex-direction: column; justify-content: center; line-height: 1;">
            <div>
              <span style="font-family: 'Arial Black', 'Impact', sans-serif; color: var(--primary); font-size: 1.5rem; font-weight: 900; letter-spacing: 0.5px;">LIVE</span><span style="font-family: 'Times New Roman', Georgia, serif; color: var(--danger); font-size: 1.5rem; font-weight: bold;">pro</span>
            </div>
            <span style="font-family: 'Monotype Corsiva', 'Apple Chancery', 'Lucida Calligraphy', cursive; color: var(--accent); font-size: 0.85rem; font-style: italic; display: block; margin-top: -3px;">Software Solutions</span>
          </div>
        </div>
        <p style="font-size: 0.9rem; line-height: 1.7; margin-bottom: 22px; color: var(--text-on-dark-muted);">We provide a wide range of corporate IT solutions across custom website development, mobile app development, bespoke software projects, cloud DevOps, systems integration, and 24/7 AMC maintenance support.</p>
        
      </div>

      <div>
        <h4 style="color: white; font-size: 1.05rem; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Quick Links</h4>
        <ul style="list-style: none; padding: 0; margin: 0; line-height: 2.2;">
          <li><a href="index.php" style="color: inherit; text-decoration: none;">Home</a></li>
          <li><a href="about.php" style="color: inherit; text-decoration: none;">About</a></li>
          <li><a href="expertise.php" style="color: inherit; text-decoration: none;">Expertise</a></li>
          <li><a href="projects.php" style="color: inherit; text-decoration: none;">Projects</a></li>
          <li><a href="careers.php" style="color: inherit; text-decoration: none;">Careers</a></li>
        </ul>
      </div>

      <div>
        <h4 style="color: white; font-size: 1.05rem; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Expertise</h4>
        <ul style="list-style: none; padding: 0; margin: 0; line-height: 2.2;">
          <li><a href="expertise.php" style="color: inherit; text-decoration: none;">Web</a></li>
          <li><a href="expertise.php" style="color: inherit; text-decoration: none;">Mobile</a></li>
          <li><a href="expertise.php" style="color: inherit; text-decoration: none;">Software</a></li>
          <li><a href="expertise.php" style="color: inherit; text-decoration: none;">Cloud</a></li>
          <li><a href="services.php" style="color: inherit; text-decoration: none;">AMC</a></li>
        </ul>
      </div>

      <div>
        <h4 style="color: white; font-size: 1.05rem; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Nagpur Office</h4>
        <p style="font-size: 0.9rem; margin-bottom: 12px; line-height: 1.6; color: var(--text-on-dark-muted);"><?= htmlspecialchars($address); ?></p>
        <p style="font-size: 0.85rem; margin-bottom: 8px; color: var(--text-on-dark-muted);"><strong>Phones:</strong><br><?= htmlspecialchars($phone); ?></p>
        <p style="font-size: 0.85rem; color: var(--text-on-dark-muted);"><strong>Email:</strong><br><?= htmlspecialchars($email); ?></p>
      </div>

      
    </div>

    <div style="padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.08); text-align: center; font-size: 0.85rem; color: var(--text-muted);">
      <p>&copy; <?= htmlspecialchars($copyright_year); ?> <?= htmlspecialchars($company_name); ?> | Harmonized LP Geometric Logo Theme. All Rights Reserved.</p>
    </div>
  </div>
</footer>

<!-- MODALS -->
<div class="modal-overlay" id="serviceDetailModal">
  <div class="modal-content">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
      <div>
        <span class="badge badge-primary" id="modalSrvCat">Corporate IT</span>
        <h3 id="modalSrvTitle" style="font-size: 1.5rem; font-weight: 800; margin-top: 6px; color: var(--text-main);">Service Title</h3>
      </div>
      <button onclick="closeModal('serviceDetailModal')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-muted);">&times;</button>
    </div>
    <p id="modalSrvShort" style="font-size: 1.1rem; font-weight: 600; color: var(--primary); margin-bottom: 15px;"></p>
    <p id="modalSrvFull" style="color: var(--text-main); line-height: 1.8; font-size: 1rem;"></p>
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 10px;">
      <button onclick="closeModal('serviceDetailModal')" class="btn btn-outline">Close</button>
      <a href="contact.php" class="btn btn-primary" style="text-decoration: none;">Inquire</a>
    </div>
  </div>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>