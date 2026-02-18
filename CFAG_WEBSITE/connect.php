<?php
$pageTitle   = 'Connect | CFAG Church';
$currentPage = 'connect';

require __DIR__ . '/includes/header.php';

$contactSuccess = false;
$contactErrors  = [];
$newsletterSuccess = false;
$newsletterErrors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['contact_form'])) {
        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name === '') {
            $contactErrors[] = 'Please enter your name.';
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $contactErrors[] = 'Please enter a valid email address.';
        }
        if ($message === '') {
            $contactErrors[] = 'Please enter a message.';
        }

        if (empty($contactErrors)) {
            // Here you could send an email or save the message to a database.
            $contactSuccess = true;
        }
    } elseif (isset($_POST['newsletter_form'])) {
        $email = trim($_POST['newsletter_email'] ?? '');

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $newsletterErrors[] = 'Please enter a valid email address.';
        }

        if (empty($newsletterErrors)) {
            // Store newsletter signup in the database in a real application.
            $newsletterSuccess = true;
        }
    }
}
?>

<section class="page-header" id="plan-visit">
    <div class="container">
        <h1>Connect &amp; Plan a Visit</h1>
        <p>We’d love to meet you and help you take your next step.</p>
    </div>
</section>

<section class="section">
    <div class="container two-column">
        <div>
            <h2>Plan Your Visit</h2>
            <p>
                Visiting a new church can feel overwhelming. Our team is here to welcome you,
                help you find your way around, and answer any questions you may have.
            </p>
            <ul class="bulleted">
                <li>Designated guest parking</li>
                <li>Friendly greeters ready to help</li>
                <li>Safe, secure kids check-in</li>
            </ul>
            <p>
                Fill out the form and let us know when you’re coming—we’ll be ready for you!
            </p>
        </div>
        <div>
            <h2>Contact Form</h2>

            <?php if ($contactSuccess): ?>
                <div class="alert success">
                    Thank you for reaching out! We will get back to you soon.
                </div>
            <?php elseif (!empty($contactErrors)): ?>
                <div class="alert error">
                    <ul>
                        <?php foreach ($contactErrors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" class="form">
                <input type="hidden" name="contact_form" value="1">
                <div class="form-row">
                    <label for="contact-name">Name</label>
                    <input type="text" id="contact-name" name="name"
                           value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                </div>
                <div class="form-row">
                    <label for="contact-email">Email</label>
                    <input type="email" id="contact-email" name="email"
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                </div>
                <div class="form-row">
                    <label for="contact-message">Message</label>
                    <textarea id="contact-message" name="message" rows="4" required><?php
                        echo htmlspecialchars($_POST['message'] ?? '');
                        ?></textarea>
                </div>
                <div class="form-row">
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="section alt">
    <div class="container two-column">
        <div>
            <h2>Stay Connected</h2>
            <p>
                Follow us on social media or subscribe to our newsletter to stay up to date
                with what’s happening at CFAG Church.
            </p>
            <p class="social-links">
                <a href="https://facebook.com" target="_blank" rel="noopener">Facebook</a>
                <a href="https://instagram.com" target="_blank" rel="noopener">Instagram</a>
                <a href="https://youtube.com" target="_blank" rel="noopener">YouTube</a>
            </p>
        </div>
        <div>
            <h2>Newsletter Signup</h2>

            <?php if ($newsletterSuccess): ?>
                <div class="alert success">
                    Thanks for subscribing to our newsletter!
                </div>
            <?php elseif (!empty($newsletterErrors)): ?>
                <div class="alert error">
                    <ul>
                        <?php foreach ($newsletterErrors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" class="form inline-form">
                <input type="hidden" name="newsletter_form" value="1">
                <div class="form-row">
                    <label for="newsletter-email" class="visually-hidden">Email</label>
                    <input type="email" id="newsletter-email" name="newsletter_email"
                           placeholder="Your email address"
                           value="<?php echo htmlspecialchars($_POST['newsletter_email'] ?? ''); ?>" required>
                    <button type="submit" class="btn btn-outline">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>


