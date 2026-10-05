<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * Domain Expertise & Industries Page (industries.php)
 */
require_once __DIR__ . '/includes/functions.php';

$current_page = 'industries';
$page_title = 'Industries We Serve & Domain Expertise';
require_once __DIR__ . '/includes/header.php';

$industries = get_industries();
?>

<!-- PAGE HEADER -->
<section style="background: linear-gradient(135deg, #0f172a, #1e293b); color: white; padding: 70px 0; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <div class="container" style="max-width: 800px;">
    <span class="badge badge-primary" style="margin-bottom: 15px;">Domain Expertise</span>
    <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 15px; color: white;">Industries We Serve</h1>
    <p style="font-size: 1.15rem; color: #94a3b8; line-height: 1.7;">
      Our expert services span across diverse industries, bringing out the most innovative solutions in every business and technology domain across the globe.
    </p>
  </div>
</section>

<!-- INDUSTRIES GRID -->
<section style="background: #f8fafc; padding: 80px 0;">
  <div class="container">
    <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
      <?php if (empty($industries)): ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: white; border-radius: 12px; color: #64748b;">
          No industry domains found in database.
        </div>
      <?php else: ?>
        <?php foreach ($industries as $ind): ?>
          <div class="card" style="padding: 25px; transition: 0.2s; display: flex; align-items: flex-start; gap: 16px;">
            <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(37,99,235,0.1); color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 800; flex-shrink: 0;">
              ✔
            </div>
            <div>
              <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 6px;"><?= htmlspecialchars($ind['name']); ?></h3>
              <?php if (!empty($ind['description'])): ?>
                <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin: 0;"><?= htmlspecialchars($ind['description']); ?></p>
              <?php else: ?>
                <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin: 0;">Tailored enterprise software &amp; domain integration solutions.</p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- DOMAIN CONSULTATION -->
<section style="background: white; padding: 80px 0; text-align: center;">
  <div class="container" style="max-width: 700px;">
    <h2 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 15px; color: #0f172a;">Does Your Industry Require Specialized IT?</h2>
    <p style="color: #64748b; font-size: 1.1rem; margin-bottom: 30px;">We deliver end-to-end solutions that can build, manage and support our customers with high adaptability to unique industry compliance and technical requirements.</p>
    <a href="contact.php" class="btn btn-primary" style="text-decoration: none; padding: 14px 32px; font-size: 1rem;">Discuss Your Industry Requirements &rarr;</a>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
