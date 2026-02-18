<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Admin Dashboard';
}
require_once __DIR__ . '/auth.php';
requireAdminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-body">
<header class="admin-header">
    <div class="container">
        <div class="admin-header-inner">
            <div class="admin-logo">
                <a href="index.php">CFAG Admin</a>
            </div>
            <nav class="admin-nav">
                <a href="index.php" class="<?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>">Dashboard</a>
                <a href="events.php" class="<?php echo ($currentPage ?? '') === 'events' ? 'active' : ''; ?>">Events</a>
                <a href="sermons.php" class="<?php echo ($currentPage ?? '') === 'sermons' ? 'active' : ''; ?>">Sermons</a>
                <a href="ministries.php" class="<?php echo ($currentPage ?? '') === 'ministries' ? 'active' : ''; ?>">Ministries</a>
                <a href="../index.php" target="_blank">View Site</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </div>
</header>
<main class="admin-main">
    <div class="container">

