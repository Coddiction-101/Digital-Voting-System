# Database Folder

This folder contains the SQL schema for the Digital Voting System.

## Files

- `voting_system.sql` - Creates the `voting_system` database, tables, relationships, and demo records.

## Main Tables

- `users` - Stores voter and admin accounts.
- `elections` - Stores election details.
- `candidates` - Stores candidates linked to elections.
- `votes` - Stores vote records with one vote per voter per election.
- `admin_logs` - Stores important admin activity.

## Import

Import `voting_system.sql` in phpMyAdmin or MySQL before running the project.
