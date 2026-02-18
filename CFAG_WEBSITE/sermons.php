<?php
$pageTitle   = 'Sermons | CFAG Church';
$currentPage = 'sermons';

require __DIR__ . '/includes/header.php';
require __DIR__ . '/data/data_loader.php';

// Build simple lists for filters
$seriesList = array_unique(array_map(function ($s) {
    return $s['series'];
}, $sermons));
sort($seriesList);

$speakerList = array_unique(array_map(function ($s) {
    return $s['speaker'];
}, $sermons));
sort($speakerList);
?>

<section class="page-header">
    <div class="container">
        <h1>Sermons</h1>
        <p>Watch or listen to recent messages from CFAG Church.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <form class="filters" id="sermon-filters">
            <div class="filter-group">
                <label for="filter-series">Series</label>
                <select id="filter-series">
                    <option value="">All series</option>
                    <?php foreach ($seriesList as $series): ?>
                        <option value="<?php echo htmlspecialchars($series); ?>">
                            <?php echo htmlspecialchars($series); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="filter-speaker">Speaker</label>
                <select id="filter-speaker">
                    <option value="">All speakers</option>
                    <?php foreach ($speakerList as $speaker): ?>
                        <option value="<?php echo htmlspecialchars($speaker); ?>">
                            <?php echo htmlspecialchars($speaker); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <div class="card-grid two" id="sermon-list">
            <?php foreach ($sermons as $sermon): ?>
                <article class="card sermon"
                         data-series="<?php echo htmlspecialchars($sermon['series']); ?>"
                         data-speaker="<?php echo htmlspecialchars($sermon['speaker']); ?>">
                    <h2><?php echo htmlspecialchars($sermon['title']); ?></h2>
                    <p class="meta">
                        <?php echo htmlspecialchars($sermon['date']); ?>
                        &middot;
                        <?php echo htmlspecialchars($sermon['speaker']); ?>
                    </p>
                    <p class="meta meta-series"><?php echo htmlspecialchars($sermon['series']); ?></p>
                    <p><?php echo htmlspecialchars($sermon['summary']); ?></p>

                    <div class="sermon-media">
                        <?php if (!empty($sermon['media_file'])): ?>
                            <!-- Uploaded video/audio/PowerPoint file -->
                            <?php 
                            $filePath = htmlspecialchars($sermon['media_file']);
                            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                            $isVideo = in_array($fileExtension, ['mp4', 'webm', 'ogg', 'mov', 'avi']);
                            $isAudio = in_array($fileExtension, ['mp3', 'wav', 'ogg', 'm4a']);
                            $isPowerPoint = in_array($fileExtension, ['ppt', 'pptx']);
                            
                            // Get full URL for PowerPoint viewer
                            if ($isPowerPoint) {
                                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                                $host = $_SERVER['HTTP_HOST'];
                                $baseUrl = $protocol . '://' . $host;
                                $fullFilePath = $baseUrl . '/' . $filePath;
                                $officeViewerUrl = 'https://view.officeapps.live.com/op/embed.aspx?src=' . urlencode($fullFilePath);
                            }
                            ?>
                            <?php if ($isVideo): ?>
                                <video controls autoplay style="width: 100%; max-width: 100%; height: auto;">
                                    <source src="<?php echo $filePath; ?>" type="video/<?php echo $fileExtension === 'mov' ? 'quicktime' : $fileExtension; ?>">
                                    Your browser does not support the video tag.
                                </video>
                            <?php elseif ($isAudio): ?>
                                <audio controls autoplay style="width: 100%;">
                                    <source src="<?php echo $filePath; ?>" type="audio/<?php echo $fileExtension === 'm4a' ? 'mpeg' : $fileExtension; ?>">
                                    Your browser does not support the audio tag.
                                </audio>
                            <?php elseif ($isPowerPoint): ?>
                                <div class="powerpoint-viewer">
                                    <?php 
                                    // Check if we're on localhost - Office Online viewer won't work
                                    $isLocalhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']) || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;
                                    
                                    if ($isLocalhost): 
                                        // Show a nice preview card for localhost
                                    ?>
                                        <div class="powerpoint-preview" style="padding: 3rem 2rem; text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white;">
                                            <div style="font-size: 4rem; margin-bottom: 1rem;">📊</div>
                                            <h3 style="margin: 0 0 0.5rem; font-size: 1.5rem;">PowerPoint Presentation</h3>
                                            <p style="margin: 0 0 2rem; opacity: 0.9; font-size: 0.95rem;"><?php echo htmlspecialchars(basename($filePath)); ?></p>
                                            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                                                <a href="<?php echo $filePath; ?>" class="btn btn-outline" download style="background: rgba(255,255,255,0.2); border-color: white; color: white; padding: 0.75rem 1.5rem;">
                                                    Download to View
                                                </a>
                                                <a href="<?php echo $filePath; ?>" target="_blank" class="btn btn-outline" style="background: rgba(255,255,255,0.2); border-color: white; color: white; padding: 0.75rem 1.5rem;">
                                                    Open in New Tab
                                                </a>
                                            </div>
                                        </div>
                                    <?php else: 
                                        // Try Office Online viewer for public servers
                                    ?>
                                        <iframe src="<?php echo htmlspecialchars($officeViewerUrl); ?>" 
                                                frameborder="0" 
                                                allowfullscreen
                                                style="width: 100%; height: 600px; border-radius: 12px;"
                                                title="PowerPoint Presentation"
                                                id="ppt-iframe-<?php echo htmlspecialchars($sermon['id'] ?? ''); ?>">
                                        </iframe>
                                        <div id="ppt-fallback-<?php echo htmlspecialchars($sermon['id'] ?? ''); ?>" style="display: none; padding: 3rem 2rem; text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white; margin-top: 1rem;">
                                            <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
                                            <h3 style="margin: 0 0 0.5rem;">Viewer Unavailable</h3>
                                            <p style="margin: 0 0 2rem; opacity: 0.9;">Please download the file to view it.</p>
                                            <a href="<?php echo $filePath; ?>" class="btn btn-outline" download style="background: rgba(255,255,255,0.2); border-color: white; color: white; padding: 0.75rem 1.5rem;">
                                                Download PowerPoint
                                            </a>
                                        </div>
                                        <script>
                                            // Detect if Office Online viewer failed to load
                                            (function() {
                                                var iframe = document.getElementById('ppt-iframe-<?php echo htmlspecialchars($sermon['id'] ?? ''); ?>');
                                                var fallback = document.getElementById('ppt-fallback-<?php echo htmlspecialchars($sermon['id'] ?? ''); ?>');
                                                
                                                if (iframe && fallback) {
                                                    var errorDetected = false;
                                                    
                                                    // Check for error after iframe loads
                                                    iframe.onload = function() {
                                                        setTimeout(function() {
                                                            try {
                                                                // Try to detect error message in iframe
                                                                var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                                                                var bodyText = iframeDoc.body ? iframeDoc.body.innerText || iframeDoc.body.textContent : '';
                                                                
                                                                // Check for Office Online error messages
                                                                if (bodyText.includes('error occurred') || 
                                                                    bodyText.includes("can't open this") ||
                                                                    bodyText.includes('We\'re sorry')) {
                                                                    errorDetected = true;
                                                                    iframe.style.display = 'none';
                                                                    fallback.style.display = 'block';
                                                                }
                                                            } catch(e) {
                                                                // Cross-origin - can't check, but iframe might still work
                                                                // Check if iframe is showing an error by checking its dimensions
                                                                setTimeout(function() {
                                                                    if (!errorDetected && iframe.offsetHeight < 100) {
                                                                        iframe.style.display = 'none';
                                                                        fallback.style.display = 'block';
                                                                    }
                                                                }, 2000);
                                                            }
                                                        }, 3000);
                                                    };
                                                    
                                                    // Also check on error event
                                                    iframe.onerror = function() {
                                                        iframe.style.display = 'none';
                                                        fallback.style.display = 'block';
                                                    };
                                                }
                                            })();
                                        </script>
                                    <?php endif; ?>
                                    
                                    <div style="margin-top: 10px; display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                                        <a href="<?php echo $filePath; ?>" class="btn btn-outline btn-small" download>Download PowerPoint</a>
                                        <span style="font-size: 0.85rem; color: #999;">Click to download and view in PowerPoint</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="<?php echo $filePath; ?>" class="btn btn-outline" download>Download Media File</a>
                            <?php endif; ?>
                        <?php elseif (!empty($sermon['video_url'])): ?>
                            <!-- Embedded video URL -->
                            <iframe src="<?php echo htmlspecialchars($sermon['video_url']); ?>"
                                    frameborder="0" allow="autoplay; fullscreen" allowfullscreen
                                    title="Sermon video"></iframe>
                        <?php else: ?>
                            <p style="color: #999; font-style: italic;">No media available for this sermon.</p>
                        <?php endif; ?>
                    </div>

                    <div class="sermon-actions">
                        <a href="#" class="btn btn-outline btn-small disabled">Download audio (coming soon)</a>
                        <a href="#" class="link-arrow disabled">Download transcript (optional)</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>


