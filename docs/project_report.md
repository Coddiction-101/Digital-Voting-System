# Digital Voting System

## Final Year Project Report

**Student Name:** Gulshan Kushwaha  
**Course:** BCA Final Year  
**Project Type:** Web-Based Application  
**Technology Stack:** HTML, CSS, JavaScript, PHP, MySQL  
**Development Environment:** XAMPP, VS Code, phpMyAdmin  

---

## 1. Introduction

The Digital Voting System is a web-based application designed to allow registered users to cast votes online in a secure and organized manner. The project provides separate access for voters and administrators. Voters can register, log in, view active elections, cast one vote per election, and view results. Administrators can manage elections, candidates, voters, analytics, and basic system settings.

This project is developed as an MVP for a final year BCA submission. It focuses on the core working features required in a digital voting platform without using external frameworks.

## 2. Problem Statement

Traditional voting systems can be time-consuming, paper-based, and difficult to manage manually. Counting votes, maintaining voter records, preventing duplicate voting, and displaying results can become complicated when handled without a digital system.

The problem addressed by this project is to create a simple digital platform that can manage voter authentication, election data, candidate data, vote submission, and result display in one place.

## 3. Objectives

- To build a web-based voting platform using HTML, CSS, JavaScript, PHP, and MySQL.
- To provide secure registration and login for voters.
- To provide role-based access for voters and administrators.
- To allow voters to vote only once per election.
- To allow admins to create and manage elections and candidates.
- To display voting results with vote counts and percentages.
- To implement basic security features such as password hashing, prepared statements, sessions, and CSRF protection.

## 4. Scope of the Project

The project includes the following modules:

- Voter registration
- Login and logout
- Voter dashboard
- Voting panel
- Result display
- Admin dashboard
- Election management
- Candidate management
- Voter list
- Analytics and settings pages

The project does not include advanced production features such as OTP login, biometric verification, payment gateway, blockchain voting, or real email delivery.

## 5. Technology Used

### Frontend

- HTML5 for page structure
- CSS3 for styling and responsive layout
- JavaScript for theme toggle, validation, and voting confirmation

### Backend

- PHP for server-side logic, authentication, voting, and admin operations

### Database

- MySQL for storing users, elections, candidates, votes, and admin logs

### Tools

- XAMPP for local Apache and MySQL server
- phpMyAdmin for database import and management
- VS Code for development
- GitHub for source code storage

## 6. System Architecture

The project follows a 3-tier architecture:

### Presentation Layer

This layer contains the user interface pages such as login, register, dashboard, vote, results, and admin pages. It is built using HTML, CSS, and JavaScript.

### Application Layer

This layer contains PHP scripts that handle authentication, session management, vote casting, registration, admin actions, and reusable helper functions.

### Data Layer

This layer contains the MySQL database. It stores user accounts, elections, candidates, vote records, and admin activity logs.

## 7. Database Design

The database name is `voting_system`.

### users

Stores voter and admin account details.

Important fields:

- `user_id`
- `voter_id`
- `full_name`
- `email`
- `password`
- `is_verified`
- `has_voted`
- `role`

### elections

Stores election details.

Important fields:

- `election_id`
- `election_name`
- `election_type`
- `start_date`
- `end_date`
- `status`
- `description`
- `created_by`

### candidates

Stores candidate details linked to elections.

Important fields:

- `candidate_id`
- `election_id`
- `candidate_name`
- `party_name`
- `bio`
- `vote_count`

### votes

Stores vote records. The table includes a unique rule to prevent one voter from voting multiple times in the same election.

Important fields:

- `vote_id`
- `election_id`
- `voter_id`
- `candidate_id`
- `voted_at`
- `ip_address`

### admin_logs

Stores important administrator actions such as creating elections, updating election status, and deleting candidates.

## 8. Module Description

### Voter Registration

The registration module allows a new voter to create an account by entering a name, email, and password. The password is stored securely using hashing.

### Login and Authentication

The login module allows users to log in using email or voter ID. After successful login, users are redirected based on their role.

- Voter users are redirected to the voter dashboard.
- Admin users are redirected to the admin dashboard.

### Voter Dashboard

The voter dashboard displays active elections, upcoming elections, vote count, and participation information.

### Voting Module

The voting module displays candidates for active elections. A voter can select one candidate and submit the vote. After voting, the system prevents the voter from voting again in the same election.

### Results Module

The results module displays all elections with candidate vote counts and percentage bars.

### Admin Dashboard

The admin dashboard displays statistics such as total voters, total elections, active elections, and total votes. It also provides quick links to admin controls.

### Manage Elections

Admins can create elections, update election status, and delete elections.

### Manage Candidates

Admins can add candidates to elections and delete candidates.

### Voters Page

Admins can view registered voters and their voting status.

### Analytics Page

Admins can view election vote summaries and participation rate.

### Settings Page

This page displays basic project configuration such as voting rule, session timeout, and security features.

## 9. Security Features

The project includes the following security measures:

- Password hashing using PHP `password_hash`
- Password verification using PHP `password_verify`
- Prepared statements for database queries
- Session-based authentication
- Role-based access control
- CSRF token validation for important forms
- Duplicate vote prevention using database constraints
- Output escaping using `htmlspecialchars`

## 10. Testing

The MVP was tested using the local XAMPP server. The following flows were tested:

- Login page loading
- Registration page loading
- Voter registration
- Voter login
- Voter dashboard access
- Vote page access
- Vote submission
- Duplicate vote prevention
- Result display
- Admin login
- Admin dashboard access
- Election creation
- Candidate creation
- Analytics page access
- CSRF rejection for invalid vote form submission

## 11. Setup Instructions

1. Install XAMPP or WAMP.
2. Place the project folder inside `C:/xampp/htdocs/`.
3. Start Apache and MySQL.
4. Open phpMyAdmin.
5. Import `database/voting_system.sql`.
6. Open the project in a browser.

If Apache runs on port 8080:

```text
http://localhost:8080/digital-voting-system/login.html
```

If Apache runs on port 80:

```text
http://localhost/digital-voting-system/login.html
```

## 12. Demo Credentials

Admin:

```text
Email: admin@example.com
Password: admin123
```

Voter:

```text
Email: voter@example.com
Password: voter123
```

## 13. Limitations

- Email verification is implemented as a simple MVP handler and does not send real email.
- Password recovery is basic and does not send reset links by email.
- Candidate image and party symbol upload folders are reserved but not fully implemented.
- The project is designed for academic demonstration, not direct production deployment.

## 14. Future Enhancements

- Real email verification
- Password reset through email token
- Candidate photo upload
- Party symbol upload
- CSV/PDF result export
- More detailed analytics
- Mobile UI improvements
- OTP-based login
- Blockchain-based voting concept

## 15. Conclusion

The Digital Voting System successfully implements the core features of a web-based voting platform. It allows voters to register, log in, vote once per election, and view results. It also provides administrators with tools to manage elections, candidates, voters, analytics, and settings. The project demonstrates full-stack web development using HTML, CSS, JavaScript, PHP, and MySQL, along with basic security practices suitable for an academic MVP.


