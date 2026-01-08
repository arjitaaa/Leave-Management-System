# Leave Management System
## Description

The Leave Management System is a web-based application developed to
digitize and automate the leave application process in educational
institutions. The system allows students to apply for leave online
and ensures a structured, multi-level approval workflow involving
parents and the Head of Department (HOD).

This project reduces paperwork, improves transparency, and provides
a secure and efficient way to manage leave records. It is designed
specifically to meet institutional requirements such as student
authentication, approval tracking, and role-based access control.
## Technologies Used

### Frontend
- HTML5
- CSS3
- JavaScript

### Backend
- PHP (Core PHP)

### Database
- MySQL

### Server Environment
- Apache Server
- macOS (XAMPP)

### Version Control
- Git
- GitHub
## Key Features

### Student Module
- Student registration and secure login
- Online leave application submission
- View leave history and application status
- Session-based authentication and logout

### Parent Module
- Parent login using registered mobile number
- View student leave requests
- Approve or reject leave applications

### HOD Module
- HOD login and dashboard
- View parent-approved leave requests
- Final approval or rejection of leave
- Monthly leave history tracking

### System Features
- Multi-level approval workflow
- Role-based access control
- Real-time leave status updates
## Project Workflow

1. Student applies for leave through the system.
2. Leave request is sent to the parent for approval.
3. After parent approval, the request is forwarded to the HOD.
4. HOD provides final approval or rejection.
5. Final leave status is updated and visible to the student.

## Project Structure
```
Leave-Management-System/
├── index.html
├── login.html
├── dashboard.html
├── apply_leave.php
├── leave_history.php
├── parent_login.php
├── hod_login.php
├── db_connect.php
├── style.css
├── script.js
├── leavedb.sql
└── README.md
```



## How to Run the Project Locally (macOS)
1. Clone the repository:
git clone https://github.com/arjitaaa/leave-management-system.git

2. Move the project folder to the server directory:
/Applications/XAMPP/htdocs/

3. Start Apache and MySQL services.

4. Import the database:
- Open phpMyAdmin
- Create a database named `leavedb`
- Import the file `database/leavedb.sql`

5. Configure database connection in:
config/db_connect.php
$host = "localhost";
$user = "root";
$password = "";
$database = "leavedb";

6. Run the project in browser:
http://localhost/Leave-Management-System/

## Security Features

- Session-based authentication for all users
- Role-based access control (Student, Parent, HOD)
- Password hashing for secure credential storage
- Prevention of unauthorized dashboard access
- Input validation to reduce SQL injection risks


## Future Enhancements

- Email and SMS notifications for leave approval
- Upload support for medical documents
- Admin dashboard with analytics
- Improved UI using modern frameworks
- JWT-based authentication system
- Cloud database integration
