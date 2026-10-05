<?php
$current = basename($_SERVER['PHP_SELF']);
?>
<div class="col-auto col-md-3 col-lg-2 px-0 admin-sidebar">
    <div class="d-flex flex-column align-items-start min-vh-100">
        <a href="<?php echo admin_url(); ?>" class="d-flex align-items-center p-3 text-decoration-none w-100">
            <img src="<?php echo assets_url(get_setting($pdo, 'logo')); ?>" alt="" height="40" class="me-2">
            <span class="text-white fw-bold">LIVEpro Admin</span>
        </a>
        <ul class="nav nav-pills flex-column w-100 mt-2">
            <li class="nav-item"><a href="<?php echo admin_url('index.php'); ?>" class="nav-link <?php echo $current === 'index.php' ? 'active' : ''; ?>"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="nav-item"><a href="<?php echo admin_url('pages.php'); ?>" class="nav-link <?php echo in_array($current, ['pages.php','page_edit.php']) ? 'active' : ''; ?>"><i class="material-icons">article</i> Pages</a></li>
            <li class="nav-item"><a href="<?php echo admin_url('carousel.php'); ?>" class="nav-link <?php echo in_array($current, ['carousel.php','carousel_edit.php']) ? 'active' : ''; ?>"><i class="material-icons">slideshow</i> Hero Carousel</a></li>
            <li class="nav-item"><a href="<?php echo admin_url('services.php'); ?>" class="nav-link <?php echo in_array($current, ['services.php','service_edit.php']) ? 'active' : ''; ?>"><i class="material-icons">miscellaneous_services</i> Services</a></li>
            <li class="nav-item"><a href="<?php echo admin_url('products.php'); ?>" class="nav-link <?php echo in_array($current, ['products.php','product_edit.php']) ? 'active' : ''; ?>"><i class="material-icons">inventory_2</i> Products</a></li>
            <li class="nav-item"><a href="<?php echo admin_url('contacts.php'); ?>" class="nav-link <?php echo $current === 'contacts.php' ? 'active' : ''; ?>"><i class="material-icons">mail</i> Messages</a></li>
            <?php if (is_admin()): ?>
            <li class="nav-item"><a href="<?php echo admin_url('users.php'); ?>" class="nav-link <?php echo in_array($current, ['users.php','user_edit.php']) ? 'active' : ''; ?>"><i class="material-icons">people</i> Users</a></li>
            <li class="nav-item"><a href="<?php echo admin_url('settings.php'); ?>" class="nav-link <?php echo $current === 'settings.php' ? 'active' : ''; ?>"><i class="material-icons">settings</i> Settings</a></li>
            <?php endif; ?>
            <li class="nav-item"><a href="<?php echo admin_url('change_password.php'); ?>" class="nav-link <?php echo $current === 'change_password.php' ? 'active' : ''; ?>"><i class="material-icons">lock</i> Change Password</a></li>
        </ul>
    </div>
</div>
<div class="col col-md-9 col-lg-10 px-0">
    <div class="admin-topbar d-flex justify-content-between align-items-center">
        <span class="fw-bold text-muted">Welcome, <?php echo sanitize($admin_user); ?> (<?php echo ucfirst($admin_role); ?>)</span>
        <div>
            <a href="<?php echo base_url(); ?>" target="_blank" class="btn btn-sm btn-outline-secondary me-2">View Site</a>
            <a href="<?php echo admin_url('change_password.php'); ?>" class="btn btn-sm btn-outline-warning me-2"><i class="material-icons" style="font-size:14px;vertical-align:middle;">lock</i> Change Password</a>
            <a href="<?php echo admin_url('logout.php'); ?>" class="btn btn-sm btn-livepro">Logout</a>
        </div>
    </div>
    <div class="admin-content">
        <?php echo show_flash(); ?>
