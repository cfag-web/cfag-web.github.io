<?php
$pageTitle   = 'Home | CFAG Church';
$currentPage = 'home';

require __DIR__ . '/includes/header.php';
require __DIR__ . '/data/data_loader.php';

// Get latest sermons and upcoming events (simple array slices for now)
$latestSermons = array_slice($sermons, 0, 2);
$upcomingEvents = array_slice($events, 0, 3);
?>

<section class="hero">
    <div class="container hero-inner">
        <div class="hero-text">
            <h1>Welcome to CFAG Church</h1>
            <p class="hero-subtitle">A community centered on Jesus, reaching every generation.</p>
            <p class="hero-service-times">
                Sunday Service &middot; 10:00 AM<br>
                Midweek Gathering &middot; Wednesdays 7:00 PM
            </p>
            <a href="connect.php#plan-visit" class="btn btn-primary">Plan a Visit</a>
        </div>
        <div class="hero-card">
            <h2>This Sunday</h2>
            <p>Join us for worship, teaching, and community.</p>
            <ul class="hero-highlights">
                <li>Uplifting worship</li>
                <li>Biblical teaching</li>
                <li>Fun kids ministry</li>
            </ul>
        </div>
    </div>
</section>

<section class="section mission">
    <div class="container">
        <h2>Our Mission</h2>
        <p>
            We exist to glorify God by making disciples of Jesus who love God, love people,
            and bring hope to our city and the nations.
        </p>
    </div>
</section>

<section class="section split-grid">
    <div class="container split-grid-inner">
        <div>
            <h2>Upcoming Events</h2>
            <?php if (!empty($upcomingEvents)): ?>
                <ul class="card-list">
                    <?php foreach ($upcomingEvents as $event): ?>
                        <li class="card">
                            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                            <p class="meta">
                                <?php echo htmlspecialchars($event['date']); ?> &middot;
                                <?php echo htmlspecialchars($event['time']); ?>
                            </p>
                            <p class="meta">
                                <?php echo htmlspecialchars($event['location']); ?>
                            </p>
                            <p><?php echo htmlspecialchars($event['description']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="events.php" class="link-arrow">View all events</a>
            <?php else: ?>
                <p>No upcoming events listed right now. Check back soon!</p>
            <?php endif; ?>
        </div>
        <div>
            <h2>Latest Sermons</h2>
            <?php if (!empty($latestSermons)): ?>
                <ul class="card-list">
                    <?php foreach ($latestSermons as $sermon): ?>
                        <li class="card">
                            <h3><?php echo htmlspecialchars($sermon['title']); ?></h3>
                            <p class="meta">
                                <?php echo htmlspecialchars($sermon['date']); ?> &middot;
                                <?php echo htmlspecialchars($sermon['speaker']); ?>
                            </p>
                            <p><?php echo htmlspecialchars($sermon['summary']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="sermons.php" class="link-arrow">Browse all sermons</a>
            <?php else: ?>
                <p>Sermons will be posted here soon.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>


