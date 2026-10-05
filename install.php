<?php
/**
 * ============================================================================
 * LIVEpro Software Solutions x TCS Enterprise Theme (LP Geometric Logo Theme)
 * Complete Multipage CMS Portal - Automated System & Database Installer
 * Pure Corporate IT Consulting, Website & Mobile App Dev, & Client Projects
 * File: install.php
 * ============================================================================
 */

session_start();
$step = isset($_GET['step']) ? intval($_GET['step']) : 1;
$errors = [];
$success_msg = '';
$installed_stats = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'install') {
    $db_mode    = $_POST['db_mode'] ?? 'mysql';
    $db_host    = trim($_POST['db_host'] ?? 'localhost');
    $db_name    = trim($_POST['db_name'] ?? 'livepro_cms_db');
    $db_user    = trim($_POST['db_user'] ?? 'root');
    $db_pass    = $_POST['db_pass'] ?? '';
    
    $site_name  = trim($_POST['site_name'] ?? 'LIVEpro Software Solutions');
    $admin_user = trim($_POST['admin_username'] ?? 'admin');
    $admin_pass = $_POST['admin_password'] ?? 'livepro2026';
    $admin_mail = trim($_POST['admin_email'] ?? 'admin@liveprosolutions.com');
    
    $clean_install = isset($_POST['clean_install']) && $_POST['clean_install'] == '1';
    $seed_demo     = isset($_POST['seed_demo']) && $_POST['seed_demo'] == '1';

    if (empty($admin_user) || empty($admin_pass) || empty($admin_mail)) {
        $errors[] = "Please provide valid Admin Username, Password, and Email.";
    }

    if (empty($errors)) {
        try {
            $pdo = null;

            if ($db_mode === 'mysql') {
                if (!extension_loaded('pdo_mysql')) {
                    throw new Exception("PHP extension 'pdo_mysql' is not installed or enabled on your server.");
                }
                
                $dsn_server = "mysql:host={$db_host};charset=utf8mb4";
                $pdo_server = new PDO($dsn_server, $db_user, $db_pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
                
                $pdo_server->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
                $pdo_server = null;
                
                $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
                $pdo = new PDO($dsn, $db_user, $db_pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } else {
                if (!extension_loaded('pdo_sqlite')) {
                    throw new Exception("PHP extension 'pdo_sqlite' is not enabled.");
                }
                $data_dir = __DIR__ . '/data';
                if (!file_exists($data_dir)) {
                    mkdir($data_dir, 0777, true);
                }
                $sqlite_file = $data_dir . '/livepro_fallback.sqlite';
                if ($clean_install && file_exists($sqlite_file)) {
                    unlink($sqlite_file);
                }
                $pdo = new PDO("sqlite:" . $sqlite_file, null, null, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            }

            // 15 Tables (Courses Removed, Leaders & Mentors Added)
            $tables = ['admin_users', 'site_settings', 'hero_banners', 'feature_panels', 'case_studies', 'services', 'industries', 'blog_posts', 'testimonials', 'inquiries', 'job_openings', 'job_applications', 'projects_portfolio', 'expertise_areas', 'leaders_mentors'];
            if ($clean_install) {
                if ($db_mode === 'mysql') {
                    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
                    foreach ($tables as $t) { $pdo->exec("DROP TABLE IF EXISTS `{$t}`;"); }
                    $pdo->exec("DROP TABLE IF EXISTS `courses`;"); // Drop old courses table if existed
                    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
                } else {
                    foreach ($tables as $t) { $pdo->exec("DROP TABLE IF EXISTS {$t};"); }
                    $pdo->exec("DROP TABLE IF EXISTS courses;");
                }
            }

            if ($db_mode === 'sqlite') {
                // SQLite uses the portable schema + seed routine from includes/config.php
                // (schema.sql is MySQL/MariaDB specific: ENUM, ENGINE, AUTO_INCREMENT, ...)
                require_once __DIR__ . '/includes/config.php';
                seed_sqlite_fallback($pdo);
            } else if (file_exists(__DIR__ . '/schema.sql')) {
                $schema_file = __DIR__ . '/schema.sql';
                $sql = file_get_contents($schema_file);
                $queries = preg_split("/;+(?=([^'|^\\\']*['|\\\'][^'|^\\\']*['|\\\'])*[^'|^\\\']*$)/", $sql);
                foreach ($queries as $query) {
                    $query = trim($query);
                    if (!empty($query) && strpos($query, 'CREATE DATABASE') === false && strpos($query, 'USE ') === false) {
                        $pdo->exec($query);
                    }
                }
            }

            // Seed Admin Account
            $hashed_pass = password_hash($admin_pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("DELETE FROM admin_users WHERE username = ?");
            $stmt->execute([$admin_user]);
            
            $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash, email, full_name, role) VALUES (?, ?, ?, 'System Administrator', 'superadmin')");
            $stmt->execute([$admin_user, $hashed_pass, $admin_mail]);
            $installed_stats['admin'] = $admin_user;
            $installed_stats['tables'] = count($tables);

            // Write config.php
            $config_path = __DIR__ . '/includes/config.php';
            $config_dir  = dirname($config_path);
            if (!file_exists($config_dir)) { mkdir($config_dir, 0777, true); }

            $config_php = "<?php\n" .
            "if (session_status() === PHP_SESSION_NONE) { session_start(); }\n" .
            "define('DB_HOST', '" . addslashes($db_host) . "');\n" .
            "define('DB_NAME', '" . addslashes($db_name) . "');\n" .
            "define('DB_USER', '" . addslashes($db_user) . "');\n" .
            "define('DB_PASS', '" . addslashes($db_pass) . "');\n" .
            "define('DB_CHARSET', 'utf8mb4');\n" .
            "define('SQLITE_FALLBACK_FILE', __DIR__ . '/../data/livepro_fallback.sqlite');\n" .
            "define('SITE_NAME', '" . addslashes($site_name) . "');\n" .
            "define('ADMIN_DEMO_USER', '" . addslashes($admin_user) . "');\n" .
            "define('ADMIN_DEMO_PASS', '" . addslashes($admin_pass) . "');\n" .
            "function get_db_connection() {\n" .
            "    static \$pdo = null; if (\$pdo !== null) return \$pdo;\n" .
            "    if ('" . $db_mode . "' === 'sqlite') {\n" .
            "        \$pdo = new PDO(\"sqlite:\" . SQLITE_FALLBACK_FILE, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]); return \$pdo;\n" .
            "    }\n" .
            "    try {\n" .
            "        \$pdo = new PDO(\"mysql:host=\" . DB_HOST . \";dbname=\" . DB_NAME . \";charset=\" . DB_CHARSET, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]); return \$pdo;\n" .
            "    } catch (PDOException \$e) {\n" .
            "        try { if (!file_exists(dirname(SQLITE_FALLBACK_FILE))) mkdir(dirname(SQLITE_FALLBACK_FILE), 0777, true); \$pdo = new PDO(\"sqlite:\" . SQLITE_FALLBACK_FILE, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]); return \$pdo; } catch(Exception \$ex) { die(\"DB Error\"); }\n" .
            "    }\n" .
            "}\n?>";
            file_put_contents($config_path, $config_php);

            $step = 3;
            $success_msg = "🎉 Complete LIVEpro x TCS Enterprise Suite (15 Tables) successfully installed and seeded!";
        } catch (Exception $ex) {
            $errors[] = "Installation Failed: " . $ex->getMessage();
        }
    }
}

$php_ok    = version_compare(PHP_VERSION, '7.4.0', '>=');
$pdo_ok    = extension_loaded('pdo');
$mysql_ok  = extension_loaded('pdo_mysql');
$sqlite_ok = extension_loaded('pdo_sqlite');
$write_ok  = is_writable(__DIR__) || is_writable(__DIR__ . '/includes');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Installer | LIVEpro x TCS Enterprise Suite</title>
  <link rel="icon" type="image/png" href="assets/images/logo-LP.png" onerror="this.href='/home/user/uploads/logo-LP.png';">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="installer-container">
  <div class="installer-header">
    <a href="index.php" class="logo">
      <img src="assets/images/logo.png" alt="LIVEpro Logo" class="logo-img" onerror="this.onerror=null; this.src='/home/user/uploads/logo.png';">
      <div>
        <div class="logo-text">LIVE<span>pro</span></div>
        <span class="logo-sub">LP Theme Suite Installer</span>
      </div>
    </a>
    <span style="font-size: 0.75rem; background: #e8f0fe; color: #1a85e8; border: 1px solid #1a85e8; padding: 4px 10px; border-radius: 99px; font-weight: 800;">v5.0 PRO</span>
  </div>

  <div class="steps-bar">
    <div class="step-item <?= $step === 1 ? 'active' : ($step > 1 ? 'completed' : ''); ?>">1. Environment Check</div>
    <div class="step-item <?= $step === 2 ? 'active' : ($step > 2 ? 'completed' : ''); ?>">2. Database Setup</div>
    <div class="step-item <?= $step === 3 ? 'active' : ''; ?>">3. Installation Complete</div>
  </div>

  <div class="installer-body">
    <?php if (!empty($errors)): ?>
      <div class="alert alert-error">
        <span>⚠️</span>
        <div>
          <strong>Installation Encountered Errors:</strong>
          <ul style="margin-left: 15px; margin-top: 5px;">
            <?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err); ?></li><?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($step === 1): ?>
      <h2>Server Environment Verification</h2>
      <p class="subtitle">Checking server capabilities to ensure smooth operation of all 15 corporate IT tables and admin suite.</p>
      <ul class="req-list">
        <li class="req-item"><span>PHP Version (7.4+ required) — Detected: <strong><?= PHP_VERSION; ?></strong></span><span class="badge <?= $php_ok ? 'badge-ok' : 'badge-err'; ?>"><?= $php_ok ? 'OK' : 'FAIL'; ?></span></li>
        <li class="req-item"><span>PHP PDO Database Extension</span><span class="badge <?= $pdo_ok ? 'badge-ok' : 'badge-err'; ?>"><?= $pdo_ok ? 'OK' : 'FAIL'; ?></span></li>
        <li class="req-item"><span>MySQL / MariaDB Driver (pdo_mysql)</span><span class="badge <?= $mysql_ok ? 'badge-ok' : 'badge-err'; ?>"><?= $mysql_ok ? 'OK' : 'MISSING'; ?></span></li>
        <li class="req-item"><span>Offline SQLite Fallback Driver (pdo_sqlite)</span><span class="badge <?= $sqlite_ok ? 'badge-ok' : 'badge-err'; ?>"><?= $sqlite_ok ? 'OK' : 'MISSING'; ?></span></li>
        <li class="req-item"><span>Directory Write Permissions (includes/ &amp; data/)</span><span class="badge <?= $write_ok ? 'badge-ok' : 'badge-err'; ?>"><?= $write_ok ? 'WRITABLE' : 'READ-ONLY'; ?></span></li>
      </ul>
      <?php if ($php_ok && ($mysql_ok || $sqlite_ok)): ?>
        <div class="alert alert-info"><span>ℹ️</span><span>Your server meets all necessary requirements! Click below to configure your database.</span></div>
        <a href="install.php?step=2" class="btn btn-primary">Proceed to Database Configuration &rarr;</a>
      <?php else: ?>
        <div class="alert alert-error"><span>⚠️</span><span>Please enable the required PHP extensions or file permissions before proceeding.</span></div>
        <a href="install.php?step=1" class="btn btn-outline">🔄 Re-Check Environment</a>
      <?php endif; ?>

    <?php elseif ($step === 2): ?>
      <h2>Database &amp; System Configuration</h2>
      <p class="subtitle">Enter your database credentials and configure your initial admin account.</p>
      <form method="POST" action="install.php?step=2">
        <input type="hidden" name="action" value="install">
        <div class="form-group" style="background: #e8f0fe; border: 1px solid #1a85e8; padding: 18px; border-radius: 8px; margin-bottom: 25px;">
          <label style="color: #1a85e8; font-size: 0.95rem; margin-bottom: 8px;">Select Database Installation Mode *</label>
          <select name="db_mode" id="dbModeSelect" onchange="toggleDbFields(this.value)" style="background: white; font-weight: 700; color: #1a85e8;">
            <?php if ($mysql_ok): ?><option value="mysql">🐬 MySQL / MariaDB Server (Production Standard)</option><?php endif; ?>
            <?php if ($sqlite_ok): ?><option value="sqlite">📦 SQLite Local File Database (Zero-Config / Offline Development)</option><?php endif; ?>
          </select>
          <p style="font-size: 0.8rem; color: #0f172a; margin: 8px 0 0 0;">MySQL will connect to your server, create database <code>livepro_cms_db</code>, and install 15 corporate IT tables (incl. Leaders &amp; Mentors).</p>
        </div>
        <div id="mysqlFieldsSection">
          <div class="grid-2">
            <div class="form-group"><label>MySQL Host</label><input type="text" name="db_host" value="localhost" required></div>
            <div class="form-group"><label>Database Name</label><input type="text" name="db_name" value="livepro_cms_db" required></div>
          </div>
          <div class="grid-2">
            <div class="form-group"><label>MySQL Username</label><input type="text" name="db_user" value="root" required></div>
            <div class="form-group"><label>MySQL Password</label><input type="password" name="db_pass" placeholder="Leave blank if empty"></div>
          </div>
        </div>
        <hr style="border: none; border-top: 1px solid var(--border); margin: 25px 0;">
        <h3 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 15px; color: #0f172a;">Initial Admin Account &amp; Site Identity</h3>
        <div class="form-group"><label>Company / Portal Title</label><input type="text" name="site_name" value="LIVEpro Software Solutions" required></div>
        <div class="grid-2">
          <div class="form-group"><label>Admin Username *</label><input type="text" name="admin_username" value="admin" required></div>
          <div class="form-group"><label>Admin Password *</label><input type="text" name="admin_password" value="livepro2026" required></div>
        </div>
        <div class="form-group"><label>Admin Email Address *</label><input type="email" name="admin_email" value="admin@liveprosolutions.com" required></div>
        <div class="checkbox-group">
          <input type="checkbox" name="seed_demo" id="seedDemo" value="1" checked>
          <div><label for="seedDemo">Seed Database with Complete LIVEpro Corporate IT &amp; Projects Content</label><p>Automatically populates all 15 tables with Banners (with Background Images!), Capabilities, Case Studies, Client Projects, Expertise, and Careers!</p></div>
        </div>
        <div class="checkbox-group" style="border-color: #d92323; background: #ffebe9;">
          <input type="checkbox" name="clean_install" id="cleanInstall" value="1" checked>
          <div><label for="cleanInstall" style="color: #c2070e;">Re-Create / Overwrite Existing Tables (Clean Install)</label><p>Drops existing tables before creating the new 14-table schema.</p></div>
        </div>
        <div style="display: flex; gap: 15px; margin-top: 30px;">
          <a href="install.php?step=1" class="btn btn-outline" style="width: auto; padding: 14px 25px;">&larr; Back</a>
          <button type="submit" class="btn btn-accent" style="flex: 1;">🚀 Install Schema &amp; Seed Database Now</button>
        </div>
      </form>
      <script>function toggleDbFields(v) { const s = document.getElementById('mysqlFieldsSection'); if(s) s.style.display=(v==='mysql'?'block':'none'); } toggleDbFields(document.getElementById('dbModeSelect').value);</script>

    <?php elseif ($step === 3): ?>
      <div style="text-align: center; padding: 10px 0;">
        <div style="width: 65px; height: 65px; background: #e6f4ea; color: #137333; border: 2px solid #58b32e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 20px; font-weight: 800;">✔</div>
        <h2>Installation Completed Successfully!</h2>
        <p class="subtitle">The 14-table schema, relational databases, and LP Geometric Logo theme content have been installed.</p>
        <div class="stats-box">
          <div class="stat-item"><div class="stat-num">14</div><div class="stat-lbl">Relational Tables</div></div>
          <div class="stat-item"><div class="stat-num">35+</div><div class="stat-lbl">Seeded Elements</div></div>
          <div class="stat-item"><div class="stat-num">100%</div><div class="stat-lbl">CMS Editable</div></div>
        </div>
        <div style="background: #e8f0fe; border: 1px solid #1a85e8; padding: 20px; border-radius: 8px; text-align: left; margin-bottom: 30px;">
          <h4 style="color: #1a85e8; font-size: 0.95rem; margin-bottom: 10px;">🔐 Your Admin Login Credentials:</h4>
          <p style="font-size: 0.95rem; color: #0f172a; margin-bottom: 4px;"><strong>Username:</strong> <code><?= htmlspecialchars($installed_stats['admin'] ?? 'admin'); ?></code></p>
          <p style="font-size: 0.95rem; color: #0f172a; margin: 0;"><strong>Password:</strong> <span style="color: #64748b;">(As configured during Step 2)</span></p>
        </div>
        <div class="grid-2" style="gap: 15px;">
          <a href="index.php" class="btn btn-primary">🌐 Launch Public Portal</a>
          <a href="admin/login.php" class="btn btn-accent">🛡️ Enter CMS Admin Suite</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>