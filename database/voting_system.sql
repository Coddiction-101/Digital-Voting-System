CREATE DATABASE IF NOT EXISTS voting_system
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE voting_system;

DROP TABLE IF EXISTS admin_logs;
DROP TABLE IF EXISTS votes;
DROP TABLE IF EXISTS candidates;
DROP TABLE IF EXISTS elections;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    voter_id VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    date_of_birth DATE,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_verified TINYINT(1) DEFAULT 0,
    has_voted TINYINT(1) DEFAULT 0,
    role ENUM('voter', 'admin') DEFAULT 'voter'
) ENGINE=InnoDB;

CREATE TABLE elections (
    election_id INT PRIMARY KEY AUTO_INCREMENT,
    election_name VARCHAR(200) NOT NULL,
    election_type VARCHAR(50),
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    status ENUM('upcoming', 'active', 'completed') DEFAULT 'upcoming',
    description TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE candidates (
    candidate_id INT PRIMARY KEY AUTO_INCREMENT,
    election_id INT NOT NULL,
    candidate_name VARCHAR(100) NOT NULL,
    party_name VARCHAR(100),
    party_symbol VARCHAR(255),
    bio TEXT,
    photo VARCHAR(255),
    vote_count INT DEFAULT 0,
    FOREIGN KEY (election_id) REFERENCES elections(election_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE votes (
    vote_id INT PRIMARY KEY AUTO_INCREMENT,
    election_id INT NOT NULL,
    voter_id VARCHAR(20) NOT NULL,
    candidate_id INT NOT NULL,
    voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    FOREIGN KEY (election_id) REFERENCES elections(election_id) ON DELETE CASCADE,
    FOREIGN KEY (voter_id) REFERENCES users(voter_id) ON DELETE CASCADE,
    FOREIGN KEY (candidate_id) REFERENCES candidates(candidate_id) ON DELETE CASCADE,
    UNIQUE KEY unique_vote (election_id, voter_id)
) ENGINE=InnoDB;

CREATE TABLE admin_logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    details TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO users (voter_id, full_name, email, password, is_verified, role) VALUES
('ADM2026001', 'Admin User', 'admin@example.com', '$2y$10$vR6saJ06o8wk.ryatMo4FuJBRLO24fTu7/9Bz6txjAHzw1zB52TGm', 1, 'admin'),
('VTR2026001', 'Demo Voter', 'voter@example.com', '$2y$10$YO0Y.RaN62mo1H1eh0z/5uK/3oVMj0jNBHmTx2YT7Yxp/in9wRLRy', 1, 'voter');

INSERT INTO elections (election_name, election_type, start_date, end_date, status, description, created_by) VALUES
('Student Council Election 2026', 'College', DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL 7 DAY), 'active', 'Choose the student council representative.', 1),
('Sports Captain Election', 'College', DATE_ADD(NOW(), INTERVAL 3 DAY), DATE_ADD(NOW(), INTERVAL 10 DAY), 'upcoming', 'Select the sports captain for this session.', 1);

INSERT INTO candidates (election_id, candidate_name, party_name, bio) VALUES
(1, 'Aman Sharma', 'Unity Party', 'Focused on transparent student representation.'),
(1, 'Priya Verma', 'Progress Party', 'Focused on events, facilities, and student welfare.'),
(1, 'Rohit Singh', 'Campus Voice', 'Focused on academic support and sports participation.'),
(2, 'Neha Patel', 'Blue House', 'Basketball team captain and fitness club coordinator.'),
(2, 'Arjun Mehta', 'Red House', 'Football team captain and athletics participant.');
