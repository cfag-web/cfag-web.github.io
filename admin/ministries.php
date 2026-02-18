<?php
$pageTitle = 'Manage Ministries';
$currentPage = 'ministries';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/data_manager.php';

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'add') {
            $newMinistry = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'leader' => trim($_POST['leader'] ?? ''),
                'contact' => trim($_POST['contact'] ?? ''),
                'schedule' => trim($_POST['schedule'] ?? '')
            ];
            
            if (addItem('ministries', $newMinistry)) {
                $message = 'Ministry added successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error adding ministry.';
                $messageType = 'error';
            }
        } elseif ($action === 'edit') {
            $id = $_POST['id'] ?? '';
            $updatedMinistry = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'leader' => trim($_POST['leader'] ?? ''),
                'contact' => trim($_POST['contact'] ?? ''),
                'schedule' => trim($_POST['schedule'] ?? '')
            ];
            
            if (updateItem('ministries', $id, $updatedMinistry)) {
                $message = 'Ministry updated successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error updating ministry.';
                $messageType = 'error';
            }
        }
    }
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    if (deleteItem('ministries', $_GET['id'])) {
        $message = 'Ministry deleted successfully!';
        $messageType = 'success';
    } else {
        $message = 'Error deleting ministry.';
        $messageType = 'error';
    }
}

$ministries = loadData('ministries');

$editingMinistry = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $editingMinistry = getItem('ministries', $_GET['id']);
}

$showForm = isset($_GET['action']) && ($_GET['action'] === 'add' || $editingMinistry);
?>

<h1>Manage Ministries</h1>

<?php if ($message): ?>
    <div class="alert <?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if ($showForm): ?>
    <section class="admin-form-section">
        <h2><?php echo $editingMinistry ? 'Edit Ministry' : 'Add New Ministry'; ?></h2>
        <form method="post" class="form">
            <input type="hidden" name="action" value="<?php echo $editingMinistry ? 'edit' : 'add'; ?>">
            <?php if ($editingMinistry): ?>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($editingMinistry['id']); ?>">
            <?php endif; ?>
            
            <div class="form-row">
                <label for="name">Ministry Name *</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo htmlspecialchars($editingMinistry['name'] ?? ''); ?>" required>
            </div>
            
            <div class="form-row">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($editingMinistry['description'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-row">
                <label for="leader">Leader Name *</label>
                <input type="text" id="leader" name="leader" 
                       value="<?php echo htmlspecialchars($editingMinistry['leader'] ?? ''); ?>" required>
            </div>
            
            <div class="form-row">
                <label for="contact">Contact Email *</label>
                <input type="email" id="contact" name="contact" 
                       value="<?php echo htmlspecialchars($editingMinistry['contact'] ?? ''); ?>" required>
            </div>
            
            <div class="form-row">
                <label for="schedule">Schedule *</label>
                <input type="text" id="schedule" name="schedule" 
                       value="<?php echo htmlspecialchars($editingMinistry['schedule'] ?? ''); ?>"
                       placeholder="e.g., Fridays at 7:00 PM" required>
            </div>
            
            <div class="form-row">
                <button type="submit" class="btn btn-primary"><?php echo $editingMinistry ? 'Update Ministry' : 'Add Ministry'; ?></button>
                <a href="ministries.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </section>
<?php else: ?>
    <div class="admin-actions-bar">
        <a href="ministries.php?action=add" class="btn btn-primary">➕ Add New Ministry</a>
    </div>
<?php endif; ?>

<section class="admin-section">
    <h2>All Ministries (<?php echo count($ministries); ?>)</h2>
    
    <?php if (empty($ministries)): ?>
        <p>No ministries yet. <a href="ministries.php?action=add">Add your first ministry</a>.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Leader</th>
                    <th>Contact</th>
                    <th>Schedule</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ministries as $ministry): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($ministry['name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($ministry['leader'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($ministry['contact'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($ministry['schedule'] ?? ''); ?></td>
                        <td class="admin-actions-cell">
                            <a href="ministries.php?action=edit&id=<?php echo htmlspecialchars($ministry['id']); ?>" class="btn btn-outline btn-small">Edit</a>
                            <a href="ministries.php?action=delete&id=<?php echo htmlspecialchars($ministry['id']); ?>" 
                               class="btn btn-outline btn-small btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this ministry?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

