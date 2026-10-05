<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme
 * CMS Admin Authentication Page (admin/login.php)
 * Pure Corporate IT Consulting & Client Projects
 */
require_once __DIR__ . '/../includes/functions.php';

if (is_admin_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (login_admin($user, $pass)) {
        flash_message("Welcome back, " . htmlspecialchars($_SESSION['admin_full_name']) . "!", "success");
        header("Location: index.php");
        exit;
    } else {
        $error = 'Invalid username or password. Please use demo credentials: admin / livepro2026';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CMS Login | LIVEpro Software Solutions</title>
  <link rel="icon" type="image/png" href="../assets/images/logo-LP.png" onerror="this.href='/home/user/uploads/logo-LP.png';">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background: #090d16;">

<div class="login-card">
  <!-- BRAND WITH LOGO-LP.PNG AND MATCHING TYPOGRAPHY -->
  <a href="../index.php" class="logo">
    <img src="../assets/images/logo-LP.png" alt="LIVEpro Geometric Logo" class="logo-img" onerror="this.onerror=null; this.src='/home/user/uploads/logo-LP.png';">
    <div style="display: flex; flex-direction: column; justify-content: center; line-height: 1;">
      <div>
        <span style="font-family: 'Arial Black', 'Impact', sans-serif; color: #1a85e8; font-size: 1.6rem; font-weight: 900; letter-spacing: 0.5px;">LIVE</span><span style="font-family: 'Times New Roman', Georgia, serif; color: #c92020; font-size: 1.6rem; font-weight: bold;">pro</span>
      </div>
      <span style="font-family: 'Monotype Corsiva', 'Apple Chancery', 'Lucida Calligraphy', cursive; color: #22a316; font-size: 0.85rem; font-style: italic; display: block; margin-top: -3px;">Software Solutions</span>
    </div>
  </a>

  <h1>Admin Portal Access</h1>
  <p>Enter your security credentials to manage corporate IT capabilities, client project deliverables, and CRM leads.</p>

  <div class="demo-box">
    <strong>Demo Credentials:</strong><br>
    Username: <code>admin</code> | Password: <code>livepro2026</code>
  </div>

  <?php if (!empty($error)): ?>
    <div class="error-msg"><?= htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <div class="form-group">
      <label>Admin Username</label>
      <input type="text" name="username" value="admin" required>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" value="livepro2026" required>
    </div>
    <button type="submit" class="btn">🛡️ Login to Corporate CMS Suite</button>
  </form>

  <div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
    <a href="../index.php" style="color: #60a5fa; font-size: 0.85rem; text-decoration: none; font-weight: 600;">&larr; Return to Live Public Portal</a>
  </div>
</div>

</body>
</html>