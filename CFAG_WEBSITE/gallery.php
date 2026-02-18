<?php
$pageTitle   = 'Gallery | CFAG Church';
$currentPage = 'gallery';

require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Gallery</h1>
        <p>Snapshots of what God is doing in and through our church family.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="gallery-grid" id="gallery">
            <!-- Replace the image paths with your own church photos -->
            <a href="assets/images/gallery1.jpg" class="gallery-item" data-lightbox="gallery">
                <img src="assets/images/gallery1_thumb.jpg" alt="Worship service">
            </a>
            <a href="assets/images/gallery2.jpg" class="gallery-item" data-lightbox="gallery">
                <img src="assets/images/gallery2_thumb.jpg" alt="Kids ministry">
            </a>
            <a href="assets/images/gallery3.jpg" class="gallery-item" data-lightbox="gallery">
                <img src="assets/images/gallery3_thumb.jpg" alt="Youth gathering">
            </a>
            <a href="assets/images/gallery4.jpg" class="gallery-item" data-lightbox="gallery">
                <img src="assets/images/gallery4_thumb.jpg" alt="Community outreach">
            </a>
            <a href="assets/images/gallery5.jpg" class="gallery-item" data-lightbox="gallery">
                <img src="assets/images/gallery5_thumb.jpg" alt="Prayer night">
            </a>
            <a href="assets/images/gallery6.jpg" class="gallery-item" data-lightbox="gallery">
                <img src="assets/images/gallery6_thumb.jpg" alt="Church picnic">
            </a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>


