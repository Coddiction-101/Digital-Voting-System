# 🗳️ Digital Voting System

A secure and user-friendly **web-based Digital Voting System** developed as a final year BCA project. This system allows registered users to cast votes online while ensuring transparency, authentication, and prevention of duplicate voting.

---

## 📌 Project Overview

The Digital Voting System is designed to replace traditional voting methods with a digital platform that is:

- Secure 🔐
- Efficient ⚡
- Transparent 📊
- Easy to use 👨‍💻

It ensures **one user can vote only once**, with proper authentication and real-time vote management.

---

## 🎯 Objectives

- Build a secure online voting platform
- Implement authentication and authorization
- Prevent duplicate voting
- Provide admin control over candidates and voting
- Display accurate voting results

---

## 🧰 Tech Stack

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
- Git & GitHub

---

## 🏗️ System Architecture

The application follows a **3-tier architecture**:

### 1. Presentation Layer (Frontend)
- User Interface (Login, Register, Vote, Result, Admin Panel)

### 2. Application Layer (Backend)
- Business logic (Authentication, Voting logic, Admin controls)

### 3. Data Layer (Database)
- Stores users, candidates, and votes

---

## 📂 Folder Structure

```
digital-voting-system/
│
├── index.php              # Login Page
├── register.php           # Registration Page
├── vote.php               # Voting Panel
├── result.php             # Result Page
├── logout.php
│
├── admin/
│   ├── dashboard.php
│   ├── manage_candidates.php
│   └── view_votes.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── images/
│
├── includes/
│   ├── db.php
│   ├── auth.php
│   └── functions.php
│
└── database/
    └── voting.sql
```

---

## 🧩 Core Modules

### 📝 Voter Registration
- Users can register with basic details
- Data stored securely in database

### 🔐 Login & Authentication
- Secure login system
- Session handling implemented

### 🗳️ Voting Panel
- Displays list of candidates
- Allows user to vote once
- Prevents duplicate voting

### 🛠️ Admin Panel
- Manage candidates
- Monitor voting activity

### 📊 Result Display
- Vote counting system
- Displays final results

---

## 🗄️ Database Design

### 🔹 Users Table

| Field      | Type       |
|------------|------------|
| id         | INT (PK)   |
| name       | VARCHAR    |
| email      | VARCHAR    |
| password   | VARCHAR    |
| has_voted  | BOOLEAN    |
| role       | VARCHAR    |

### 🔹 Candidates Table

| Field  | Type     |
|--------|----------|
| id     | INT (PK) |
| name   | VARCHAR  |
| party  | VARCHAR  |

### 🔹 Votes Table

| Field        | Type     |
|--------------|----------|
| id           | INT (PK) |
| user_id      | INT      |
| candidate_id | INT      |

---

## 🔐 Security Features

- Password hashing (bcrypt)
- Session management
- Input validation
- Prevention of multiple votes
- Basic protection against SQL Injection

---

## 🚀 Project Setup

### 1. Clone Repository

```bash
git clone https://github.com/your-username/digital-voting-system.git
```

### 2. Move to Project Folder

```bash
cd digital-voting-system
```

### 3. Setup Server

- Install XAMPP / WAMP
- Move project to `htdocs`

### 4. Setup Database

- Open phpMyAdmin
- Create database: `voting_system`
- Import `database/voting.sql`

### 5. Run Project

- Start Apache & MySQL
- Open browser:

```
http://localhost/digital-voting-system
```

---

## 🧠 Key Learning Outcomes

- Full-stack web development
- Authentication systems
- CRUD operations
- Database design
- Session handling
- Real-world project structuring

---

## 📅 Development Phases

- Phase 1: Frontend Design
- Phase 2: Backend Setup
- Phase 3: Authentication System
- Phase 4: Voting Logic
- Phase 5: Admin Panel
- Phase 6: Result System

---

## 🔥 Future Enhancements

- OTP-based login
- Aadhaar verification (concept)
- Live result charts
- Blockchain-based voting system (advanced)

---
