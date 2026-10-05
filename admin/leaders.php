<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (Facebook Color Scheme)
 * Leaders & Mentors CRUD Manager (admin/leaders.php)
 * Feeds the "Leadership & Mentorship" section of the public About Us page (about.php)
 */
require_once __DIR__ . '/../includes/functions.php';
require_admin();

ensure_leaders_mentors_table();

$pdo = get_db_connection();
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);

// HANDLE STATUS TOGGLE
if ($action === 'toggle' && $id > 0) {
    $member = get_leader_mentor_by_id($id);
    if ($member) {
        $new_status = ($member['status'] === 'active') ? 'draft' : 'active';
        $stmt = $pdo->prepare("UPDATE leaders_mentors SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
        flash_message("👤 '{$member['name']}' profile is now " . strtoupper($new_status) . ".", "success");
    }
    header("Location: leaders.php");
    exit;
}

// HANDLE DELETE
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM leaders_mentors WHERE id = ?");
    $stmt->execute([$id]);
    flash_message("🗑️ Leader / Mentor profile deleted successfully.", "success");
    header("Location: leaders.php");
    exit;
}

// HANDLE SAVE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $member_type = in_array($_POST['member_type'] ?? '', get_leader_mentor_types(), true) ? $_POST['member_type'] : 'Leader';
    $bio = trim($_POST['bio'] ?? '');
    $expertise = trim($_POST['expertise'] ?? '');
    $experience_years = trim($_POST['experience_years'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $linkedin_url = trim($_POST['linkedin_url'] ?? '');
    $twitter_url = trim($_POST['twitter_url'] ?? '');
    $photo = trim($_POST['photo'] ?? '');
    $status = ($_POST['status'] ?? 'active') === 'draft' ? 'draft' : 'active';
    $display_order = intval($_POST['display_order'] ?? 10);

    if ($name === '' || $designation === '') {
        flash_message("⚠️ Full name and designation are required fields.", "error");
        header("Location: leaders.php?" . ($id > 0 ? "action=edit&id={$id}" : "action=new"));
        exit;
    }

    // Handle profile photo file upload if provided
    if (isset($_FILES['photo_file']) && $_FILES['photo_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../assets/images/leaders/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_ext = strtolower(pathinfo($_FILES['photo_file']['name'], PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($file_ext, $allowed_exts, true)) {
            $new_filename = 'leader-' . time() . '-' . rand(100, 999) . '.' . $file_ext;
            if (move_uploaded_file($_FILES['photo_file']['tmp_name'], $upload_dir . $new_filename)) {
                $photo = 'assets/images/leaders/' . $new_filename;
            }
        } else {
            flash_message("⚠️ Photo upload failed: only JPG, PNG, WEBP and GIF images are supported.", "error");
        }
    }

    if (!empty($_POST['photo_clear'])) {
        $photo = '';
    }

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE leaders_mentors SET name = ?, designation = ?, member_type = ?, bio = ?, photo = ?, expertise = ?, experience_years = ?, email = ?, phone = ?, linkedin_url = ?, twitter_url = ?, status = ?, display_order = ? WHERE id = ?");
        $stmt->execute([$name, $designation, $member_type, $bio, $photo, $expertise, $experience_years, $email, $phone, $linkedin_url, $twitter_url, $status, $display_order, $id]);
        flash_message("🎉 {$member_type} '{$name}' updated successfully!", "success");
    } else {
        $stmt = $pdo->prepare("INSERT INTO leaders_mentors (name, designation, member_type, bio, photo, expertise, experience_years, email, phone, linkedin_url, twitter_url, status, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $designation, $member_type, $bio, $photo, $expertise, $experience_years, $email, $phone, $linkedin_url, $twitter_url, $status, $display_order]);
        flash_message("🎉 New {$member_type} '{$name}' added successfully and is now live on the About Us page!", "success");
    }
    header("Location: leaders.php");
    exit;
}

$admin_page = 'leaders';
require_once __DIR__ . '/includes/header.php';

// VIEW FORM: ADD OR EDIT
if ($action === 'new' || $action === 'edit'):
    $member = [
        'name' => '',
        'designation' => '',
        'member_type' => ($_GET['type'] ?? 'Leader') === 'Mentor' ? 'Mentor' : 'Leader',
        'bio' => '',
        'photo' => '',
        'expertise' => '',
        'experience_years' => '',
        'email' => '',
        'phone' => '',
        'linkedin_url' => '',
        'twitter_url' => '',
        'status' => 'active',
        'display_order' => 10
    ];
    if ($action === 'edit' && $id > 0) {
        $found = get_leader_mentor_by_id($id);
        if (!$found) {
            flash_message("Leader / Mentor profile not found.", "error");
            header("Location: leaders.php");
            exit;
        }
        $member = array_merge($member, $found);
    }
    $photo_src = $member['photo'] ?? '';
    if ($photo_src !== '' && strpos($photo_src, 'http') !== 0) {
        $photo_src = '../' . ltrim($photo_src, '/');
    }
?>
    <div class="admin-card" style="max-width: 880px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
        <h3 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: var(--text-main);">
          <?= $action === 'edit' ? '✏️ Edit Leader / Mentor Profile' : '➕ Add Leader / Mentor Profile'; ?>
        </h3>
        <a href="leaders.php" class="btn" style="background: var(--bg-subtle); color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">Back</a>
      </div>

      <form method="POST" action="leaders.php?<?= $action === 'edit' ? "action=edit&id={$id}" : "action=new"; ?>" enctype="multipart/form-data">
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Full Name *</label>
            <input type="text" name="name" value="<?= htmlspecialchars($member['name']); ?>" placeholder="e.g. Priya Deshmukh" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; font-weight: 700;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Profile Type *</label>
            <select name="member_type" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: white;">
              <option value="Leader" <?= $member['member_type'] === 'Leader' ? 'selected' : ''; ?>>👔 Leader</option>
              <option value="Mentor" <?= $member['member_type'] === 'Mentor' ? 'selected' : ''; ?>>🎓 Mentor</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Display Order</label>
            <input type="number" name="display_order" value="<?= intval($member['display_order']); ?>" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Designation / Title *</label>
            <input type="text" name="designation" value="<?= htmlspecialchars($member['designation']); ?>" placeholder="e.g. Chief Technology Officer" required style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Experience (shown as badge)</label>
            <input type="text" name="experience_years" value="<?= htmlspecialchars($member['experience_years']); ?>" placeholder="e.g. 15+ Years" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Short Biography *</label>
          <textarea name="bio" rows="4" required placeholder="Explain this person's role, focus areas and contribution to LIVEpro..." style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem;"><?= htmlspecialchars($member['bio']); ?></textarea>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Expertise / Specialities (Comma separated)</label>
          <input type="text" name="expertise" value="<?= htmlspecialchars($member['expertise']); ?>" placeholder="e.g. Java Spring Boot, Microservices, Cloud Architecture" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; font-family: monospace;">
        </div>

        <!-- PROFILE PHOTO CONFIGURATION -->
        <div style="background: var(--bg-subtle); border: 1px solid var(--border-color); padding: 20px; border-radius: 8px; margin-bottom: 25px;">
          <h4 style="font-size: 1.05rem; font-weight: 800; color: var(--primary); margin: 0 0 10px 0;">🖼️ Profile Photo Settings</h4>
          <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 15px;">Upload a square headshot (recommended 400x400px) OR paste a relative/external image URL. Leave both empty to display an automatic initials avatar.</p>

          <div style="display: grid; grid-template-columns: 120px 1fr 1fr; gap: 20px; align-items: center;">
            <div style="text-align: center;">
              <?php if (!empty($photo_src)): ?>
                <img src="<?= htmlspecialchars($photo_src); ?>" alt="Current profile photo" style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary);">
              <?php else: ?>
                <div class="admin-member-initials <?= $member['member_type'] === 'Mentor' ? 'mentor' : ''; ?>" style="width: 90px; height: 90px; margin: 0 auto; font-size: 1.5rem;"><?= htmlspecialchars(leader_mentor_initials($member['name'])); ?></div>
              <?php endif; ?>
              <p style="font-size: 0.72rem; color: var(--text-muted); margin: 8px 0 0 0;">Current avatar</p>
            </div>
            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Upload New Photo File</label>
              <input type="file" name="photo_file" accept="image/*" style="background: white; padding: 10px; border: 1px dashed var(--border-strong); border-radius: 6px; width: 100%;">
            </div>
            <div>
              <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Photo Path / URL</label>
              <input type="text" name="photo" value="<?= htmlspecialchars($member['photo'] ?? ''); ?>" placeholder="assets/images/leaders/photo.jpg" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.9rem; background: white;">
              <label style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: var(--text-muted); margin-top: 8px;">
                <input type="checkbox" name="photo_clear" value="1"> Remove the current photo
              </label>
            </div>
          </div>
        </div>

        <!-- CONTACT & SOCIAL -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Email Address</label>
            <input type="email" name="email" value="<?= htmlspecialchars($member['email']); ?>" placeholder="name@liveprosolutions.com" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Phone Number</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($member['phone']); ?>" placeholder="+91-712-274-0470" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">LinkedIn URL</label>
            <input type="text" name="linkedin_url" value="<?= htmlspecialchars($member['linkedin_url']); ?>" placeholder="https://www.linkedin.com/in/username" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem;">
          </div>
          <div>
            <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">X / Twitter URL</label>
            <input type="text" name="twitter_url" value="<?= htmlspecialchars($member['twitter_url']); ?>" placeholder="https://twitter.com/username" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem;">
          </div>
        </div>

        <div style="margin-bottom: 30px;">
          <label style="display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Status</label>
          <select name="status" style="width: 100%; padding: 12px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.95rem; background: white;">
            <option value="active" <?= $member['status'] === 'active' ? 'selected' : ''; ?>>Active (Published on About Us page)</option>
            <option value="draft" <?= $member['status'] === 'draft' ? 'selected' : ''; ?>>Draft (Hidden from website)</option>
          </select>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 15px;">
          <a href="leaders.php" class="btn" style="background: var(--bg-subtle); color: var(--text-muted); text-decoration: none;">Cancel</a>
          <button type="submit" class="btn" style="background: var(--primary); color: white; padding: 12px 30px; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">Save</button>
        </div>
      </form>
    </div>

