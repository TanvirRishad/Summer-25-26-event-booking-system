CREATE DATABASE IF NOT EXISTS event_booking CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE event_booking;

CREATE TABLE users(
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 admin_id VARCHAR(50) NULL UNIQUE,
 email VARCHAR(150) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role ENUM('admin','event_manager','general_user','volunteer') NOT NULL DEFAULT 'general_user',
 phone VARCHAR(30) DEFAULT '',
 address VARCHAR(255) DEFAULT '',
 status ENUM('active','inactive') NOT NULL DEFAULT 'active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events(
 id INT AUTO_INCREMENT PRIMARY KEY,
 manager_id INT NOT NULL,
 title VARCHAR(180) NOT NULL,
 description TEXT,
 category VARCHAR(80) NOT NULL,
 location VARCHAR(180) NOT NULL,
 event_date DATETIME NOT NULL,
 price DECIMAL(10,2) NOT NULL DEFAULT 0,
 capacity INT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(manager_id) REFERENCES users(id) ON DELETE RESTRICT
);

CREATE TABLE event_seats(
 id INT AUTO_INCREMENT PRIMARY KEY,
 event_id INT NOT NULL,
 seat_number VARCHAR(20) NOT NULL,
 status ENUM('available','booked','blocked') DEFAULT 'available',
 UNIQUE KEY(event_id,seat_number),
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE promotional_codes(
 id INT AUTO_INCREMENT PRIMARY KEY,
 code VARCHAR(50) UNIQUE NOT NULL,
 discount_type ENUM('percent','fixed') NOT NULL,
 discount_value DECIMAL(10,2) NOT NULL,
 expires_at DATETIME NOT NULL,
 usage_limit INT DEFAULT 100,
 used_count INT DEFAULT 0,
 status ENUM('active','inactive') DEFAULT 'active'
);

CREATE TABLE bookings(
 id INT AUTO_INCREMENT PRIMARY KEY,
 booking_code VARCHAR(30) UNIQUE NOT NULL,
 user_id INT NOT NULL,
 event_id INT NOT NULL,
 seat_id INT NOT NULL,
 promo_id INT NULL,
 total_amount DECIMAL(10,2) NOT NULL,
 status ENUM('pending','confirmed','cancelled') DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE,
 FOREIGN KEY(seat_id) REFERENCES event_seats(id) ON DELETE RESTRICT,
 FOREIGN KEY(promo_id) REFERENCES promotional_codes(id) ON DELETE SET NULL
);

CREATE TABLE payments(
 id INT AUTO_INCREMENT PRIMARY KEY,
 booking_id INT NOT NULL,
 amount DECIMAL(10,2) NOT NULL,
 method VARCHAR(50) NOT NULL,
 status ENUM('pending','paid','failed','refunded') DEFAULT 'pending',
 paid_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);

CREATE TABLE refunds(
 id INT AUTO_INCREMENT PRIMARY KEY,
 booking_id INT NOT NULL,
 user_id INT NOT NULL,
 reason TEXT NOT NULL,
 status ENUM('requested','under_review','approved','rejected','refunded') DEFAULT 'requested',
 handled_by INT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 FOREIGN KEY(handled_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE feedback(
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 event_id INT NOT NULL,
 message TEXT NOT NULL,
 status ENUM('new','reviewed','resolved','rejected') DEFAULT 'new',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE attendance(
 id INT AUTO_INCREMENT PRIMARY KEY,
 booking_id INT NOT NULL UNIQUE,
 status ENUM('present','absent') DEFAULT 'absent',
 marked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);

CREATE TABLE transportation(
 id INT AUTO_INCREMENT PRIMARY KEY,
 event_id INT NOT NULL,
 type VARCHAR(60) NOT NULL,
 provider VARCHAR(120) NOT NULL,
 departure VARCHAR(180) NOT NULL,
 arrival VARCHAR(180) NOT NULL,
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE notifications(
 id INT AUTO_INCREMENT PRIMARY KEY,
 manager_id INT NOT NULL,
 event_id INT NOT NULL,
 message TEXT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(manager_id) REFERENCES users(id) ON DELETE CASCADE,
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE event_logistics(
 id INT AUTO_INCREMENT PRIMARY KEY,
 event_id INT NOT NULL,
 task VARCHAR(180) NOT NULL,
 assigned_to VARCHAR(100) NOT NULL,
 status ENUM('pending','in_progress','completed') DEFAULT 'pending',
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE inquiries(
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 event_id INT NOT NULL,
 question TEXT NOT NULL,
 answer TEXT DEFAULT '',
 status ENUM('open','answered','closed') DEFAULT 'open',
 handled_by INT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE,
 FOREIGN KEY(handled_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE activity_logs(
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NULL,
 action VARCHAR(150) NOT NULL,
 details TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Demo passwords are all: password
INSERT INTO users(name,admin_id,email,password,role) VALUES
('System Administrator','ADMIN-2027-001','admin@example.com', '$2y$12$/xEJVWjdEgSlAePJHNlObemfZdc8miVOcRlCLUg.31a9HEZQhMAfa','admin'),
('Event Manager',NULL,'manager@example.com', '$2y$12$MS9VqoZeWWJ7TBneI2C1T.ySlGU9CEV/w3fRAMj/I9WTrnnqfoc7i','event_manager'),
('General User',NULL,'user@example.com', '$2y$12$zzUtVFZOipe482V5SXBHM.I3MK6LcWH2kPNoDMNfsZriXma1078Ae','general_user'),
('Volunteer',NULL,'volunteer@example.com', '$2y$12$S6Ei0bV1v8/xuX.0uqUUW.ZmYoCKuMV6leWxDmDucGInfqwVDDAaa','volunteer');

INSERT INTO events(manager_id,title,description,category,location,event_date,price,capacity) VALUES
(2,'AI & Technology Summit','Technology conference and networking event.','Conference','Dhaka Convention Center','2027-01-15 10:00:00',1500,50),
(2,'Music Night','Live music and entertainment.','Music','Bashundhara Arena','2027-02-20 19:00:00',1000,40),
(2,'Career Workshop','Career development workshop for students.','Workshop','AIUB Auditorium','2027-03-10 15:00:00',500,30);

INSERT INTO event_logistics(event_id,task,assigned_to,status) VALUES
(1,'Registration desk','Volunteer Team','pending'),
(1,'Stage preparation','Volunteer Team','in_progress'),
(2,'Guest reception','Volunteer Team','pending');

-- Generate seats for demo events
INSERT INTO event_seats(event_id,seat_number,status)
SELECT e.id, CONCAT('S-',LPAD(n,3,'0')),'available'
FROM events e
JOIN (
SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15
UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19 UNION ALL SELECT 20
UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23 UNION ALL SELECT 24 UNION ALL SELECT 25
UNION ALL SELECT 26 UNION ALL SELECT 27 UNION ALL SELECT 28 UNION ALL SELECT 29 UNION ALL SELECT 30
UNION ALL SELECT 31 UNION ALL SELECT 32 UNION ALL SELECT 33 UNION ALL SELECT 34 UNION ALL SELECT 35
UNION ALL SELECT 36 UNION ALL SELECT 37 UNION ALL SELECT 38 UNION ALL SELECT 39 UNION ALL SELECT 40
UNION ALL SELECT 41 UNION ALL SELECT 42 UNION ALL SELECT 43 UNION ALL SELECT 44 UNION ALL SELECT 45
UNION ALL SELECT 46 UNION ALL SELECT 47 UNION ALL SELECT 48 UNION ALL SELECT 49 UNION ALL SELECT 50
) nums ON n <= e.capacity;

INSERT INTO promotional_codes(code,discount_type,discount_value,expires_at,usage_limit,status) VALUES ('WELCOME10','percent',10,'2028-12-31 23:59:59',100,'active');
