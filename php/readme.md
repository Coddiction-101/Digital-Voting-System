# PHP Folder

This folder contains backend processing scripts for authentication, voting, and shared logic.

## Files

- `config.php` - Loads the database connection.
- `functions.php` - Common helpers for escaping output, redirects, CSRF, sessions, roles, and admin logs.
- `register.php` - Handles voter registration and password hashing.
- `login.php` - Handles login for voters and admins.
- `logout.php` - Ends the current user session.
- `cast_vote.php` - Records votes and prevents duplicate voting.
- `verify_email.php` - Simple email verification handler for MVP flow.
- `forgot_password.php` - Basic password recovery request page.
- `test.php` - Simple database connection test.

## Notes

Backend forms use prepared statements and CSRF tokens where needed.

