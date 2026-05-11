# Digital Voting System

## Live Demo

Website:  
https://digitalvotingsystem.wuaze.com

Tested Features:
- Voter registration
- Login/logout
- Voting system
- Election results
- Admin dashboard
- Theme toggle
- Session-based authentication

A secure and user-friendly web-based Digital Voting System developed as a BCA final year project. The system allows registered voters to log in, view active elections, cast a vote once per election, and view election results. Admin users can manage elections, candidates, voters, analytics, and basic system settings.

---

## Project Overview

This project is built as a simple MVP using only core web technologies. It focuses on the main workflow of a digital voting platform:

- Voter registration and login
- Role-based access for voters and admins
- Active election listing
- Candidate selection and vote submission
- Duplicate vote prevention
- Result display with vote percentages
- Admin management for elections and candidates

---

## Tech Stack

### Frontend
- HTML5
- CSS3
- JavaScript

### Backend
- PHP

### Database
- MySQL

### Tools
- XAMPP / WAMP
- VS Code
- phpMyAdmin
- Git & GitHub
- InfinityFree (Deployment Hosting)

---

## Main Features

- Secure login with password hashing
- Session-based authentication
- Voter and admin roles
- One vote per voter per election
- CSRF protection on important POST forms
- Admin election management
- Admin candidate management
- Voter list and voting status
- Results page with vote counts and percentage bars
- Admin activity logs
- Light/dark theme toggle

---

## Folder Structure

```text
digital-voting-system/
│
├── login.html
├── register.html
├── dashboard.php
├── dashboard.html
├── vote.php
├── results.php
│
├── admin/
│   ├── dashboard.php
│   ├── manage_elections.php
│   ├── manage_candidates.php
│   ├── voters.php
│   ├── analytics.php
│   ├── settings.php
│   └── README.md
│
├── css/
│   ├── login.css
│   ├── register.css
│   ├── dashboard.css
│   ├── admin.css
│   └── README.md
│
├── database/
│   ├── voting_system.sql
│   └── README.md
│
├── includes/
│   ├── db.php
│   ├── session.php
│   ├── navbar.php
│   ├── header.php
│   ├── footer.php
│   └── README.md
│
├── js/
│   ├── main.js
│   ├── login.js
│   ├── register.js
│   ├── vote.js
│   ├── charts.js
│   ├── validation.js
│   ├── dashboard.js
│   └── README.md
│
├── php/
│   ├── config.php
│   ├── functions.php
│   ├── register.php
│   ├── login.php
│   ├── logout.php
│   ├── cast_vote.php
│   ├── verify_email.php
│   ├── forgot_password.php
│   ├── test.php
│   └── README.md
│
├── uploads/
│   ├── candidates/
│   ├── party_symbols/
│   └── README.md
│
└── docs/
    ├── readme.md
    ├── user_manual.md
    └── API_docs.md
```

---

## Database Tables

The database name is `voting_system`.

Main tables:

- `users` — Stores voter and admin accounts
- `elections` — Stores election details
- `candidates` — Stores candidates for each election
- `votes` — Stores vote records and prevents duplicate voting
- `admin_logs` — Stores important admin actions

---

## Setup Instructions

1. Install XAMPP or WAMP

2. Place the project folder inside:

```text
C:/xampp/htdocs/digital-voting-system
```

3. Start Apache and MySQL from XAMPP Control Panel

4. Open phpMyAdmin:

```text
http://localhost:8080/phpmyadmin
```

If your Apache runs on port 80, use:

```text
http://localhost/phpmyadmin
```

5. Import the database file:

```text
database/voting_system.sql
```

6. Open the project in your browser:

```text
http://localhost:8080/digital-voting-system/login.html
```

If your Apache runs on port 80, use:

```text
http://localhost/digital-voting-system/login.html
```

---

## Demo Login

### Admin

```text
Email: admin@example.com
Password: admin123
```

### Voter

```text
Email: voter@example.com
Password: voter123
```

---

## Core Modules

### Voter Registration

New voters can register with their name, email, and password. Passwords are stored using PHP password hashing.

### Login and Authentication

Users can log in using email or voter ID. The system redirects users based on role:

- Voter → voter dashboard
- Admin → admin dashboard

### Voting Panel

Voters can view active elections and select a candidate. The system prevents duplicate voting using a unique vote rule in the database.

### Admin Panel

Admins can:

- View dashboard statistics
- Create, update, and delete elections
- Add and delete candidates
- View voters
- View analytics
- Review basic system settings

### Result Display

The result page shows candidates, vote counts, percentages, and simple result bars.

---

## Security Features

- Password hashing with PHP `password_hash`
- Prepared statements for database queries
- Session-based authentication
- Role-based access control
- CSRF token validation for important forms
- Duplicate vote prevention
- Escaped output using `htmlspecialchars`

---

## Development Status

MVP completed and successfully deployed online.

### Working Modules

- Registration
- Login/logout
- Voter dashboard
- Voting
- Result display
- Admin dashboard
- Election management
- Candidate management
- Voter list
- Analytics/settings pages
- Live deployment on InfinityFree

---

## Future Enhancements

- Candidate photo uploads
- Party symbol uploads
- Email-based account verification
- Password reset with email token
- Export results as CSV/PDF
- More detailed analytics
- Mobile UI improvements

---

## Learning Outcomes

- Full-stack web development with PHP and MySQL
- Database design and relationships
- Session handling
- Authentication and authorization
- CRUD operations
- Form validation and security basics
- Project structuring for GitHub submission
