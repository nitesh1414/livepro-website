<?php
// LIVEpro CMS Database Configuration
// Update these credentials to match your MySQL server

$host = 'localhost';
$dbname = 'livepro_cms';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Define base URL dynamically
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
$script_path = $_SERVER['PHP_SELF'];
$project_dir = dirname($script_path);

// If inside the admin folder, move one level up
if (strpos($project_dir, '/admin') !== false) {
    $project_dir = substr($project_dir, 0, strpos($project_dir, '/admin'));
}

$base_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim($project_dir, '/');
$base_url = rtrim($base_url, '/');

// Project paths
$base_path = __DIR__ . '/..';
$assets_url = $base_url . '/assets';
$admin_url = $base_url . '/admin';
