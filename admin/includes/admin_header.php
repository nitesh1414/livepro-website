<?php
require_once __DIR__ . '/../../includes/functions.php';
require_login();
$admin_user = $_SESSION['username'] ?? 'Admin';
$admin_role = $_SESSION['user_role'] ?? 'editor';
$current_admin = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($admin_title) ? sanitize($admin_title) . ' | ' : ''; ?>Admin Panel - LIVEpro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo assets_url('css/style.css'); ?>">
    <style>
        .admin-topbar { background: #fff; border-bottom: 1px solid #e0e0e0; padding: 0.75rem 1.5rem; }
        .admin-content { padding: 1.5rem; }
    </style>
</head>
<body class="admin-body">
<div class="container-fluid">
    <div class="row">
