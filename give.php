<?php
$pageTitle   = 'Give | CFAG Church';
$currentPage = 'give';

require __DIR__ . '/includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Give</h1>
        <p>Your generosity fuels the mission of CFAG Church.</p>
    </div>
</section>

<section class="section">
    <div class="container two-column">
        <div>
            <h2>Why We Give</h2>
            <p>
                Giving is an act of worship and trust. When we give, we recognize that everything
                we have comes from God and is for His purposes.
            </p>
            <p>
                Your generosity helps support local ministry, outreach to our city, and missions
                around the world.
            </p>
        </div>
        <div>
            <h2>Ways to Give</h2>
            <ul class="bulleted">
                <li><strong>In Person</strong> &mdash; Give during any of our worship services.</li>
                <li><strong>Online</strong> &mdash; Use the secure giving option below.</li>
                <li><strong>Mail</strong> &mdash; Send gifts to our church office.</li>
            </ul>
        </div>
    </div>
</section>

<section class="section alt">
    <div class="container">
        <h2>Online Giving</h2>
        <p class="small">
            This is a demo layout. In a real site, you would integrate with a payment provider
            such as Stripe, PayPal, Tithe.ly, or your church management system.
        </p>

        <form class="form give-form">
            <div class="form-row">
                <label for="give-amount">Amount</label>
                <div class="amount-input">
                    <span class="currency">₱</span>
                    <input type="number" id="give-amount" min="1" step="1" value="50">
                </div>
            </div>
            <div class="form-row">
                <label>Frequency</label>
                <div class="radio-group">
                    <label><input type="radio" name="frequency" value="once" checked> One-time</label>
                    <label><input type="radio" name="frequency" value="weekly"> Weekly</label>
                    <label><input type="radio" name="frequency" value="monthly"> Monthly</label>
                </div>
            </div>
            <div class="form-row">
                <button type="button" class="btn btn-primary" id="btn-give-demo">
                    Continue to Secure Giving
                </button>
            </div>
            <p class="small">
                Clicking this button in the demo will simply show a message. Replace this
                section with your payment provider’s embed or redirect.
            </p>
        </form>

        <div id="give-demo-message" class="alert info hidden">
            This is a demo only. Connect this button to your real online giving platform.
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>


