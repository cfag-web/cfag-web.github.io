<?php
$pageTitle = 'Admin Dashboard';
$currentPage = 'dashboard';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/data_manager.php';

$events = loadData('events');
$sermons = loadData('sermons');
$ministries = loadData('ministries');

$upcomingEvents = array_filter($events, function($event) {
    $eventDate = strtotime($event['date'] ?? '');
    return $eventDate >= time();
});
$upcomingEvents = array_slice($upcomingEvents, 0, 5);
?>

<h1>Admin Dashboard</h1>
<p class="admin-subtitle">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?>!</p>

<div class="admin-stats">
    <div class="admin-stat-card">
        <h3><?php echo count($events); ?></h3>
        <p>Events</p>
        <a href="events.php" class="btn btn-outline btn-small">Manage</a>
    </div>
    <div class="admin-stat-card">
        <h3><?php echo count($sermons); ?></h3>
        <p>Sermons</p>
        <a href="sermons.php" class="btn btn-outline btn-small">Manage</a>
    </div>
    <div class="admin-stat-card">
        <h3><?php echo count($ministries); ?></h3>
        <p>Ministries</p>
        <a href="ministries.php" class="btn btn-outline btn-small">Manage</a>
    </div>
</div>

<section class="admin-section">
    <h2>Quick Actions</h2>
    <div class="admin-actions">
        <a href="events.php?action=add" class="admin-action-card">
            <h3>➕ Add New Event</h3>
            <p>Create a new church event</p>
        </a>
        <a href="sermons.php?action=add" class="admin-action-card">
            <h3>🎤 Add New Sermon</h3>
            <p>Upload a new sermon</p>
        </a>
        <a href="ministries.php?action=add" class="admin-action-card">
            <h3>🤝 Add New Ministry</h3>
            <p>Create a new ministry page</p>
        </a>
    </div>
</section>

<?php if (!empty($upcomingEvents)): ?>
<section class="admin-section">
    <h2>Upcoming Events</h2>
    <ul class="admin-list">
        <?php foreach ($upcomingEvents as $event): ?>
            <li>
                <strong><?php echo htmlspecialchars($event['title']); ?></strong>
                <span class="meta"><?php echo htmlspecialchars($event['date']); ?> at <?php echo htmlspecialchars($event['time']); ?></span>
                <a href="events.php?action=edit&id=<?php echo htmlspecialchars($event['id']); ?>" class="btn btn-outline btn-small">Edit</a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

