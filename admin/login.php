<?php
require_once __DIR__ . '/includes/auth.php';

// Redirect if already logged in
if (isAdminLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (adminLogin($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | CFAG Church</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-body">
    <div class="admin-login-container">
        <div class="admin-login-box">
            <h1>Admin Login</h1>
            <p class="admin-login-subtitle">CFAG Church Website Administration</p>
            
            <?php if ($error): ?>
                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="post" class="admin-login-form">
                <div class="form-row">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                <div class="form-row">
                    <label for="password">Password</label>
                    <div class="password-input-wrapper">
                        <input type="password" id="password" name="password" required>
                        <button type="button" class="password-toggle" id="password-toggle" aria-label="Show password">
                            <span class="password-toggle-icon">👁️</span>
                        </button>
                    </div>
                </div>
                <div class="form-row">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
            
            <p class="admin-login-note">
                <small>Default credentials: admin / admin123 (change in admin/includes/auth.php)</small>
            </p>
        </div>
    </div>
    <script>
        // Password visibility toggle
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('password-toggle');
            
            if (passwordToggle && passwordInput) {
                passwordToggle.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Update icon/text
                    const icon = passwordToggle.querySelector('.password-toggle-icon');
                    if (type === 'text') {
                        icon.textContent = '🙈';
                        passwordToggle.setAttribute('aria-label', 'Hide password');
                    } else {
                        icon.textContent = '👁️';
                        passwordToggle.setAttribute('aria-label', 'Show password');
                    }
                });
            }
        });
    </script>
</body>
</html>

