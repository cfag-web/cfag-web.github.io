# CFAG Church Website - Admin Panel

## Overview

The admin panel allows authorized users to manage events, sermons, and ministries on the church website.

## Access

- **URL**: `http://localhost/CFAG_WEBSITE/admin/`
- **Default Username**: `admin`
- **Default Password**: `admin123`

⚠️ **IMPORTANT**: Change the default password in `admin/includes/auth.php` before deploying to production!

## Features

### Dashboard
- Overview of all content (events, sermons, ministries)
- Quick action buttons to add new content
- List of upcoming events

### Manage Events
- Add, edit, and delete events
- Fields: Title, Date, Time, Location, Description
- Events automatically appear on the public Events page

### Manage Sermons
- Add, edit, and delete sermons
- Fields: Title, Speaker, Date, Series, Summary, Video URL
- Sermons automatically appear on the public Sermons page

### Manage Ministries
- Add, edit, and delete ministries
- Fields: Name, Description, Leader, Contact Email, Schedule
- Ministries automatically appear on the public Ministries page

## Data Storage

Currently uses JSON files stored in the `data/` directory:
- `data/events.json`
- `data/sermons.json`
- `data/ministries.json`

These files are automatically created when you first access the admin panel. The system initializes with sample data from `data/sample_data.php` if the JSON files don't exist.

## Security Notes

1. **Change Default Password**: Edit `admin/includes/auth.php` and update `ADMIN_PASSWORD`
2. **Session Security**: Sessions are used for authentication
3. **File Permissions**: Ensure the `data/` directory is writable by the web server
4. **HTTPS**: Use HTTPS in production for secure login

## Future Enhancements

- Database integration (MySQL/PostgreSQL)
- Image uploads for sermons/events
- User management (multiple admin users)
- Content versioning/history
- Bulk import/export

## Troubleshooting

**Can't log in?**
- Check that sessions are enabled in PHP
- Verify the username/password in `admin/includes/auth.php`

**Changes not appearing on public site?**
- Check that `data/*.json` files exist and are readable
- Verify file permissions on the `data/` directory

**Can't save changes?**
- Ensure the `data/` directory is writable (chmod 755 or 775)

