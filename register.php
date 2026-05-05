<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

require_guest();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

    validate_name($name, $errors);
    validate_email($email, $errors);
    validate_password($password, $errors);

    if ($confirmPassword === '') {
        $errors['confirm_password'] = 'Please confirm your password.';
    } elseif ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    if (!$errors) {
        $statement = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $statement->execute([$email]);

        if ($statement->fetch()) {
            $errors['email'] = 'This email is already registered.';
        }
    }

    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $statement = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $statement->execute([$name, $email, $hash]);

        $_SESSION['flash'] = 'Registration successful. Please log in.';
        redirect('login.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="auth-card">
        <h1>Create Account</h1>
        <form method="post" action="register.php" novalidate>
            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="<?= e(old('name')) ?>" required>
            <?php if (isset($errors['name'])): ?><p class="error"><?= e($errors['name']) ?></p><?php endif; ?>

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?= e(old('email')) ?>" required>
            <?php if (isset($errors['email'])): ?><p class="error"><?= e($errors['email']) ?></p><?php endif; ?>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            <?php if (isset($errors['password'])): ?><p class="error"><?= e($errors['password']) ?></p><?php endif; ?>

            <label for="confirm_password">Confirm Password</label>
            <input id="confirm_password" name="confirm_password" type="password" required>
            <?php if (isset($errors['confirm_password'])): ?><p class="error"><?= e($errors['confirm_password']) ?></p><?php endif; ?>

            <button type="submit">Register</button>
        </form>
        <p class="switch-link">Already have an account? <a href="login.php">Log in</a></p>
    </main>
</body>
</html>
