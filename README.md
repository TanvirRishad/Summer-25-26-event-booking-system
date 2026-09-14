# Summer-25-26-event-booking-system
# Event Booking System — PHP + MySQL MVC

A plain PHP/MySQL MVC event booking system designed for XAMPP.

# Architecture

- `index.php` — front controller/router
- `config/` — database and session configuration
- `helpers/` — authentication, CSRF, escaping and utilities
- `models/` — database operations
- `controllers/` — request handling and business logic
- `views/` — HTML/PHP presentation
- `assets/` — CSS and JavaScript
- `database.sql` — complete database schema and demo data

# Roles

# General User
Dashboard, My Bookings, Event Availability Filter, Seat Booking, Promotional Code UI, Payment UI, Refund Request, Profile.

# Administrator
Dashboard, Feedback Action, Attendance Monitoring, Revenue Monitoring.

# Event Manager
Dashboard, Transportation, Live Notifications, Booking Performance Monitoring.

# Volunteer
Dashboard, Event Logistics, Refund Assistance, Customer Inquiry Handling.

# XAMPP Setup

1. Copy the `event_booking_system` folder into `C:/xampp/htdocs/`.
2. Start Apache and MySQL.
3. Open phpMyAdmin.
4. Import `database.sql`.
5. Open `http://localhost/event_booking_system/`.
6. Demo users:
   - admin@example.com
   - manager@example.com
   - user@example.com
   - volunteer@example.com
   - Password for all demo accounts: `password`

# Important

The payment page is a UI/demo flow and does not connect to a real payment gateway.
Promotional-code database support is included; production use should add server-side code validation and discount calculation before accepting a booking.



