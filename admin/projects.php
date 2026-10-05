<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (Facebook Color Scheme)
 * Enterprise Projects & Clients Portfolio CRUD Manager (admin/projects.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM projects_portfolio WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Project showcase deleted successfully.", "success");
    header("Location: projects.php");
    exit;
}

// HANDLE SAVE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $client_name = trim($_POST['client_name'] ?? 'Enterprise Client');
    $category = trim($_POST['category'] ?? 'Enterprise IT');
    $industry = trim($_POST['industry'] ?? 'Banking & Finance');
    $tech_stack = trim($_POST['tech_stack'] ?? 'Java, Spring Boot, React, AWS');
    $challenge = trim($_POST['challenge'] ?? '');
    $solution = trim($_POST['solution'] ?? '');
    $results = trim($_POST['results'] ?? '');
    $featured = isset($_POST['featured']) ? 1 : 0;
    $status = $_POST['status'] ?? 'active';
    $display_order = intval($_POST['display_order'] ?? 10);

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE projects_portfolio SET title = ?, client_name = ?, category = ?, industry = ?, tech_stack = ?, challenge = ?, solution = ?, results = ?, featured = ?, status = ?, display_order = ? WHERE id = ?");
        $stmt->execute([$title, $client_name, $category, $industry, $tech_stack, $challenge, $solution, $results, $featured, $status, $display_order, $id]);
        flash_message("🎉 Project Showcase '{$title}' updated successfully!", "success");
    } else {
        $stmt = $pdo->prepare("INSERT INTO projects_portfolio (title, client_name, category, industry, tech_stack, challenge, solution, results, featured, status, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $client_name, $category, $industry, $tech_stack, $challenge, $solution, $results, $featured, $status, $display_order]);
        flash_message("🎉 New Project Showcase '{$title}' created successfully!", "success");
    }
    header("Location: projects.php");
    exit;
}

$admin_page = 'projects';
require_once __DIR__ . '/includes/header.php';

// VIEW FORM: ADD OR EDIT
if ($action === 'new' || $action === 'edit'):
    $prj = ['title' => '', 'client_name' => 'Vidarbha Financial Services', 'category' => 'Enterprise IT', 'industry' => 'Banking & Finance', 'tech_stack' => 'Spring Boot, Microservices, React, Docker, AWS', 'challenge' => '', 'solution' => '', 'results' => '', 'featured' => 1, 'status' => 'active', 'display_order' => 10];
    if ($action === 'edit' && $id > 0) {
        $prj = get_project_by_id($id);
        if (!$prj) {
            flash_message("Project not found.", "error");
            header("Location: projects.php");
            exit;
        }
    }
