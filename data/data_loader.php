<?php
// Data loader for public pages - uses JSON files managed by admin
// Falls back to sample_data.php if JSON files don't exist yet

function loadPublicData($type) {
    $jsonFile = __DIR__ . '/' . $type . '.json';
    
    if (file_exists($jsonFile)) {
        $content = file_get_contents($jsonFile);
        $data = json_decode($content, true);
        if ($data) {
            return $data;
        }
    }
    
    // Fallback to sample data
    require_once __DIR__ . '/sample_data.php';
    
    $dataMap = [
        'events' => $events ?? [],
        'sermons' => $sermons ?? [],
        'ministries' => $ministries ?? []
    ];
    
    return $dataMap[$type] ?? [];
}

// Load all data for convenience
$events = loadPublicData('events');
$sermons = loadPublicData('sermons');
$ministries = loadPublicData('ministries');

