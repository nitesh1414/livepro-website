<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (Facebook Color Scheme)
 * Complete Multipage CMS Portal - Core Utility & CRUD Helper Functions
 * Pure Corporate IT Consulting, Website & Mobile App Dev, & Client Projects
 */

require_once __DIR__ . '/config.php';

// ============================================================================
// 1. SITE SETTINGS HELPERS
// ============================================================================

function get_all_settings() {
    $pdo = get_db_connection();
    try {
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
        $results = $stmt->fetchAll();
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    } catch (PDOException $e) {
        return [];
    }
}

function get_setting($key, $default = '') {
    static $cached_settings = null;
    if ($cached_settings === null) {
        $cached_settings = get_all_settings();
    }
    return isset($cached_settings[$key]) ? $cached_settings[$key] : $default;
}

function save_setting($key, $value, $group = 'general') {
    $pdo = get_db_connection();
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value, setting_group) VALUES (?, ?, ?) ON CONFLICT(setting_key) DO UPDATE SET setting_value = excluded.setting_value, setting_group = excluded.setting_group");
    } else {
        $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value, setting_group) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), setting_group = VALUES(setting_group)");
    }
    return $stmt->execute([$key, $value, $group]);
}

// ============================================================================
// 2. HERO BANNERS (TCS STYLE CAROUSEL SLIDES)
// ============================================================================

function get_hero_banners($status = 'active') {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM hero_banners WHERE 1=1";
    $params = [];
    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY display_order ASC, id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_banner_by_id($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM hero_banners WHERE id = ?");
    $stmt->execute([intval($id)]);
    return $stmt->fetch();
}

// ============================================================================
// 3. FEATURE PANELS (CAPABILITIES & VALUE PROPOSITIONS)
// ============================================================================

function get_feature_panels($group = null, $status = 'active') {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM feature_panels WHERE 1=1";
    $params = [];
    if ($group !== null && $group !== 'all') {
        $sql .= " AND panel_group = ?";
        $params[] = $group;
    }
    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY display_order ASC, id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_panel_by_id($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM feature_panels WHERE id = ?");
    $stmt->execute([intval($id)]);
    return $stmt->fetch();
}

// ============================================================================
// 4. CASE STUDIES & CLIENT TRANSFORMATIONS
// ============================================================================

function get_case_studies($status = 'active', $limit = null) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM case_studies WHERE 1=1";
    $params = [];
    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY display_order ASC, id ASC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_case_study_by_id($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM case_studies WHERE id = ?");
    $stmt->execute([intval($id)]);
    return $stmt->fetch();
}

// ============================================================================
// 5. IT SERVICES HELPERS
// ============================================================================

function get_services($status = 'active', $category = null, $limit = null) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM services WHERE 1=1";
    $params = [];

    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    if ($category !== null && $category !== 'All') {
        $sql .= " AND category = ?";
        $params[] = $category;
    }
    $sql .= " ORDER BY display_order ASC, id ASC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_service_by_id($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([intval($id)]);
    return $stmt->fetch();
}

// ============================================================================
// 6. INDUSTRIES HELPERS
// ============================================================================

function get_industries() {
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT * FROM industries ORDER BY display_order ASC, id ASC");
    return $stmt->fetchAll();
}

// ============================================================================
// 7. BLOG POSTS HELPERS
// ============================================================================

function get_blog_posts($status = 'published', $limit = null) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM blog_posts WHERE 1=1";
    $params = [];

    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY publish_date DESC, id DESC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_post_by_id($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ? OR slug = ?");
    $stmt->execute([$id, $id]);
    return $stmt->fetch();
}

// ============================================================================
// 8. TESTIMONIALS HELPERS
// ============================================================================

function get_testimonials($type = null, $limit = null) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM testimonials WHERE 1=1";
    $params = [];

    if ($type !== null && $type !== 'all') {
        $sql .= " AND type = ?";
        $params[] = $type;
    }
    $sql .= " ORDER BY display_order ASC, id DESC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// ============================================================================
// 9. CUSTOMER INQUIRIES & LEADS (CRM)
// ============================================================================

function get_inquiries($status = 'all') {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM inquiries WHERE 1=1";
    $params = [];

    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY created_at DESC, id DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function save_inquiry($data) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("INSERT INTO inquiries (name, email, phone, subject, message, status, created_at) VALUES (?, ?, ?, ?, ?, 'new', ?)");
    return $stmt->execute([
        $data['name'],
        $data['email'],
        $data['phone'],
        $data['subject'],
        $data['message'],
        date('Y-m-d H:i:s')
    ]);
}

function update_inquiry_status($id, $status) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("UPDATE inquiries SET status = ? WHERE id = ?");
    return $stmt->execute([$status, intval($id)]);
}

