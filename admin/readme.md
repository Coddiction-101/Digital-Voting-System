# Admin Folder

This folder contains the administrator panel pages for the Digital Voting System.

## Files

- `dashboard.php` - Admin overview with voter, election, vote, and activity statistics.
- `manage_elections.php` - Create, update status, and delete elections.
- `manage_candidates.php` - Add and delete candidates for elections.
- `voters.php` - View registered voter accounts and voting status.
- `analytics.php` - View participation and election vote summaries.
- `settings.php` - Shows project security and voting rule configuration.

## Notes

All admin pages require an authenticated user with the `admin` role. Admin forms use CSRF protection and database operations are handled with prepared statements.

