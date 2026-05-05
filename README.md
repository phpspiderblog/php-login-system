# PHP Login System

Basic PHP login system with registration, login validation, session protection, and logout.

## Files

- `schema.sql` creates the `users` table.
- `config.php` stores the database connection settings.
- `helpers.php` contains shared validation and session helpers.
- `register.php` creates a new account.
- `login.php` signs in an existing user.
- `dashboard.php` is protected and only visible after login.
- `logout.php` ends the session.
- `style.css` styles the forms.

## Setup

1. Create a MySQL database named `login_system`.
2. Import `schema.sql`.
3. Update the credentials in `config.php` if your local MySQL user/password are different.
4. Place this folder inside your PHP web root, for example `htdocs/php-login-system`.
5. Open `http://localhost/php-login-system/register.php`.

## Validation Included

- Required name, email, and password fields.
- Valid email format.
- Password minimum length.
- Password confirmation check.
- Duplicate email check.
- Prepared SQL statements.
- Secure password hashing with `password_hash()`.
- Login verification with `password_verify()`.
- Protected dashboard using PHP sessions.