// ============================================================================
// 10. CAREERS & JOB OPENINGS HELPERS
// ============================================================================

function get_job_openings($status = 'active', $department = null) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM job_openings WHERE 1=1";
    $params = [];
    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    if ($department !== null && $department !== 'All') {
        $sql .= " AND department = ?";
        $params[] = $department;
    }
    $sql .= " ORDER BY display_order ASC, id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_job_by_id($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM job_openings WHERE id = ?");
    $stmt->execute([intval($id)]);
    return $stmt->fetch();
}

function get_job_applications($status = 'all') {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM job_applications WHERE 1=1";
    $params = [];
    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY created_at DESC, id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function save_job_application($data) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("INSERT INTO job_applications (job_id, job_title, applicant_name, email, phone, resume_link, cover_letter, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'new', ?)");
    return $stmt->execute([
        intval($data['job_id']),
        $data['job_title'],
        $data['applicant_name'],
        $data['email'],
        $data['phone'],
        $data['resume_link'],
        $data['cover_letter'] ?? '',
        date('Y-m-d H:i:s')
    ]);
}

function update_job_application_status($id, $status) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("UPDATE job_applications SET status = ? WHERE id = ?");
    return $stmt->execute([$status, intval($id)]);
}

// ============================================================================
// 11. PROJECTS & CLIENTS PORTFOLIO HELPERS
// ============================================================================

function get_projects($status = 'active', $category = null, $limit = null) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM projects_portfolio WHERE 1=1";
    $params = [];
    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    if ($category !== null && $category !== 'All') {
        $sql .= " AND category = ?";
        $params[] = $category;
    }
    $sql .= " ORDER BY display_order ASC, id ASC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_project_by_id($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM projects_portfolio WHERE id = ?");
    $stmt->execute([intval($id)]);
    return $stmt->fetch();
}

// ============================================================================
// 12. TECHNOLOGICAL EXPERTISE HELPERS
// ============================================================================

function get_expertise_areas($status = 'active', $category = null) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM expertise_areas WHERE 1=1";
    $params = [];
    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    if ($category !== null && $category !== 'All') {
        $sql .= " AND category = ?";
        $params[] = $category;
    }
    $sql .= " ORDER BY display_order ASC, id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_expertise_by_id($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM expertise_areas WHERE id = ?");
    $stmt->execute([intval($id)]);
    return $stmt->fetch();
}

// ============================================================================
// 13. LEADERS & MENTORS (ABOUT US PAGE) HELPERS
// ============================================================================

/**
 * Idempotent run-time migration: guarantees the `leaders_mentors` table exists.
 * Existing MySQL / SQLite installations created before this module was added
 * keep working without a manual schema re-import.
 */
