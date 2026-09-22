# EmployeeHub — PHP & MySQL Lab Exercise

A clean, responsive Employee Management System for the lab question:

> Create form design to enter Employee details and store it into a table in phpMyAdmin database.

## Features

- Modern responsive employee registration UI
- PHP + MySQL database
- PDO prepared statements
- Server-side validation
- Client-side HTML validation
- Valid Indian 10-digit mobile number validation
- Valid email validation
- Unique Employee ID, email and phone
- Admin dashboard with employee table
- Search across employee records
- Dashboard statistics
- Mobile responsive design

## Requirements

- XAMPP / WAMP / MAMP
- PHP 8+
- MySQL
- Web browser
- VS Code (recommended)

## Setup using XAMPP

1. Copy the `employee-management` project folder into:
   `C:\xampp\htdocs\`

2. Start **Apache** and **MySQL** from XAMPP Control Panel.

3. Open phpMyAdmin:
   `http://localhost/phpmyadmin`

4. Create the database by importing:
   `database/schema.sql`

   Or open the SQL tab and paste its contents.

5. Check `config/database.php`.
   Default XAMPP credentials are:
   - Host: localhost
   - Database: employee_db
   - User: root
   - Password: empty

6. Open:
   `http://localhost/employee-management/`

7. Add an employee.

8. Open:
   `http://localhost/employee-management/admin.php`

## GitHub

You can push this entire folder to GitHub. Keep the database credentials in a local configuration file for real projects rather than committing production passwords.

## Validation rules

### Email
PHP uses `FILTER_VALIDATE_EMAIL`.

### Indian phone number
The accepted format is exactly 10 digits and starts with 6, 7, 8 or 9.

Examples:
- `9876543210` ✓
- `8123456789` ✓
- `5123456789` ✗
- `98765` ✗

### Database uniqueness
Employee ID, email and phone are UNIQUE in MySQL, so duplicate records are rejected.

## Lab explanation

Frontend:
- HTML5 form
- CSS responsive UI
- JavaScript input sanitisation

Backend:
- PHP
- PDO
- Prepared SQL statements
- Server-side validation

Database:
- MySQL
- `employees` table
- phpMyAdmin can be used to inspect the database visually

## Suggested screenshots for submission

1. Employee registration page
2. Successful employee insertion message
3. phpMyAdmin `employees` table
4. Admin dashboard showing all employee records
5. Search result in admin dashboard
