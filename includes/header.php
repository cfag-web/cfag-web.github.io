<?php
if (!isset($pageTitle)) {
    $pageTitle = 'CFAG Church';
}

if (!isset($currentPage)) {
    $currentPage = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <div class="logo">
            <a href="index.php">CFAG Church</a>
            <span class="tagline">COMMUNITY OF FAITH ASSEMBLIES OF GOD</span>
        </div>
        <nav class="main-nav">
            <button class="nav-toggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul>
                <li class="<?php echo $currentPage === 'home' ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
                <li class="<?php echo $currentPage === 'about' ? 'active' : ''; ?>"><a href="about.php">About</a></li>
                <li class="<?php echo $currentPage === 'services' ? 'active' : ''; ?>"><a href="services.php">Services</a></li>
                <li class="<?php echo $currentPage === 'sermons' ? 'active' : ''; ?>"><a href="sermons.php">Sermons</a></li>
                <li class="<?php echo $currentPage === 'events' ? 'active' : ''; ?>"><a href="events.php">Events</a></li>
                <li class="<?php echo $currentPage === 'ministries' ? 'active' : ''; ?>"><a href="ministries.php">Ministries</a></li>
                <li class="<?php echo $currentPage === 'connect' ? 'active' : ''; ?>"><a href="connect.php">Connect</a></li>
                <li class="<?php echo $currentPage === 'give' ? 'active' : ''; ?>"><a href="give.php">Give</a></li>
                <li class="<?php echo $currentPage === 'gallery' ? 'active' : ''; ?>"><a href="gallery.php">Gallery</a></li>
            </ul>
        </nav>
    </div>
</header>
<main class="site-main">


