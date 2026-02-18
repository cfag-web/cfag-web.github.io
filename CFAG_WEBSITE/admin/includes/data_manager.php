<?php
// Data management functions for events, sermons, and ministries
// Uses JSON files for storage (easily replaceable with database)

define('DATA_DIR', __DIR__ . '/../../data/');
define('UPLOADS_DIR', __DIR__ . '/../../uploads/');
define('SERMON_UPLOADS_DIR', UPLOADS_DIR . 'sermons/');

function getDataFile($type) {
    $files = [
        'events' => DATA_DIR . 'events.json',
        'sermons' => DATA_DIR . 'sermons.json',
        'ministries' => DATA_DIR . 'ministries.json'
    ];
    return $files[$type] ?? null;
}

function loadData($type) {
    $file = getDataFile($type);
    if (!$file || !file_exists($file)) {
        // Initialize with empty array if file doesn't exist
        return [];
    }
    $content = file_get_contents($file);
    $data = json_decode($content, true);
    return $data ?: [];
}

function saveData($type, $data) {
    $file = getDataFile($type);
    if (!$file) {
        return false;
    }
    
    // Ensure data directory exists
    $dir = dirname($file);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT)) !== false;
}

function addItem($type, $item) {
    $data = loadData($type);
    // Add ID if not present
    if (!isset($item['id'])) {
        $item['id'] = uniqid();
    }
    $data[] = $item;
    return saveData($type, $data) ? $item['id'] : false;
}

function updateItem($type, $id, $updatedItem) {
    $data = loadData($type);
    foreach ($data as $key => $item) {
        if (isset($item['id']) && $item['id'] === $id) {
            $updatedItem['id'] = $id; // Preserve ID
            $data[$key] = $updatedItem;
            return saveData($type, $data);
        }
    }
    return false;
}

function deleteItem($type, $id) {
    $data = loadData($type);
    foreach ($data as $key => $item) {
        if (isset($item['id']) && $item['id'] === $id) {
            unset($data[$key]);
            $data = array_values($data); // Re-index array
            return saveData($type, $data);
        }
    }
    return false;
}

function getItem($type, $id) {
    $data = loadData($type);
    foreach ($data as $item) {
        if (isset($item['id']) && $item['id'] === $id) {
            return $item;
        }
    }
    return null;
}

// Initialize data files from sample_data.php if they don't exist
function initializeDataFiles() {
    require_once __DIR__ . '/../../data/sample_data.php';
    
    if (!file_exists(getDataFile('events'))) {
        // Add IDs to sample events
        $eventsWithIds = array_map(function($event) {
            $event['id'] = uniqid();
            return $event;
        }, $events);
        saveData('events', $eventsWithIds);
    }
    
    if (!file_exists(getDataFile('sermons'))) {
        $sermonsWithIds = array_map(function($sermon) {
            $sermon['id'] = uniqid();
            return $sermon;
        }, $sermons);
        saveData('sermons', $sermonsWithIds);
    }
    
    if (!file_exists(getDataFile('ministries'))) {
        $ministriesWithIds = array_map(function($ministry) {
            $ministry['id'] = uniqid();
            return $ministry;
        }, $ministries);
        saveData('ministries', $ministriesWithIds);
    }
}

// File upload functions for sermon media
function uploadSermonMedia($file, $sermonId = null) {
    // Ensure uploads directory exists
    if (!is_dir(SERMON_UPLOADS_DIR)) {
        mkdir(SERMON_UPLOADS_DIR, 0755, true);
    }
    
    // Check if file was uploaded
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return null;
    }
    
    // Validate file
    $allowedTypes = [
        'video/mp4', 'video/webm', 'video/ogg', 'video/quicktime',
        'audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg',
        'application/vnd.ms-powerpoint', // .ppt
        'application/vnd.openxmlformats-officedocument.presentationml.presentation', // .pptx
        'application/powerpoint', // Alternative MIME type
        'application/x-mspowerpoint' // Alternative MIME type
    ];
    $allowedExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi', 'mp3', 'wav', 'm4a', 'ppt', 'pptx'];
    $maxSize = 500 * 1024 * 1024; // 500MB
    
    if ($file['size'] > $maxSize) {
        return ['error' => 'File size exceeds maximum allowed size (500MB)'];
    }
    
    // Check file extension first
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions)) {
        return ['error' => 'Invalid file type. Allowed: MP4, WebM, OGG, MP3, WAV, PPT, PPTX'];
    }
    
    // Validate MIME type (but be lenient for PowerPoint as MIME types can vary)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    // For PowerPoint files, accept if extension is correct even if MIME type doesn't match exactly
    if (in_array($extension, ['ppt', 'pptx'])) {
        // Accept PowerPoint files by extension
    } elseif (!in_array($mimeType, $allowedTypes)) {
        return ['error' => 'Invalid file type. Allowed: MP4, WebM, OGG, MP3, WAV, PPT, PPTX'];
    }
    
    // Preserve original filename but make it safe and unique
    $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    
    // Sanitize filename - remove dangerous characters
    $originalName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
    $originalName = trim($originalName, '_');
    
    // If filename is empty after sanitization, use a default
    if (empty($originalName)) {
        $originalName = 'sermon_file';
    }
    
    // Add sermon ID prefix if available to keep files organized
    $prefix = $sermonId ? $sermonId . '_' : '';
    
    // Check if file already exists, if so add a number suffix
    $filename = $prefix . $originalName . '.' . $extension;
    $targetPath = SERMON_UPLOADS_DIR . $filename;
    $counter = 1;
    
    while (file_exists($targetPath)) {
        $filename = $prefix . $originalName . '_' . $counter . '.' . $extension;
        $targetPath = SERMON_UPLOADS_DIR . $filename;
        $counter++;
    }
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Return relative path from website root
        return 'uploads/sermons/' . $filename;
    }
    
    return ['error' => 'Failed to upload file'];
}

function deleteSermonMedia($filePath) {
    if ($filePath && strpos($filePath, 'uploads/sermons/') === 0) {
        $fullPath = __DIR__ . '/../../' . $filePath;
        if (file_exists($fullPath)) {
            unlink($fullPath);
            return true;
        }
    }
    return false;
}

// Auto-initialize on first load
initializeDataFiles();