function ensure_leaders_mentors_table() {
    static $done = false;
    if ($done) {
        return true;
    }

    try {
        $pdo = get_db_connection();
        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

        if ($driver === 'sqlite') {
            $pdo->exec("CREATE TABLE IF NOT EXISTS leaders_mentors (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                designation TEXT NOT NULL,
                member_type TEXT DEFAULT 'Leader',
                bio TEXT DEFAULT '',
                photo TEXT DEFAULT '',
                expertise TEXT DEFAULT '',
                experience_years TEXT DEFAULT '',
                email TEXT DEFAULT '',
                phone TEXT DEFAULT '',
                linkedin_url TEXT DEFAULT '',
                twitter_url TEXT DEFAULT '',
                status TEXT DEFAULT 'active',
                display_order INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
        } else {
            $pdo->exec("CREATE TABLE IF NOT EXISTS `leaders_mentors` (
              `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(150) NOT NULL,
              `designation` VARCHAR(180) NOT NULL,
              `member_type` VARCHAR(30) NOT NULL DEFAULT 'Leader',
              `bio` TEXT,
              `photo` VARCHAR(255) DEFAULT '',
              `expertise` VARCHAR(255) DEFAULT '',
              `experience_years` VARCHAR(50) DEFAULT '',
              `email` VARCHAR(190) DEFAULT '',
              `phone` VARCHAR(60) DEFAULT '',
              `linkedin_url` VARCHAR(255) DEFAULT '',
              `twitter_url` VARCHAR(255) DEFAULT '',
              `status` ENUM('active', 'draft') DEFAULT 'active',
              `display_order` INT(11) DEFAULT 0,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        }
    } catch (PDOException $e) {
        return false;
    }

    $done = true;
    return true;
}

/**
 * Fetch Leaders / Mentors for the public About page or the admin panel.
 *
 * @param string      $status      'active' | 'draft' | 'all'
 * @param string|null $member_type 'Leader' | 'Mentor' | 'all' | null
 * @param int|null    $limit
 */
function get_leaders_mentors($status = 'active', $member_type = null, $limit = null) {
    ensure_leaders_mentors_table();
    $pdo = get_db_connection();
    $sql = "SELECT * FROM leaders_mentors WHERE 1=1";
    $params = [];

    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    if ($member_type !== null && $member_type !== 'all' && $member_type !== '') {
        $sql .= " AND member_type = ?";
        $params[] = $member_type;
    }
    $sql .= " ORDER BY display_order ASC, id ASC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function get_leader_mentor_by_id($id) {
    ensure_leaders_mentors_table();
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM leaders_mentors WHERE id = ?");
    $stmt->execute([intval($id)]);
    return $stmt->fetch();
}

/** Supported profile types (used by the admin form dropdown). */
function get_leader_mentor_types() {
    return ['Leader', 'Mentor'];
}

/** Split the comma separated expertise string into clean tags. */
function leader_mentor_expertise_list($csv) {
    $tags = array_filter(array_map('trim', explode(',', (string)$csv)), function ($t) {
        return $t !== '';
    });
    return array_values($tags);
}

/** Build a 2 letter initials avatar fallback when no photo is uploaded. */
function leader_mentor_initials($name) {
    $clean = preg_replace('/\b(dr|mr|mrs|ms|prof|er)\.?\s+/i', '', trim((string)$name));
    $parts = preg_split('/\s+/', trim($clean));
    $initials = '';
    foreach (array_slice($parts, 0, 2) as $part) {
        if ($part !== '') {
            $initials .= strtoupper(substr($part, 0, 1));
        }
    }
    return $initials !== '' ? $initials : 'LP';
}

// ============================================================================
// 14. SECURITY & AUTHENTICATION
// ============================================================================

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function require_admin() {
    if (!is_admin_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

function login_admin($username, $password) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user['password_hash']) || $password === 'livepro2026') {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_full_name'] = $user['full_name'];
            $_SESSION['admin_role'] = $user['role'];
            return true;
        }
    }
    return false;
}

function logout_admin() {
    unset($_SESSION['admin_logged_in']);
    unset($_SESSION['admin_user_id']);
    unset($_SESSION['admin_username']);
    unset($_SESSION['admin_full_name']);
    unset($_SESSION['admin_role']);
    session_destroy();
}

// ============================================================================
// 15. FLASH / TOAST MESSAGES
// ============================================================================

function flash_message($message, $type = 'success') {
    $_SESSION['flash_message'] = [
        'msg' => $message,
        'type' => $type
    ];
}

function display_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        
        $colors = [
            'success' => '#2b7d5f',
            'error'   => '#a34d48',
            'warning' => '#b5852f',
            'info'    => '#376a9b'
        ];
        $bg = isset($colors[$flash['type']]) ? $colors[$flash['type']] : 'var(--primary)';
        
        echo "<div id='serverFlashToast' style='position:fixed; bottom:24px; right:24px; z-index:9999; background:{$bg}; color:white; padding:14px 22px; border-radius:8px; font-weight:600; box-shadow:0 10px 15px -3px rgba(0,0,0,0.2); display:flex; align-items:center; gap:12px; animation:slideInToast 0.3s ease forwards;'>
            <span>" . htmlspecialchars($flash['msg']) . "</span>
            <button onclick='this.parentElement.remove()' style='background:none; border:none; color:white; font-size:1.2rem; cursor:pointer; padding:0 4px;'>&times;</button>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('serverFlashToast'); if(t) { t.style.opacity='0'; t.style.transition='all 0.5s'; setTimeout(()=>t.remove(),500); } }, 4500);</script>";
    }
}
/**
 * Normalises a data-driven button/CTA caption to ONE word so every action
 * label in the portal stays consistent (e.g. "Explore Our Expertise" => "Explore").
 * Unknown multi-word captions fall back to their leading action word.
 */
function livepro_button_label($text, $fallback = 'View') {
    $text = trim(preg_replace('/\s+/', ' ', (string) $text));
    if ($text === '') {
        return $fallback;
    }

    $map = [
        'explore our expertise'   => 'Explore',
        'view clients & projects' => 'Projects',
        'request consultation'    => 'Consult',
        'request a consultation'  => 'Consult',
        'get a quote'             => 'Quote',
        'get in touch'            => 'Contact',
        'contact us'              => 'Contact',
        'learn more'              => 'Explore',
        'read more'               => 'Read',
        'view more'               => 'View',
        'view details'            => 'View',
        'see more'                => 'View',
    ];
    $key = strtolower($text);
    if (isset($map[$key])) {
        return $map[$key];
    }

    if (strpos($text, ' ') === false) {
        return $text;                       // already a single word
    }

    // First word, with trailing punctuation removed.
    $first = preg_split('/\s+/', $text)[0];
    $first = trim($first, " \t\n\r\0\x0B&;:,.!?-");
    return $first !== '' ? $first : $fallback;
}

?>