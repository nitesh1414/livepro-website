<?php
/**
 * LIVEpro Software Solutions
 * CMS Admin Authentication Page (admin/login.php)
 * Modern corporate split-screen login with brand storytelling + secure form
 * Pure Corporate IT Consulting & Client Projects
 */
require_once __DIR__ . '/../includes/functions.php';

if (is_admin_logged_in()) {
    header("Location: index.php");
    exit;
}

/* Boot a fresh CSRF token for this session (defensive: works even on legacy installs) */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
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
        $error = 'Invalid username or password. Demo access: admin / livepro2026';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <meta name="theme-color" content="#182533">
  <title>Admin Login | LIVEpro Software Solutions</title>
  <link rel="icon" type="image/png" href="../assets/images/logo-LP.png" onerror="this.href='/home/user/uploads/logo-LP.png';">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-body">

<div class="login-shell">

  <!-- ---------------------------------------------------------------- BRAND -->
  <aside class="login-brand">
    <a href="../index.php" class="logo" aria-label="LIVEpro Software Solutions home">
      <img src="../assets/images/logo-LP.png" alt="LIVEpro logo" class="logo-img" onerror="this.onerror=null; this.src='/home/user/uploads/logo-LP.png';">
      <span class="logo-text-wrapper">
        <span class="logo-main-text">
          <span class="logo-live">LIVE</span><span class="logo-pro">pro</span>
        </span>
        <span class="logo-software-solutions">Software Solutions</span>
      </span>
    </a>

    <h2>Enterprise CMS Control Centre</h2>
    <p>We spread brand awareness. We have got an AGR team for this business.</p>

    <div class="login-values">
      <div class="login-value">
        <span class="tick" aria-hidden="true">&#10003;</span>
        <span><strong>One dashboard</strong> for capabilities, projects, careers and blogs.</span>
      </div>
      <div class="login-value">
        <span class="tick" aria-hidden="true">&#10003;</span>
        <span><strong>Live CRM pipeline</strong> for enquiries and recruitment leads.</span>
      </div>
      <div class="login-value">
        <span class="tick" aria-hidden="true">&#10003;</span>
        <span><strong>Instant publishing</strong> — your changes reach the public site at once.</span>
      </div>
    </div>

    <p class="login-brand-art">Nagpur &bull; Maharashtra &bull; India</p>
  </aside>

  <!-- ----------------------------------------------------------------- FORM -->
  <main class="login-panel">
    <div class="login-card">
      <a href="../index.php" class="logo" aria-label="LIVEpro home">
        <img src="../assets/images/logo-LP.png" alt="LIVEpro logo" class="logo-img" onerror="this.onerror=null; this.src='/home/user/uploads/logo-LP.png';">
        <span class="logo-text-wrapper">
          <span class="logo-main-text">
            <span class="logo-live">LIVE</span><span class="logo-pro">pro</span>
          </span>
          <span class="logo-software-solutions">Software Solutions</span>
        </span>
      </a>

      <h1>Admin Login</h1>
      <p>Enter your security credentials to manage IT capabilities, client projects, careers and CRM leads.</p>

      <div class="demo-box">
        <strong>Demo credentials</strong><br>
        Username <code>admin</code> &nbsp;&bull;&nbsp; Password <code>livepro2026</code>
      </div>

      <?php if (!empty($error)): ?>
        <div class="error-msg" role="alert">
          <span aria-hidden="true">&#9888;</span>
          <span><?= htmlspecialchars($error); ?></span>
        </div>
      <?php endif; ?>

      <form method="POST" action="login.php" id="adminLoginForm" autocomplete="on">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" class="form-control" value="admin"
                 autocomplete="username" autocapitalize="none" spellcheck="false"
                 placeholder="your.username" required autofocus>
        </div>

        <div class="form-group password-group">
          <label for="password">Password</label>
          <div class="password-field">
            <input type="password" id="password" name="password" class="form-control" value="livepro2026"
                   autocomplete="current-password" placeholder="••••••••" required>
            <button type="button" class="password-toggle" aria-label="Show password">Show</button>
          </div>
          <span class="caps-hint" aria-live="polite">&#9888; Caps Lock is ON</span>
        </div>

        <button type="submit" class="btn btn-primary login-submit" id="loginSubmit">Login</button>
      </form>

      <div class="login-footnote">
        <a href="../index.php">&larr; Back</a>
        <span>Encrypted session &bull; Authorised staff only</span>
      </div>
    </div>
  </main>

</div>

<script>
/* Password visibility, caps-lock hint and button loading state (self-contained). */
(function () {
  var input = document.getElementById('password');
  var toggle = document.querySelector('.password-toggle');
  var hint = document.querySelector('.caps-hint');
  var form = document.getElementById('adminLoginForm');
  var submit = document.getElementById('loginSubmit');

  if (input && toggle) {
    toggle.addEventListener('click', function () {
      var show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      toggle.textContent = show ? 'Hide' : 'Show';
      toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
      input.focus();
    });
  }

  if (input && hint) {
    var checkCaps = function (event) {
      var on = event.getModifierState && event.getModifierState('CapsLock');
      hint.classList.toggle('show', !!on);
    };
    input.addEventListener('keyup', checkCaps);
    input.addEventListener('keydown', checkCaps);
    input.addEventListener('blur', function () { hint.classList.remove('show'); });
  }

  if (form && submit) {
    form.addEventListener('submit', function () {
      submit.classList.add('is-loading');
      submit.innerHTML = '<span class="btn-spinner" aria-hidden="true"></span> Please wait';
      submit.disabled = true;
    });
  }
})();
</script>

</body>
</html>
