<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

require_login();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="auth-card">
        <h1>Welcome, <?= e((string) $_SESSION['user_name']) ?></h1>
        <p class="muted">You are logged in successfully.</p>
        <a class="button-link" href="logout.php">Logout</a>
    </main>
</body>
</html>
