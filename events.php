<?php
$pageTitle   = 'Events | CFAG Church';
$currentPage = 'events';

require __DIR__ . '/includes/header.php';
require __DIR__ . '/data/data_loader.php';

$rsvpSuccess = false;
$rsvpErrors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_rsvp'])) {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $eventTitle = trim($_POST['event_title'] ?? '');

    if ($name === '') {
        $rsvpErrors[] = 'Please enter your name.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $rsvpErrors[] = 'Please enter a valid email address.';
    }
    if ($eventTitle === '') {
        $rsvpErrors[] = 'Please select an event.';
    }

    if (empty($rsvpErrors)) {
        // Here you could save to a database or send an email notification.
        $rsvpSuccess = true;
    }
}
?>

<section class="page-header">
    <div class="container">
        <h1>Events</h1>
        <p>Stay up to date with what’s happening at CFAG Church.</p>
    </div>
</section>

<section class="section">
    <div class="container two-column">
        <div>
            <h2>Upcoming Events</h2>
            <?php if (!empty($events)): ?>
                <ul class="card-list">
                    <?php foreach ($events as $event): ?>
                        <li class="card">
                            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                            <p class="meta">
                                <?php echo htmlspecialchars($event['date']); ?>
                                &middot;
                                <?php echo htmlspecialchars($event['time']); ?>
                            </p>
                            <p class="meta">
                                <?php echo htmlspecialchars($event['location']); ?>
                            </p>
                            <p><?php echo htmlspecialchars($event['description']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No events are scheduled at this time. Please check back soon.</p>
            <?php endif; ?>
        </div>
        <div>
            <h2>Event Calendar</h2>
            <p class="small">
                This simple calendar highlights today’s date. You can enhance it later by attaching
                events to specific days using JavaScript or a database.
            </p>
            <div id="events-calendar" class="calendar"></div>
        </div>
    </div>
</section>

<section class="section alt">
    <div class="container">
        <h2>RSVP for an Event</h2>

        <?php if ($rsvpSuccess): ?>
            <div class="alert success">
                Thank you for your RSVP! We look forward to seeing you.
            </div>
        <?php elseif (!empty($rsvpErrors)): ?>
            <div class="alert error">
                <ul>
                    <?php foreach ($rsvpErrors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" class="form">
            <input type="hidden" name="event_rsvp" value="1">
            <div class="form-row">
                <label for="rsvp-name">Name</label>
                <input type="text" id="rsvp-name" name="name"
                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
            </div>
            <div class="form-row">
                <label for="rsvp-email">Email</label>
                <input type="email" id="rsvp-email" name="email"
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </div>
            <div class="form-row">
                <label for="rsvp-event">Event</label>
                <select id="rsvp-event" name="event_title" required>
                    <option value="">Select an event</option>
                    <?php foreach ($events as $event): ?>
                        <?php $selected = (($_POST['event_title'] ?? '') === $event['title']) ? 'selected' : ''; ?>
                        <option value="<?php echo htmlspecialchars($event['title']); ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars($event['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-row">
                <button type="submit" class="btn btn-primary">Submit RSVP</button>
            </div>
        </form>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>


