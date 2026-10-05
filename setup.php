<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * 1-Click MySQL Database Installer & Setup Wizard
 */

session_start();
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = trim($_POST['db_host'] ?? 'localhost');
    $db_name = trim($_POST['db_name'] ?? 'livepro_cms_db');
    $db_user = trim($_POST['db_user'] ?? 'root');
    $db_pass = $_POST['db_pass'] ?? '';

    try {
        // 1. Connect to MySQL without dbname first to create DB if missing
        $dsn = "mysql:host={$db_host};charset=utf8mb4";
        $pdo = new PDO($dsn, $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // 2. Create database
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        $pdo->exec("USE `{$db_name}`;");

        // 3. Read and execute schema.sql
        $schema_file = __DIR__ . '/schema.sql';
        //exit;
        if (!file_exists($schema_file)) {
            throw new Exception("schema.sql file not found in directory!");
        }

        require_once __DIR__ . '/includes/sql_tools.php';

        // Deterministic statement splitter (string / escape / comment / emoji safe)
        $statements = livepro_split_sql(file_get_contents($schema_file));
        if (empty($statements)) {
            throw new Exception("schema.sql could not be read or contains no SQL statements!");
        }

        $executed = 0;
        foreach ($statements as $statement) {
            $keyword = livepro_sql_first_keyword($statement);
            if (livepro_sql_is_environment_statement($keyword)) {
                continue;   // connection already selects the target database
            }
            try {
                $pdo->exec($statement);
                $executed++;
            } catch (PDOException $statement_error) {
                throw new Exception("SQL error in [" . $keyword . "]: " . $statement_error->getMessage());
            }
        }

        // Verify the schema before touching admin records
        if (!livepro_table_exists($pdo, 'admin_users')) {
            throw new Exception("The schema is incomplete - table 'admin_users' was not created. Please import schema.sql manually.");
        }

        // 4. Update includes/config.php
        $config_file = __DIR__ . '/includes/config.php';
        $config_content = file_get_contents($config_file);
        
        $config_content = preg_replace("/define\('DB_HOST', '.*?'\);/", "define('DB_HOST', '{$db_host}');", $config_content);
        $config_content = preg_replace("/define\('DB_NAME', '.*?'\);/", "define('DB_NAME', '{$db_name}');", $config_content);
        $config_content = preg_replace("/define\('DB_USER', '.*?'\);/", "define('DB_USER', '{$db_user}');", $config_content);
        $config_content = preg_replace("/define\('DB_PASS', '.*?'\);/", "define('DB_PASS', '{$db_pass}');", $config_content);
        
        file_put_contents($config_file, $config_content);

        $success_message = "🎉 MySQL Database '{$db_name}' successfully created, seeded with LIVEpro data, and config.php updated!";
    } catch (Exception $e) {
        $error_message = "Setup Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIVEpro CMS Portal - MySQL Setup Wizard</title>
    <link rel="icon" type="image/png" href="assets/images/logo-LP.png" onerror="this.href='/home/user/uploads/logo-LP.png';">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #0f172a;">
    <div class="setup-card">
        <div class="logo">
            <div class="logo-icon">L</div>
            <div>LIVE<span>pro</span> <small style="font-size:0.55em; display:block; color:#94a3b8;">Setup Wizard</small></div>
        </div>
        
        <h1>MySQL Database Installer</h1>
        <p>Configure your MySQL database credentials below. This wizard will automatically create the database <code>livepro_cms_db</code>, generate all tables, and seed initial content.</p>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-error"><?= $error_message; ?></div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?= $success_message; ?>
                <div style="margin-top: 15px; display: flex; gap: 10px;">
                    <a href="index.php" class="btn btn-success" style="flex: 1;">Launch Public Portal</a>
                    <a href="admin/login.php" class="btn" style="flex: 1; background: #4f46e5;">Enter Admin CMS</a>
                </div>
            </div>
        <?php else: ?>
            <form method="POST" action="setup.php">
                <div class="form-group">
                    <label>MySQL Host</label>
                    <input type="text" name="db_host" value="localhost" required>
                </div>
                <div class="form-group">
                    <label>Database Name</label>
                    <input type="text" name="db_name" value="livepro_cms_db" required>
                </div>
                <div class="form-group">
                    <label>MySQL Username</label>
                    <input type="text" name="db_user" value="root" required>
                </div>
                <div class="form-group">
                    <label>MySQL Password</label>
                    <input type="password" name="db_pass" placeholder="Leave blank if no password">
                </div>
                <button type="submit" class="btn">🚀 Initialize Database & Seed Content</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>