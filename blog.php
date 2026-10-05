<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * Tech Insights & Announcements (blog.php)
 */
require_once __DIR__ . '/includes/functions.php';

$current_page = 'blog';
$page_title = 'Tech Insights & Announcements';
require_once __DIR__ . '/includes/header.php';

$posts = get_blog_posts('published');
?>

<!-- PAGE HEADER -->
<section style="background: linear-gradient(135deg, #0f172a, #1e293b); color: white; padding: 70px 0; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <div class="container" style="max-width: 800px;">
    <span class="badge badge-primary" style="margin-bottom: 15px;">Latest Updates</span>
    <h1 style="font-size: 3rem; font-weight: 900; margin-bottom: 15px; color: white;">Tech Insights &amp; News</h1>
    <p style="font-size: 1.15rem; color: #94a3b8; line-height: 1.7;">
      Stay informed with our latest articles on software engineering trends, campus incubation stories, and enterprise case studies from our Nagpur team.
    </p>
  </div>
</section>

<!-- BLOG LISTING -->
<section style="background: #f8fafc; padding: 80px 0;">
  <div class="container">
    <div class="grid grid-3">
      <?php if (empty($posts)): ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: white; border-radius: 12px; color: #64748b;">
          No published articles found in the database.
        </div>
      <?php else: ?>
        <?php foreach ($posts as $pst): ?>
          <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; transition: 0.25s;">
            <div style="height: 6px; background: linear-gradient(to right, #2563eb, #059669);"></div>
            <div style="padding: 30px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
              <div>
                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.8rem; color: #64748b; margin-bottom: 12px;">
                  <span class="badge badge-primary"><?= htmlspecialchars($pst['category']); ?></span>
                  <span>📅 <?= htmlspecialchars($pst['publish_date']); ?></span>
                </div>
                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 12px; line-height: 1.4; color: #0f172a;">
                  <a href="post.php?id=<?= $pst['id']; ?>" style="color: inherit; text-decoration: none;">
                    <?= htmlspecialchars($pst['title']); ?>
                  </a>
                </h3>
                <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 20px; line-height: 1.6;"><?= htmlspecialchars($pst['excerpt']); ?></p>
              </div>

              <div style="padding-top: 15px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 0.85rem; font-weight: 600; color: #0f172a;">By <?= htmlspecialchars($pst['author']); ?></span>
                <a href="post.php?id=<?= $pst['id']; ?>" class="btn btn-outline btn-sm" style="text-decoration: none;">Read Full Article &rarr;</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
