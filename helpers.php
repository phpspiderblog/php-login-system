<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function old(string $key, string $default = ''): string
{
    return isset($_POST[$key]) ? trim((string) $_POST[$key]) : $default;
}

function redirect(string $path): never
{
    header("Location: {$path}");
    exit;
}

function require_guest(): void
{
    if (isset($_SESSION['user_id'])) {
        redirect('dashboard.php');
    }
}

function require_login(): void
{
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

function validate_name(string $name, array &$errors): void
{
    if ($name === '') {
        $errors['name'] = 'Name is required.';
    } elseif (strlen($name) > 100) {
        $errors['name'] = 'Name must be 100 characters or fewer.';
    }
}

function validate_email(string $email, array &$errors): void
{
    if ($email === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    } elseif (strlen($email) > 255) {
        $errors['email'] = 'Email must be 255 characters or fewer.';
    }
}

function validate_password(string $password, array &$errors): void
{
    if ($password === '') {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters.';
    }
}
