<?php
$pageTitle = 'Manage Sermons';
$currentPage = 'sermons';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/data_manager.php';

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'add') {
            $newSermon = [
                'title' => trim($_POST['title'] ?? ''),
                'speaker' => trim($_POST['speaker'] ?? ''),
                'date' => trim($_POST['date'] ?? ''),
                'series' => trim($_POST['series'] ?? ''),
                'summary' => trim($_POST['summary'] ?? ''),
                'video_url' => trim($_POST['video_url'] ?? ''),
                'media_file' => ''
            ];
            
            // Handle file upload
            if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = uploadSermonMedia($_FILES['media_file']);
                if (isset($uploadResult['error'])) {
                    $message = 'Upload error: ' . $uploadResult['error'];
                    $messageType = 'error';
                } else {
                    $newSermon['media_file'] = $uploadResult;
                }
            }
            
            if (empty($message)) {
                if (addItem('sermons', $newSermon)) {
                    $message = 'Sermon added successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error adding sermon.';
                    $messageType = 'error';
                }
            }
        } elseif ($action === 'edit') {
            $id = $_POST['id'] ?? '';
            $existingSermon = getItem('sermons', $id);
            $updatedSermon = [
                'title' => trim($_POST['title'] ?? ''),
                'speaker' => trim($_POST['speaker'] ?? ''),
                'date' => trim($_POST['date'] ?? ''),
                'series' => trim($_POST['series'] ?? ''),
                'summary' => trim($_POST['summary'] ?? ''),
                'video_url' => trim($_POST['video_url'] ?? ''),
                'media_file' => $existingSermon['media_file'] ?? ''
            ];
            
            // Handle file upload
            if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {
                // Delete old file if exists
                if (!empty($existingSermon['media_file'])) {
                    deleteSermonMedia($existingSermon['media_file']);
                }
                
                $uploadResult = uploadSermonMedia($_FILES['media_file'], $id);
                if (isset($uploadResult['error'])) {
                    $message = 'Upload error: ' . $uploadResult['error'];
                    $messageType = 'error';
                } else {
                    $updatedSermon['media_file'] = $uploadResult;
                }
            } elseif (isset($_POST['remove_media']) && $_POST['remove_media'] === '1') {
                // Remove media file if requested
                if (!empty($existingSermon['media_file'])) {
                    deleteSermonMedia($existingSermon['media_file']);
                }
                $updatedSermon['media_file'] = '';
            }
            
            if (empty($message)) {
                if (updateItem('sermons', $id, $updatedSermon)) {
                    $message = 'Sermon updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating sermon.';
                    $messageType = 'error';
                }
            }
        }
    }
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $sermonToDelete = getItem('sermons', $_GET['id']);
    if ($sermonToDelete && deleteItem('sermons', $_GET['id'])) {
        // Delete associated media file
        if (!empty($sermonToDelete['media_file'])) {
            deleteSermonMedia($sermonToDelete['media_file']);
        }
        $message = 'Sermon deleted successfully!';
        $messageType = 'success';
    } else {
        $message = 'Error deleting sermon.';
        $messageType = 'error';
    }
}

$sermons = loadData('sermons');
// Sort by date (newest first)
usort($sermons, function($a, $b) {
    return strtotime($b['date'] ?? '') - strtotime($a['date'] ?? '');
});

$editingSermon = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $editingSermon = getItem('sermons', $_GET['id']);
}

$showForm = isset($_GET['action']) && ($_GET['action'] === 'add' || $editingSermon);
?>

<h1>Manage Sermons</h1>

<?php if ($message): ?>
    <div class="alert <?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if ($showForm): ?>
    <section class="admin-form-section">
        <h2><?php echo $editingSermon ? 'Edit Sermon' : 'Add New Sermon'; ?></h2>
        <form method="post" class="form" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?php echo $editingSermon ? 'edit' : 'add'; ?>">
            <?php if ($editingSermon): ?>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($editingSermon['id']); ?>">
            <?php endif; ?>
            
            <div class="form-row">
                <label for="title">Sermon Title *</label>
                <input type="text" id="title" name="title" 
                       value="<?php echo htmlspecialchars($editingSermon['title'] ?? ''); ?>" required>
            </div>
            
            <div class="form-row">
                <label for="speaker">Speaker *</label>
                <input type="text" id="speaker" name="speaker" 
                       value="<?php echo htmlspecialchars($editingSermon['speaker'] ?? ''); ?>" required>
            </div>
            
            <div class="form-row">
                <label for="date">Date *</label>
                <div class="date-input-wrapper">
                    <input type="date" id="date" name="date" 
                           value="<?php echo htmlspecialchars($editingSermon['date'] ?? ''); ?>" required>
                    <span class="date-icon">📅</span>
                </div>
            </div>
            
            <div class="form-row">
                <label for="series">Series</label>
                <input type="text" id="series" name="series" 
                       value="<?php echo htmlspecialchars($editingSermon['series'] ?? ''); ?>">
            </div>
            
            <div class="form-row">
                <label for="summary">Summary *</label>
                <textarea id="summary" name="summary" rows="3" required><?php echo htmlspecialchars($editingSermon['summary'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-row">
                <label for="video_url">Video URL (embed URL)</label>
                <input type="url" id="video_url" name="video_url" 
                       value="<?php echo htmlspecialchars($editingSermon['video_url'] ?? ''); ?>"
                       placeholder="https://player.vimeo.com/video/123456789">
                <small>Or upload a video/audio file below</small>
            </div>
            
            <div class="form-row">
                <label for="media_file">Upload Video/Audio File</label>
                <input type="file" id="media_file" name="media_file" 
                       accept="video/*,audio/*">
                <small>Supported formats: MP4, WebM, OGG, MP3, WAV (Max: 500MB)</small>
                <?php if ($editingSermon && !empty($editingSermon['media_file'])): ?>
                    <div style="margin-top: 10px;">
                        <p><strong>Current file:</strong> <?php echo htmlspecialchars(basename($editingSermon['media_file'])); ?></p>
                        <label style="display: flex; align-items: center; gap: 5px; margin-top: 5px;">
                            <input type="checkbox" name="remove_media" value="1">
                            <span>Remove current media file</span>
                        </label>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="form-row">
                <button type="submit" class="btn btn-primary"><?php echo $editingSermon ? 'Update Sermon' : 'Add Sermon'; ?></button>
                <a href="sermons.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </section>
<?php else: ?>
    <div class="admin-actions-bar">
        <a href="sermons.php?action=add" class="btn btn-primary">➕ Add New Sermon</a>
    </div>
<?php endif; ?>

<section class="admin-section">
    <h2>All Sermons (<?php echo count($sermons); ?>)</h2>
    
    <?php if (empty($sermons)): ?>
        <p>No sermons yet. <a href="sermons.php?action=add">Add your first sermon</a>.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Speaker</th>
                    <th>Date</th>
                    <th>Series</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sermons as $sermon): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($sermon['title']); ?></strong></td>
                        <td><?php echo htmlspecialchars($sermon['speaker'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($sermon['date'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($sermon['series'] ?? ''); ?></td>
                        <td class="admin-actions-cell">
                            <a href="sermons.php?action=edit&id=<?php echo htmlspecialchars($sermon['id']); ?>" class="btn btn-outline btn-small">Edit</a>
                            <a href="sermons.php?action=delete&id=<?php echo htmlspecialchars($sermon['id']); ?>" 
                               class="btn btn-outline btn-small btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this sermon?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

