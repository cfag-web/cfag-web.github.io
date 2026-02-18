<?php
$pageTitle = 'Manage Events';
$currentPage = 'events';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/data_manager.php';

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'add') {
            $newEvent = [
                'title' => trim($_POST['title'] ?? ''),
                'date' => trim($_POST['date'] ?? ''),
                'time' => trim($_POST['time'] ?? ''),
                'location' => trim($_POST['location'] ?? ''),
                'description' => trim($_POST['description'] ?? '')
            ];
            
            if (addItem('events', $newEvent)) {
                $message = 'Event added successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error adding event.';
                $messageType = 'error';
            }
        } elseif ($action === 'edit') {
            $id = $_POST['id'] ?? '';
            $updatedEvent = [
                'title' => trim($_POST['title'] ?? ''),
                'date' => trim($_POST['date'] ?? ''),
                'time' => trim($_POST['time'] ?? ''),
                'location' => trim($_POST['location'] ?? ''),
                'description' => trim($_POST['description'] ?? '')
            ];
            
            if (updateItem('events', $id, $updatedEvent)) {
                $message = 'Event updated successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error updating event.';
                $messageType = 'error';
            }
        }
    }
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    if (deleteItem('events', $_GET['id'])) {
        $message = 'Event deleted successfully!';
        $messageType = 'success';
    } else {
        $message = 'Error deleting event.';
        $messageType = 'error';
    }
}

$events = loadData('events');
// Sort by date (newest first)
usort($events, function($a, $b) {
    return strtotime($b['date'] ?? '') - strtotime($a['date'] ?? '');
});

$editingEvent = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $editingEvent = getItem('events', $_GET['id']);
}

$showForm = isset($_GET['action']) && ($_GET['action'] === 'add' || $editingEvent);
?>

<h1>Manage Events</h1>

<?php if ($message): ?>
    <div class="alert <?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if ($showForm): ?>
    <section class="admin-form-section">
        <h2><?php echo $editingEvent ? 'Edit Event' : 'Add New Event'; ?></h2>
        <form method="post" class="form">
            <input type="hidden" name="action" value="<?php echo $editingEvent ? 'edit' : 'add'; ?>">
            <?php if ($editingEvent): ?>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($editingEvent['id']); ?>">
            <?php endif; ?>
            
            <div class="form-row">
                <label for="title">Event Title *</label>
                <input type="text" id="title" name="title" 
                       value="<?php echo htmlspecialchars($editingEvent['title'] ?? ''); ?>" required>
            </div>
            
            <div class="form-row">
                <label for="date">Date *</label>
                <div class="date-input-wrapper">
                    <input type="date" id="date" name="date" 
                           value="<?php echo htmlspecialchars($editingEvent['date'] ?? ''); ?>" required>
                    <span class="date-icon">📅</span>
                </div>
            </div>
            
            <div class="form-row">
                <label for="time">Time *</label>
                <input type="text" id="time" name="time" placeholder="e.g., 10:00 AM" 
                       value="<?php echo htmlspecialchars($editingEvent['time'] ?? ''); ?>" required>
            </div>
            
            <div class="form-row">
                <label for="location">Location *</label>
                <input type="text" id="location" name="location" 
                       value="<?php echo htmlspecialchars($editingEvent['location'] ?? ''); ?>" required>
            </div>
            
            <div class="form-row">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($editingEvent['description'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-row">
                <button type="submit" class="btn btn-primary"><?php echo $editingEvent ? 'Update Event' : 'Add Event'; ?></button>
                <a href="events.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </section>
<?php else: ?>
    <div class="admin-actions-bar">
        <a href="events.php?action=add" class="btn btn-primary">➕ Add New Event</a>
    </div>
<?php endif; ?>

<section class="admin-section">
    <h2>All Events (<?php echo count($events); ?>)</h2>
    
    <?php if (empty($events)): ?>
        <p>No events yet. <a href="events.php?action=add">Add your first event</a>.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($event['title']); ?></strong></td>
                        <td><?php echo htmlspecialchars($event['date'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($event['time'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($event['location'] ?? ''); ?></td>
                        <td class="admin-actions-cell">
                            <a href="events.php?action=edit&id=<?php echo htmlspecialchars($event['id']); ?>" class="btn btn-outline btn-small">Edit</a>
                            <a href="events.php?action=delete&id=<?php echo htmlspecialchars($event['id']); ?>" 
                               class="btn btn-outline btn-small btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

