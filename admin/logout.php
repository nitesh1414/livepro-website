<?php
/**
 * LIVEpro Software Solutions - Complete Multipage CMS Portal
 * CMS Admin Logout (admin/logout.php)
 */
require_once __DIR__ . '/../includes/functions.php';
logout_admin();
flash_message("You have been successfully logged out of the admin panel.", "info");
header("Location: login.php");
exit;
?>