<?php else:
    // LIST VIEW
    $type_filter = $_GET['type'] ?? 'all';
    $members = get_leaders_mentors('all', $type_filter);
    $count_leaders = count(get_leaders_mentors('all', 'Leader'));
    $count_mentors = count(get_leaders_mentors('all', 'Mentor'));
?>
    <div class="admin-card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <div>
          <h3 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: var(--text-main);">Leaders &amp; Mentors Database</h3>
          <p style="color: var(--text-muted); font-size: 0.85rem; margin: 4px 0 0 0;">
            <?= count($members); ?> profile(s) listed • <?= $count_leaders; ?> Leader(s) • <?= $count_mentors; ?> Mentor(s) — published automatically on <strong>about.php</strong>
          </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
          <a href="leaders.php?type=all" class="btn" style="text-decoration: none; padding: 8px 16px; font-size: 0.85rem; <?= $type_filter === 'all' ? 'background: var(--primary); color: white;' : 'background: var(--bg-subtle); color: var(--text-muted);'; ?>">All</a>
          <a href="leaders.php?type=Leader" class="btn" style="text-decoration: none; padding: 8px 16px; font-size: 0.85rem; <?= $type_filter === 'Leader' ? 'background: var(--primary); color: white;' : 'background: var(--bg-subtle); color: var(--text-muted);'; ?>">Leaders</a>
          <a href="leaders.php?type=Mentor" class="btn" style="text-decoration: none; padding: 8px 16px; font-size: 0.85rem; <?= $type_filter === 'Mentor' ? 'background: var(--accent); color: white;' : 'background: var(--bg-subtle); color: var(--text-muted);'; ?>">Mentors</a>
          <a href="leaders.php?action=new" class="btn" style="background: var(--primary); color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: 700;">Add</a>
        </div>
      </div>

      <p style="background: var(--primary-soft); border-left: 4px solid var(--primary); color: var(--text-main); font-size: 0.85rem; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
        ℹ️ Profiles marked <strong>ACTIVE</strong> appear in the "Leadership &amp; Mentorship" section of the public About Us page, grouped as Leaders and Mentors.
      </p>

      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Photo</th>
              <th>Name &amp; Designation</th>
              <th>Type</th>
              <th>Expertise</th>
              <th>Experience</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($members)): ?>
              <tr><td colspan="8" style="text-align: center; padding: 30px; color: var(--text-muted);">No Leaders or Mentors added yet. Click <strong>Add</strong> to create the first one.</td></tr>
            <?php else: ?>
              <?php foreach ($members as $member): ?>
                <tr>
                  <td style="color: var(--text-muted); font-weight: 700;">#<?= intval($member['display_order']); ?></td>
                  <td>
                    <?php
                      $src = $member['photo'] ?? '';
                      if ($src !== '' && strpos($src, 'http') !== 0) {
                          $src = '../' . ltrim($src, '/');
                      }
                    ?>
                    <?php if ($src !== ''): ?>
                      <img src="<?= htmlspecialchars($src); ?>" alt="<?= htmlspecialchars($member['name']); ?>" class="admin-member-thumb">
                    <?php else: ?>
                      <div class="admin-member-initials <?= $member['member_type'] === 'Mentor' ? 'mentor' : ''; ?>"><?= htmlspecialchars(leader_mentor_initials($member['name'])); ?></div>
                    <?php endif; ?>
                  </td>
                  <td>
                    <strong style="color: var(--text-main); font-size: 1rem;"><?= htmlspecialchars($member['name']); ?></strong><br>
                    <span style="color: var(--text-muted); font-size: 0.82rem;"><?= htmlspecialchars($member['designation']); ?></span>
                  </td>
                  <td>
                    <span class="badge <?= $member['member_type'] === 'Mentor' ? 'badge-accent' : 'badge-primary'; ?>"><?= strtoupper(htmlspecialchars($member['member_type'])); ?></span>
                  </td>
                  <td style="max-width: 220px; font-size: 0.78rem; color: var(--text-muted); font-family: monospace;"><?= htmlspecialchars($member['expertise']); ?></td>
                  <td style="font-size: 0.85rem; color: var(--text-main);"><?= htmlspecialchars($member['experience_years']); ?></td>
                  <td>
                    <a href="leaders.php?action=toggle&id=<?= $member['id']; ?>" title="Click to toggle status" class="badge <?= $member['status'] === 'active' ? 'badge-accent' : 'badge-warning'; ?>" style="text-decoration: none;">
                      <?= strtoupper(htmlspecialchars($member['status'])); ?>
                    </a>
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="leaders.php?action=edit&id=<?= $member['id']; ?>" class="btn" style="background: var(--primary-soft); color: var(--primary); padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Edit</a>
                      <a href="leaders.php?action=delete&id=<?= $member['id']; ?>" onclick="return confirm('Delete this Leader / Mentor profile permanently?')" class="btn" style="background: var(--danger-soft); color: var(--danger); padding: 6px 12px; font-size: 0.8rem; text-decoration: none;">Delete</a>
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
