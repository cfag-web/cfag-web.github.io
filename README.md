# CFAG Church Website (PHP)

This is a simple multi-page church website built with **PHP**, **CSS**, and **JavaScript**.  
It is designed to run easily on XAMPP and to be extended later with a real database and payment provider.

## Pages Included

- **Home (`index.php`)**: Hero banner, mission, upcoming events, and latest sermons.
- **About (`about.php`)**: Mission, vision, beliefs, leadership, and church story.
- **Services & Schedule (`services.php`)**: Weekly services, what to expect, map/directions, live stream info.
- **Sermons (`sermons.php`)**: Sermon archive with basic filters by series and speaker.
- **Events (`events.php`)**: Upcoming events list, simple calendar, and RSVP form.
- **Ministries (`ministries.php`)**: Overview of ministries with description, contact, and schedule.
- **Connect / Plan a Visit (`connect.php`)**: Contact form and newsletter signup.
- **Give (`give.php`)**: Giving information and a demo online giving UI (hook this into your real provider).
- **Gallery (`gallery.php`)**: Image gallery with a JavaScript lightbox.

All pages share a common header and footer via `includes/header.php` and `includes/footer.php`.

## Getting Started on XAMPP

1. **Copy the project** into your XAMPP `htdocs` folder, e.g.:
   - `C:\xampp\htdocs\CFAG_WEBSITE`
2. Start **Apache** in the XAMPP control panel.
3. Open your browser and navigate to:
   - `http://localhost/CFAG_WEBSITE/`

You should see the home page and can browse to the other pages via the navigation bar.

## Sample Data and Where to Plug In a Database

For now, sermons, events, and ministries use static sample data in:

- `data/sample_data.php`

To connect to a real database (MySQL, etc.):

- Replace the arrays in `sample_data.php` with database queries.
- Or create a new `db.php` file to hold your connection and query logic, and `require` it where needed.

## Forms

- **Contact form** (`connect.php`): Validates basic fields and shows success/error messages.
- **Newsletter signup** (`connect.php`): Validates email and simulates a signup.
- **Event RSVP** (`events.php`): Validates name/email/event and shows a success message.

These forms are ready for you to hook into:

- Email sending (via `mail()` or a mailer library)
- Database storage for contact requests, RSVPs, and newsletter signups

## Online Giving (Demo)

- The **Give** page (`give.php`) shows a clean UI for selecting an amount and frequency.
- The "Continue to Secure Giving" button currently just shows an informational message.
- Replace that section with your payment provider’s embed code, redirect, or SDK integration.

## Gallery Images

The gallery points to placeholder image paths like:

- `assets/images/gallery1.jpg`, `assets/images/gallery1_thumb.jpg`, etc.

Add your own images at those paths (or update the image URLs in `gallery.php`) to show real photos.

## Customizing Styles

- Main styles live in `assets/css/style.css`.
- JavaScript interactivity (nav toggle, filters, lightbox, calendar, giving demo) is in `assets/js/main.js`.

You can freely customize colors, fonts, and layout in the CSS to match your church’s branding.


