<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (Facebook Color Scheme)
 * Careers & Job Openings CRUD Manager (admin/careers.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM job_openings WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Job opening deleted successfully.", "success");
    header("Location: careers.php");
    exit;
}

// HANDLE SAVE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $department = trim($_POST['department'] ?? 'Software Engineering');
    $location = trim($_POST['location'] ?? 'Nagpur / Hybrid');
    $type = trim($_POST['type'] ?? 'Full-Time');
    $experience = trim($_POST['experience'] ?? '2-5 Years');
    $salary = trim($_POST['salary'] ?? 'Best in Industry');
    $description = trim($_POST['description'] ?? '');
    $requirements = trim($_POST['requirements'] ?? '');
    $status = $_POST['status'] ?? 'active';
    $display_order = intval($_POST['display_order'] ?? 10);

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE job_openings SET title = ?, department = ?, location = ?, type = ?, experience = ?, salary = ?, description = ?, requirements = ?, status = ?, display_order = ? WHERE id = ?");
        $stmt->execute([$title, $department, $location, $type, $experience, $salary, $description, $requirements, $status, $display_order, $id]);
        flash_message("🎉 Job Opening '{$title}' updated successfully!", "success");
    } else {
        $stmt = $pdo->prepare("INSERT INTO job_openings (title, department, location, type, experience, salary, description, requirements, status, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $department, $location, $type, $experience, $salary, $description, $requirements, $status, $display_order]);
        flash_message("🎉 New Job Opening '{$title}' created successfully!", "success");
    }
    header("Location: careers.php");
    exit;
}

$admin_page = 'careers';
require_once __DIR__ . '/includes/header.php';

// VIEW FORM: ADD OR EDIT
if ($action === 'new' || $action === 'edit'):
    $job = ['title' => '', 'department' => 'Software Engineering', 'location' => 'Nagpur / Hybrid', 'type' => 'Full-Time', 'experience' => '2-5 Years', 'salary' => '₹10L - ₹15L PA', 'description' => '', 'requirements' => '', 'status' => 'active', 'display_order' => 10];
    if ($action === 'edit' && $id > 0) {
        $job = get_job_by_id($id);
        if (!$job) {
            flash_message("Job opening not found.", "error");
            header("Location: careers.php");
            exit;
        }
    }
?>
    <div class="admin-card" style="max-width: 850px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #dddfe2; padding-bottom: 15px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: #050505;">
          <?= $action === 'edit' ? '✏️ Edit Job Opening' : '➕ Add New Job Opening'; ?>
        </h3>
        <a href="careers.php" class="btn" style="background: #f0f2f5; color: #65676b; text-decoration: none; font-size: 0.85rem;">&larr; Back to Openings</a>
      </div>

      <form method="POST" action="careers.php?<?= $action === 'edit' ? "action=edit&id={$id}" : "action=new"; ?>">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Job Title *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($job['title']); ?>" placeholder="e.g. Senior Java Full Stack Architect" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Department *</label>
            <input type="text" name="department" value="<?= htmlspecialchars($job['department']); ?>" placeholder="e.g. Software Engineering" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Location *</label>
            <input type="text" name="location" value="<?= htmlspecialchars($job['location']); ?>" placeholder="Nagpur / Hybrid" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Job Type *</label>
            <select name="type" style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; background: white;">
              <option value="Full-Time" <?= $job['type'] === 'Full-Time' ? 'selected' : ''; ?>>Full-Time</option>
              <option value="Part-Time" <?= $job['type'] === 'Part-Time' ? 'selected' : ''; ?>>Part-Time</option>
              <option value="Internship" <?= $job['type'] === 'Internship' ? 'selected' : ''; ?>>Internship</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Experience *</label>
            <input type="text" name="experience" value="<?= htmlspecialchars($job['experience']); ?>" placeholder="e.g. 2-5 Years" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Salary *</label>
            <input type="text" name="salary" value="<?= htmlspecialchars($job['salary']); ?>" placeholder="e.g. ₹12L - ₹18L PA" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; font-weight: 700; color: #42b72a;">
          </div>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Role Description &amp; Responsibilities *</label>
          <textarea name="description" rows="3" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;"><?= htmlspecialchars($job['description']); ?></textarea>
        </div>

        <div style="margin-bottom: 25px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Required Skills &amp; Qualifications (one requirement per line) *</label>
          <textarea name="requirements" rows="5" required style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; font-family: inherit;"><?= htmlspecialchars($job['requirements']); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Status</label>
            <select name="status" style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem; background: white;">
              <option value="active" <?= $job['status'] === 'active' ? 'selected' : ''; ?>>Active (Published)</option>
              <option value="closed" <?= $job['status'] === 'closed' ? 'selected' : ''; ?>>Closed (Archived)</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: #050505;">Display Order</label>
            <input type="number" name="display_order" value="<?= intval($job['display_order']); ?>" style="width: 100%; padding: 12px 14px; border: 1px solid #dddfe2; border-radius: 6px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
          <a href="careers.php" class="btn" style="background: #f0f2f5; color: #65676b; text-decoration: none;">Cancel</a>
          <button type="submit" class="btn" style="background: #1877f2; color: white; padding: 12px 30px; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">
            💾 Save Job Opening
          </button>
        </div>
      </form>
    </div>

<?php else: 
    // LIST VIEW
    $openings = get_job_openings('all');
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: #050505;">Careers &amp; Job Openings Database</h3>
          <p style="color: #65676b; font-size: 0.85rem; margin: 4px 0 0 0;">Total corporate &amp; incubator positions: <?= count($openings); ?></p>
        </div>
        <a href="careers.php?action=new" class="btn" style="background: #1877f2; color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: 700;">+ Add New Opening</a>
      </div>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Job Title</th>
              <th>Department</th>
              <th>Location &amp; Type</th>
              <th>Experience &amp; Salary</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($openings)): ?>
              <tr><td colspan="6" style="text-align: center; padding: 30px; color: #65676b;">No job openings found. Click Add New Opening above.</td></tr>
            <?php else: ?>
              <?php foreach ($openings as $job): ?>
                <tr>
                  <td><strong style="color: #050505; font-size: 1.05rem;"><?= htmlspecialchars($job['title']); ?></strong></td>
                  <td><span class="badge badge-primary"><?= htmlspecialchars($job['department']); ?></span></td>
                  <td><?= htmlspecialchars($job['location']); ?><br><small style="color:#65676b;"><?= htmlspecialchars($job['type']); ?></small></td>
                  <td><?= htmlspecialchars($job['experience']); ?><br><strong style="color:#42b72a;"><?= htmlspecialchars($job['salary']); ?></strong></td>
                  <td>
                    <span class="badge <?= $job['status'] === 'active' ? 'badge-accent' : 'badge-warning'; ?>">
                      <?= strtoupper(htmlspecialchars($job['status'])); ?>
                    </span>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="careers.php?action=edit&id=<?= $job['id']; ?>" class="btn" style="background: #e8f0fe; color: #1877f2; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Edit</a>
                      <a href="careers.php?action=delete&id=<?= $job['id']; ?>" onclick="return confirm('Delete this job opening permanently?')" class="btn" style="background: #ffebe9; color: #fa383e; padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
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