?>
    <div class="admin-card" style="max-width: 850px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #dddfe2; padding-bottom: 15px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: #050505;">
          <?= $action === 'edit' ? '✏️ Edit Project Showcase' : '➕ Add Client Project Showcase'; ?>
        </h3>
        <a href="projects.php" class="btn" style="background: #f0f2f5; color: #65676b; text-decoration: none; font-size: 0.85rem;">&larr; Back to Portfolio</a>
      </div>

      <form method="POST" action="projects.php?<?= $action === 'edit' ? "action=edit&id={$id}" : "action=new"; ?>">
        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Project Headline Title *</label>
          <input type="text" name="title" value="<?= htmlspecialchars($prj['title']); ?>" placeholder="e.g. Vidarbha Financial Core Banking API Re-Engineering" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; font-weight: 700;">
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Client Name *</label>
            <input type="text" name="client_name" value="<?= htmlspecialchars($prj['client_name']); ?>" placeholder="e.g. Vidarbha Financial Services" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Category Tab *</label>
            <select name="category" style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; background: white;">
              <option value="Enterprise IT" <?= $prj['category'] === 'Enterprise IT' ? 'selected' : ''; ?>>Enterprise IT</option>
              <option value="Industrial IoT" <?= $prj['category'] === 'Industrial IoT' ? 'selected' : ''; ?>>Industrial IoT</option>
              <option value="Cloud & AMC" <?= $prj['category'] === 'Cloud & AMC' ? 'selected' : ''; ?>>Cloud &amp; AMC</option>
              <option value="Campus Incubator" <?= $prj['category'] === 'Campus Incubator' ? 'selected' : ''; ?>>Campus Incubator</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Industry Domain *</label>
            <input type="text" name="industry" value="<?= htmlspecialchars($prj['industry']); ?>" placeholder="e.g. Banking & Finance" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Tech Stack Tags (Comma separated) *</label>
          <input type="text" name="tech_stack" value="<?= htmlspecialchars($prj['tech_stack']); ?>" placeholder="e.g. Spring Boot, Microservices, PostgreSQL, Docker, AWS" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; font-family: monospace;">
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">The Challenge / Client Problem *</label>
          <textarea name="challenge" rows="3" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;"><?= htmlspecialchars($prj['challenge']); ?></textarea>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Our Engineering Solution *</label>
          <textarea name="solution" rows="4" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;"><?= htmlspecialchars($prj['solution']); ?></textarea>
        </div>

        <div style="margin-bottom: 25px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Measurable Enterprise Impact / Results *</label>
          <textarea name="results" rows="3" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; font-weight: 700; color: #42b72a;"><?= htmlspecialchars($prj['results']); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; align-items: center;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Status</label>
            <select name="status" style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; background: white;">
              <option value="active" <?= $prj['status'] === 'active' ? 'selected' : ''; ?>>Active (Published)</option>
              <option value="draft" <?= $prj['status'] === 'draft' ? 'selected' : ''; ?>>Draft (Hidden)</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Display Order</label>
            <input type="number" name="display_order" value="<?= intval($prj['display_order']); ?>" style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div style="padding-top: 15px;">
            <label style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #050505; cursor: pointer;">
              <input type="checkbox" name="featured" value="1" <?= $prj['featured'] == 1 ? 'checked' : ''; ?> style="width: 18px; height: 18px;">
              Featured Showcase Project
            </label>
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
          <a href="projects.php" class="btn" style="background: #f0f2f5; color: #65676b; text-decoration: none;">Cancel</a>
          <button type="submit" class="btn" style="background: #1877f2; color: white; padding: 12px 30px; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">
            💾 Save Project Showcase
          </button>
        </div>
      </form>
    </div>

<?php else: 
    // LIST VIEW
    $projects = get_projects('all');
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: #050505;">Enterprise Clients &amp; Projects Database</h3>
          <p style="color: #65676b; font-size: 0.85rem; margin: 4px 0 0 0;">Total client deliverables: <?= count($projects); ?></p>
        </div>
        <a href="projects.php?action=new" class="btn" style="background: #1877f2; color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: 700;">+ Add New Project</a>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Project Title &amp; Client</th>
              <th>Category</th>
              <th>Tech Stack</th>
              <th>Measurable Impact</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($projects)): ?>
              <tr><td colspan="7" style="text-align: center; padding: 30px; color: #65676b;">No project showcases found. Click Add New Project above.</td></tr>
            <?php else: ?>
              <?php foreach ($projects as $prj): ?>
                <tr>
                  <td style="color: #65676b; font-weight: 700;">#<?= intval($prj['display_order']); ?></td>
                  <td>
                    <strong style="color: #050505; font-size: 1.05rem;"><?= htmlspecialchars($prj['title']); ?></strong><br>
                    <span style="font-size: 0.85rem; color: #1877f2; font-weight: 700;"><?= htmlspecialchars($prj['client_name']); ?></span>
                  </td>
                  <td><span class="badge badge-primary"><?= htmlspecialchars($prj['category']); ?></span></td>
                  <td style="max-width: 200px; font-size: 0.8rem; color: #65676b; font-family: monospace;"><?= htmlspecialchars($prj['tech_stack']); ?></td>
                  <td style="max-width: 220px; font-size: 0.85rem; font-weight: 700; color: #42b72a;"><?= htmlspecialchars($prj['results']); ?></td>
                  <td>
                    <span class="badge <?= $prj['status'] === 'active' ? 'badge-accent' : 'badge-warning'; ?>">
                      <?= strtoupper(htmlspecialchars($prj['status'])); ?>
                    </span>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="projects.php?action=edit&id=<?= $prj['id']; ?>" class="btn" style="background: #e8f0fe; color: #1877f2; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Edit</a>
                      <a href="projects.php?action=delete&id=<?= $prj['id']; ?>" onclick="return confirm('Delete this project permanently?')" class="btn" style="background: #ffebe9; color: #fa383e; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
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
