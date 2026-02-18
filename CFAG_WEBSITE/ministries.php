<?php
$pageTitle   = 'Ministries | CFAG Church';
$currentPage = 'ministries';

require __DIR__ . '/includes/header.php';
require __DIR__ . '/data/data_loader.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Ministries</h1>
        <p>Discover ways to grow, connect, and serve at CFAG Church.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card-grid three">
            <?php foreach ($ministries as $ministry): ?>
                <article class="card">
                    <h2><?php echo htmlspecialchars($ministry['name']); ?></h2>
                    <p><?php echo htmlspecialchars($ministry['description']); ?></p>
                    <p class="meta">
                        Leader: <?php echo htmlspecialchars($ministry['leader']); ?><br>
                        Contact: <a href="mailto:<?php echo htmlspecialchars($ministry['contact']); ?>">
                            <?php echo htmlspecialchars($ministry['contact']); ?>
                        </a><br>
                        Schedule: <?php echo htmlspecialchars($ministry['schedule']); ?>
                    </p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section alt">
    <div class="container two-column">
        <div>
            <h2>Serve on a Team</h2>
            <p>
                God has given each of us unique gifts to serve others. From hospitality and kids ministry
                to worship, production, and outreach, there is a place for you.
            </p>
            <p>
                If you’re ready to get involved, fill out the Connect form and we’ll help you find
                the right next step.
            </p>
            <a href="connect.php" class="btn btn-primary">I Want to Serve</a>
        </div>
        <div>
            <h2>Community Groups</h2>
            <p>
                Beyond Sundays, we gather in homes and on-campus for Bible study, prayer, and friendship.
                Community groups are one of the best ways to grow in your faith and build relationships.
            </p>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>


