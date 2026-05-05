<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

require_guest();

$errors = [];
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    validate_email($email, $errors);

    if ($password === '') {
        $errors['password'] = 'Password is required.';
    }

    if (!$errors) {
        $statement = $pdo->prepare('SELECT id, name, password FROM users WHERE email = ? LIMIT 1');
        $statement->execute([$email]);
        $user = $statement->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['user_name'] = $user['name'];
            redirect('dashboard.php');
        }

        $errors['login'] = 'Invalid email or password.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="auth-card">
        <h1>Login</h1>
        <?php if ($flash): ?><p class="success"><?= e($flash) ?></p><?php endif; ?>
        <?php if (isset($errors['login'])): ?><p class="error banner"><?= e($errors['login']) ?></p><?php endif; ?>

        <form method="post" action="login.php" novalidate>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?= e(old('email')) ?>" required>
            <?php if (isset($errors['email'])): ?><p class="error"><?= e($errors['email']) ?></p><?php endif; ?>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            <?php if (isset($errors['password'])): ?><p class="error"><?= e($errors['password']) ?></p><?php endif; ?>

            <button type="submit">Login</button>
        </form>
        <p class="switch-link">Need an account? <a href="register.php">Register</a></p>
    </main>
</body>
</html>
