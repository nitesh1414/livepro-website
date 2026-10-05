<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * Blog & Tech Insights CRUD Manager (admin/blog.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Blog article deleted successfully.", "success");
    header("Location: blog.php");
    exit;
}

// HANDLE SAVE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
    $category = trim($_POST['category'] ?? 'IT Solutions');
    $author = trim($_POST['author'] ?? 'Nitesh G.');
    $publish_date = $_POST['publish_date'] ?? date('Y-m-d');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status = $_POST['status'] ?? 'published';

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, slug = ?, category = ?, author = ?, publish_date = ?, excerpt = ?, content = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $slug, $category, $author, $publish_date, $excerpt, $content, $status, $id]);
        flash_message("🎉 Tech article '{$title}' updated successfully!", "success");
    } else {
        $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, category, author, publish_date, excerpt, content, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $category, $author, $publish_date, $excerpt, $content, $status]);
        flash_message("🎉 New Tech article '{$title}' published successfully!", "success");
    }
    header("Location: blog.php");
    exit;
}

$admin_page = 'blog';
require_once __DIR__ . '/includes/header.php';

// VIEW FORM: ADD OR EDIT
if ($action === 'new' || $action === 'edit'):
    $post = ['title' => '', 'category' => 'Training & Campus', 'author' => 'Nitesh G.', 'publish_date' => date('Y-m-d'), 'excerpt' => '', 'content' => '', 'status' => 'published'];
    if ($action === 'edit' && $id > 0) {
        $post = get_post_by_id($id);
        if (!$post) {
            flash_message("Article not found.", "error");
            header("Location: blog.php");
            exit;
        }
    }
?>
    <div class="admin-card" style="max-width: 850px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: var(--text-main);">
          <?= $action === 'edit' ? '✏️ Edit Tech Article' : '➕ Publish New Tech Article'; ?>
        </h3>
        <a href="blog.php" class="btn" style="background: var(--bg-subtle); color: var(--text-body); text-decoration: none; font-size: 0.85rem;">Back</a>
      </div>

      <form method="POST" action="blog.php?<?= $action === 'edit' ? "action=edit&id={$id}" : "action=new"; ?>">
        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Article Headline *</label>
          <input type="text" name="title" value="<?= htmlspecialchars($post['title']); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;">
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Category *</label>
            <input type="text" name="category" value="<?= htmlspecialchars($post['category']); ?>" placeholder="e.g. Training & Campus" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Author Name *</label>
            <input type="text" name="author" value="<?= htmlspecialchars($post['author']); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Publish Date *</label>
            <input type="date" name="publish_date" value="<?= htmlspecialchars($post['publish_date']); ?>" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Short Excerpt Summary *</label>
          <textarea name="excerpt" rows="2" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem;"><?= htmlspecialchars($post['excerpt']); ?></textarea>
        </div>

        <div style="margin-bottom: 25px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Full Comprehensive Content *</label>
          <textarea name="content" rows="8" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; font-family: inherit;"><?= htmlspecialchars($post['content']); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 30px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text-body);">Publishing Status</label>
            <select name="status" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-strong); border-radius: 8px; font-size: 0.95rem; background: white;">
              <option value="published" <?= $post['status'] === 'published' ? 'selected' : ''; ?>>Published (Live)</option>
              <option value="draft" <?= $post['status'] === 'draft' ? 'selected' : ''; ?>>Draft (Hidden)</option>
            </select>
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
          <a href="blog.php" class="btn" style="background: var(--bg-subtle); color: var(--text-body); text-decoration: none;">Cancel</a>
          <button type="submit" class="btn" style="background: var(--primary); color: white; padding: 12px 30px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">Create</button>
        </div>
      </form>
    </div>

<?php else: 
    // LIST VIEW
    $posts = get_blog_posts('all');
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: var(--text-main);">Tech Insights &amp; Articles Database</h3>
          <p style="color: var(--text-muted); font-size: 0.85rem; margin: 4px 0 0 0;">Total articles published: <?= count($posts); ?></p>
        </div>
        <a href="blog.php?action=new" class="btn" style="background: var(--primary); color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: 700;">Create</a>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Article Headline</th>
              <th>Category</th>
              <th>Author</th>
              <th>Views</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($posts)): ?>
              <tr><td colspan="7" style="text-align: center; padding: 30px; color: var(--text-muted);">No blog articles found. Click Publish New Article above.</td></tr>
            <?php else: ?>
              <?php foreach ($posts as $pst): ?>
                <tr>
                  <td style="color: var(--text-muted); font-size: 0.85rem;"><?= htmlspecialchars($pst['publish_date']); ?></td>
                  <td>
                    <strong style="color: var(--text-main); font-size: 1.05rem;"><?= htmlspecialchars($pst['title']); ?></strong>
                  </td>
                  <td><span class="badge badge-primary"><?= htmlspecialchars($pst['category']); ?></span></td>
                  <td style="color: var(--text-body); font-weight: 600;"><?= htmlspecialchars($pst['author']); ?></td>
                  <td style="color: var(--text-muted);">👁️ <?= intval($pst['views'] ?? 0); ?></td>
                  <td>
                    <span class="badge <?= $pst['status'] === 'published' ? 'badge-accent' : 'badge-warning'; ?>">
                      <?= strtoupper(htmlspecialchars($pst['status'])); ?>
                    </span>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="blog.php?action=edit&id=<?= $pst['id']; ?>" class="btn" style="background: var(--primary-soft); color: var(--primary); padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Edit</a>
                      <a href="blog.php?action=delete&id=<?= $pst['id']; ?>" onclick="return confirm('Delete this article permanently?')" class="btn" style="background: var(--danger-soft); color: var(--danger); padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
