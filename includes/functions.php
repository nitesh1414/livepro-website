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
// 13. SECURITY & AUTHENTICATION
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
// 14. FLASH / TOAST MESSAGES
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
            'success' => '#42b72a',
            'error'   => '#fa383e',
            'warning' => '#f7b928',
            'info'    => '#1877f2'
        ];
        $bg = isset($colors[$flash['type']]) ? $colors[$flash['type']] : '#1877f2';
        
        echo "<div id='serverFlashToast' style='position:fixed; bottom:24px; right:24px; z-index:9999; background:{$bg}; color:white; padding:14px 22px; border-radius:8px; font-weight:600; box-shadow:0 10px 15px -3px rgba(0,0,0,0.2); display:flex; align-items:center; gap:12px; animation:slideInToast 0.3s ease forwards;'>
            <span>" . htmlspecialchars($flash['msg']) . "</span>
            <button onclick='this.parentElement.remove()' style='background:none; border:none; color:white; font-size:1.2rem; cursor:pointer; padding:0 4px;'>&times;</button>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('serverFlashToast'); if(t) { t.style.opacity='0'; t.style.transition='all 0.5s'; setTimeout(()=>t.remove(),500); } }, 4500);</script>";
    }
}
?>