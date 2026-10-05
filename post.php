<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * Single Article View (post.php)
 */
require_once __DIR__ . '/includes/functions.php';

$id = $_GET['id'] ?? null;
$post = $id ? get_post_by_id($id) : null;

if (!$post || $post['status'] !== 'published') {
    $current_page = 'blog';
    $page_title = 'Article Not Found';
    require_once __DIR__ . '/includes/header.php';
    echo "<div class='container' style='padding: 100px 20px; text-align: center;'>
        <h1 style='font-size: 2.5rem; margin-bottom: 15px;'>Article Not Found</h1>
        <p style='color: var(--text-muted); margin-bottom: 30px;'>The article you are looking for does not exist or has been archived.</p>
        <a href='blog.php' class='btn btn-primary' style='text-decoration:none;'>Back</a>
    </div>";
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// Increment view count
try {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?");
    $stmt->execute([$post['id']]);
} catch(Exception $e) {}

$current_page = 'blog';
$page_title = htmlspecialchars($post['title']);
require_once __DIR__ . '/includes/header.php';
?>

<!-- ARTICLE HEADER -->
<section style="background: linear-gradient(135deg, var(--text-main), var(--text-main)); color: white; padding: 80px 0 60px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <div class="container" style="max-width: 850px;">
    <div style="margin-bottom: 15px;">
      <span class="badge badge-primary"><?= htmlspecialchars($post['category']); ?></span>
    </div>
    <h1 style="font-size: 2.8rem; font-weight: 900; margin-bottom: 20px; color: white; line-height: 1.25;">
      <?= htmlspecialchars($post['title']); ?>
    </h1>
    <div style="display: flex; justify-content: center; gap: 20px; font-size: 0.95rem; color: var(--text-on-dark-muted);">
      <span>👤 Author: <strong style="color: white;"><?= htmlspecialchars($post['author']); ?></strong></span>
      <span>📅 Published: <strong style="color: white;"><?= htmlspecialchars($post['publish_date']); ?></strong></span>
      <span>👁️ Views: <strong style="color: white;"><?= intval($post['views'] ?? 1); ?></strong></span>
    </div>
  </div>
</section>

<!-- ARTICLE BODY -->
<section style="background: var(--bg-soft); padding: 60px 0;">
  <div class="container" style="max-width: 800px;">
    <div class="card" style="padding: 45px; font-size: 1.1rem; line-height: 1.9; color: var(--text-body); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
      
      <!-- EXCERPT LEAD -->
      <div style="font-size: 1.25rem; font-weight: 600; color: var(--text-main); border-left: 4px solid var(--primary); padding-left: 20px; margin-bottom: 35px; background: var(--bg-subtle); padding: 20px; border-radius: 0 8px 8px 0;">
        <?= htmlspecialchars($post['excerpt']); ?>
      </div>

      <!-- MAIN CONTENT -->
      <div class="article-content">
        <?= nl2br(htmlspecialchars($post['content'])); ?>
      </div>

      <!-- AUTHOR BIO FOOTER -->
      <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
        <div style="display: flex; align-items: center; gap: 15px;">
          <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.3rem;">
            <?= strtoupper(substr($post['author'], 0, 1)); ?>
          </div>
          <div>
            <h4 style="margin: 0; font-size: 1rem; font-weight: 700; color: var(--text-main);"><?= htmlspecialchars($post['author']); ?></h4>
            <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">LIVEpro Tech &amp; Engineering Division</p>
          </div>
        </div>
        <a href="blog.php" class="btn btn-outline" style="text-decoration: none;">Back</a>
      </div>

    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
