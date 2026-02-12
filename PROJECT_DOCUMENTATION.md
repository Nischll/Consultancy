# Consultancy Management System
## Complete Project Documentation

**Version:** 1.0  
**Date:** January 2026  
**Framework:** Laravel 9.x  
**PHP Version:** 8.0.2+

---

## Table of Contents

1. [Project Overview](#project-overview)
2. [System Architecture](#system-architecture)
3. [Features & Modules](#features--modules)
4. [User Roles & Portals](#user-roles--portals)
5. [Installation & Setup](#installation--setup)
6. [Database Structure](#database-structure)
7. [API & Routes Documentation](#api--routes-documentation)
8. [Configuration](#configuration)
9. [Deployment Guide](#deployment-guide)
10. [Troubleshooting](#troubleshooting)
11. [Development Guidelines](#development-guidelines)

---

## 1. Project Overview

### 1.1 Introduction

The Consultancy Management System is a comprehensive web-based application designed to manage all aspects of an educational consultancy business. It provides a centralized platform for managing students, applications, documents, payments, communications, and staff operations.

### 1.2 Purpose

This system streamlines the entire student application process from initial inquiry to visa approval, while also managing internal operations such as employee attendance, teacher course assignments, and financial tracking.

### 1.3 Technology Stack

- **Backend Framework:** Laravel 9.x
- **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
- **Database:** MySQL/MariaDB
- **PHP Version:** 8.0.2 or higher
- **Package Manager:** Composer
- **Asset Builder:** Vite

---

## 2. System Architecture

### 2.1 MVC Architecture

The application follows the Model-View-Controller (MVC) pattern:

- **Models:** Located in `app/Models/` - Handle database interactions
- **Views:** Located in `resources/views/` - Blade templates for UI
- **Controllers:** Located in `app/Http/Controllers/` - Handle business logic

### 2.2 Directory Structure

```
consultancy/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # All application controllers
│   │   └── Middleware/          # Custom middleware
│   └── Models/                  # Eloquent models
├── database/
│   ├── migrations/              # Database schema
│   └── seeders/                 # Database seeders
├── resources/
│   ├── views/                   # Blade templates
│   └── lang/                    # Language files
├── routes/
│   ├── web.php                  # Web routes
│   └── auth.php                 # Authentication routes
└── public/                       # Public assets
```

---

## 3. Features & Modules

### 3.1 Core Modules

#### 3.1.1 Student Management
- Complete student profile management
- Student status tracking (active, inactive, pending, enrolled)
- Student document management
- Counselor assignment
- Student portal for self-service

#### 3.1.2 Application Management
- University application tracking
- Application status workflow (draft → submitted → under review → accepted/rejected)
- Multiple application support per student
- Application document linking

#### 3.1.3 Document Management
- Document upload and storage
- Document verification workflow
- Document checklist management
- Multiple document types support

#### 3.1.4 Visa Application Management
- Visa application tracking
- Embassy information management
- Interview scheduling
- Visa status updates

#### 3.1.5 Payment Management
- Payment tracking and recording
- Multiple payment types (application fee, tuition fee, etc.)
- Payment status tracking (pending, partial, completed, overdue)
- Payment history and receipts

#### 3.1.6 Task Management
- Task creation and assignment
- Task priority levels (high, medium, low)
- Task status tracking (pending, in_progress, completed, overdue)
- Due date management

#### 3.1.7 Communication Management
- Multi-channel communication (email, phone, WhatsApp, SMS, meeting, note)
- Communication direction tracking (incoming/outgoing)
- Follow-up management
- Communication history

#### 3.1.8 Counselor Management
- Counselor profile management
- Student assignment to counselors
- Counselor specialization tracking
- Counselor portal

#### 3.1.9 University Management
- University information database
- Program details
- Tuition and fee information
- Contact information

#### 3.1.10 Employee Management
- Employee profile management
- Attendance tracking
- Department and position management
- Employee portal

#### 3.1.11 Teacher Management
- Teacher profile and course assignments
- Teacher attendance tracking
- Payment calculation based on hours worked
- Teacher portal

#### 3.1.12 Course Management
- Course creation and management
- Course-teacher assignments
- Student enrollment tracking
- Course fee management

#### 3.1.13 Reporting System
- Student reports
- Application reports
- Financial reports
- Visa application reports
- Attendance reports

#### 3.1.14 Inquiry Management
- Lead capture and management
- Inquiry conversion to student
- Inquiry assignment to counselors
- Follow-up tracking

---

## 4. User Roles & Portals

### 4.1 Role-Based Access Control

The system supports 8 distinct user roles, each with dedicated portals:

#### 4.1.1 Super Admin (Role ID: 1)
**Portal:** Consultancy Dashboard (`/consultancy/dashboard`)

**Permissions:**
- Full system access
- User management
- University management
- All consultancy operations
- System configuration

**Features:**
- Complete student management
- Application management
- Document verification
- Payment processing
- Task assignment
- Communication management
- Counselor management
- Employee management
- Reports generation
- Consultancy profile management

#### 4.1.2 Admin (Role ID: 2)
**Portal:** Consultancy Dashboard (`/consultancy/dashboard`)

**Permissions:**
- All consultancy operations (same as Super Admin)
- Cannot manage users or universities

**Features:**
- All features available to Super Admin except:
  - User management
  - University management

#### 4.1.3 Editor (Role ID: 3)
**Portal:** Editor Portal (`/editor/dashboard`)

**Permissions:**
- View-only access to most data
- Limited editing capabilities

**Features:**
- View students, applications, inquiries
- View tasks
- Profile management

#### 4.1.4 Student (Role ID: 4)
**Portal:** Student Portal (`/portal/dashboard`)

**Permissions:**
- Access to own data only
- Self-service capabilities

**Features:**
- View personal dashboard
- View application status
- Upload documents
- View payment history
- View messages from counselors
- Update contact information

#### 4.1.5 Employee (Role ID: 5)
**Portal:** Employee Portal (`/employee/dashboard`)

**Permissions:**
- Access to own attendance and profile

**Features:**
- View attendance records
- View attendance statistics
- Update personal profile
- View employment information

#### 4.1.6 Teacher (Role ID: 6)
**Portal:** Teacher Portal (`/teacher/dashboard`)

**Permissions:**
- Access to assigned courses and own data

**Features:**
- View assigned courses
- Mark attendance
- View attendance history
- View payment estimates
- Update profile

#### 4.1.7 HR (Role ID: 7)
**Portal:** HR Portal (`/hr/dashboard`)

**Permissions:**
- Access to employee and attendance data

**Features:**
- View all employees
- View attendance overview
- Track attendance statistics
- Monitor attendance rates
- Profile management

#### 4.1.8 Counselor (Role ID: 8)
**Portal:** Counselor Portal (`/counselor/dashboard`)

**Permissions:**
- Access to assigned students and related data

**Features:**
- View assigned students
- Manage student applications
- View and manage tasks
- View communications
- Update profile

### 4.2 Portal URLs

| Role | Portal URL | Dashboard Route |
|------|------------|-----------------|
| Super Admin | `/consultancy/dashboard` | `consultancy.dashboard` |
| Admin | `/consultancy/dashboard` | `consultancy.dashboard` |
| Editor | `/editor/dashboard` | `editor.dashboard` |
| Student | `/portal/dashboard` | `portal.dashboard` |
| Employee | `/employee/dashboard` | `employee.dashboard` |
| Teacher | `/teacher/dashboard` | `teacher.dashboard` |
| HR | `/hr/dashboard` | `hr.dashboard` |
| Counselor | `/counselor/dashboard` | `counselor.dashboard` |

---

## 5. Installation & Setup

### 5.1 Prerequisites

- PHP >= 8.0.2
- Composer
- Node.js >= 14.x and NPM
- MySQL/MariaDB >= 5.7
- Web server (Apache/Nginx) or PHP built-in server

### 5.2 Installation Steps

#### Step 1: Clone Repository
```bash
git clone <repository-url>
cd consultancy
```

#### Step 2: Install PHP Dependencies
```bash
composer install
```

#### Step 3: Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=consultancy
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### Step 4: Database Setup
```bash
php artisan migrate
```

#### Step 5: Seed Demo Data (Optional)
```bash
php artisan db:seed
```

#### Step 6: Install Frontend Dependencies
```bash
npm install
```

#### Step 7: Build Assets
```bash
# For production
npm run build

# For development (with hot reload)
npm run dev
```

#### Step 8: Start Development Server
```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

### 5.3 Default Login Credentials

After seeding demo data:

**Super Admin:**
- Email: `admin@consultancy2.com`
- Password: `password`

**Student:**
- Email: `rajesh.kumar@student.com`
- Password: `password`

**Teacher:**
- Email: `suresh.adhikari@consultancy.com`
- Password: `password`

**Counselor:**
- Email: `lisa.anderson@consultancy.com`
- Password: `password`

---

## 6. Database Structure

### 6.1 Core Tables

#### Users & Authentication
- `users` - User accounts
- `roles` - User roles
- `sessions` - Active sessions

#### Student Management
- `students` - Student profiles
- `inquiries` - Student inquiries
- `applications` - University applications
- `visa_applications` - Visa applications
- `documents` - Student documents

#### Staff Management
- `employees` - Employee records
- `counselors` - Counselor profiles
- `employee_attendances` - Attendance records

#### Course Management
- `courses` - Course information
- `teacher_courses` - Teacher-course assignments

#### Financial
- `payments` - Payment records

#### Operations
- `tasks` - Task management
- `communications` - Communication logs

#### Configuration
- `universities` - University database
- `consultancy_profiles` - Company profile

### 6.2 Key Relationships

- **User → Student:** One-to-One
- **User → Employee:** One-to-One
- **User → Counselor:** One-to-One (via Employee)
- **Student → Counselor:** Many-to-One
- **Student → Applications:** One-to-Many
- **Student → Documents:** One-to-Many
- **Student → Payments:** One-to-Many
- **Employee → Attendances:** One-to-Many
- **Teacher → Courses:** Many-to-Many (via teacher_courses)
- **Application → University:** Many-to-One

---

## 7. API & Routes Documentation

### 7.1 Route Groups

#### Public Routes
- `GET /` - Home page

#### Authentication Routes
- `GET /login` - Login page
- `POST /login` - Login handler
- `POST /logout` - Logout
- `GET /register` - Registration page
- `POST /register` - Registration handler

#### Consultancy Routes (Roles 1, 2)
Prefix: `/consultancy`

- `GET /dashboard` - Main dashboard
- `GET /students` - List students
- `POST /students` - Create student
- `GET /students/{id}` - View student
- `PUT /students/{id}` - Update student
- `DELETE /students/{id}` - Delete student
- Similar routes for: inquiries, applications, documents, visa, payments, tasks, communications, counselors, employees, reports

#### Student Portal Routes (Role 4)
Prefix: `/portal`

- `GET /dashboard` - Student dashboard
- `GET /profile` - View profile
- `PUT /profile` - Update profile
- `GET /documents` - View documents
- `POST /documents` - Upload document
- `GET /applications` - View applications
- `GET /payments` - View payments
- `GET /messages` - View messages
- `POST /messages` - Send message

#### Teacher Portal Routes (Role 6)
Prefix: `/teacher`

- `GET /dashboard` - Teacher dashboard
- `GET /courses` - View assigned courses
- `GET /attendance` - View attendance
- `POST /attendance` - Mark attendance
- `GET /payments` - View payment estimates
- `GET /profile` - View profile
- `PUT /profile` - Update profile

#### Editor Portal Routes (Role 3)
Prefix: `/editor`

- `GET /dashboard` - Editor dashboard
- `GET /profile` - View profile
- `PUT /profile` - Update profile

#### Employee Portal Routes (Role 5)
Prefix: `/employee`

- `GET /dashboard` - Employee dashboard
- `GET /attendance` - View attendance
- `GET /profile` - View profile
- `PUT /profile` - Update profile

#### HR Portal Routes (Role 7)
Prefix: `/hr`

- `GET /dashboard` - HR dashboard
- `GET /employees` - View employees
- `GET /attendance` - Attendance overview
- `GET /profile` - View profile
- `PUT /profile` - Update profile

#### Counselor Portal Routes (Role 8)
Prefix: `/counselor`

- `GET /dashboard` - Counselor dashboard
- `GET /students` - View assigned students
- `GET /applications` - View applications
- `GET /tasks` - View tasks
- `GET /messages` - View messages
- `GET /profile` - View profile
- `PUT /profile` - Update profile

### 7.2 Middleware

- `auth` - Requires authentication
- `verified` - Requires verified email
- `role:X` - Requires specific role(s)

---

## 8. Configuration

### 8.1 Environment Variables

Key environment variables in `.env`:

```env
APP_NAME="Consultancy Management System"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=consultancy
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@consultancy.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 8.2 Application Configuration

Main configuration files in `config/`:
- `app.php` - Application settings
- `database.php` - Database configuration
- `auth.php` - Authentication settings
- `mail.php` - Email configuration

---

## 9. Deployment Guide

### 9.1 Production Checklist

1. **Environment Setup**
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Generate secure `APP_KEY`

2. **Database**
   - Run migrations: `php artisan migrate --force`
   - Seed initial data if needed

3. **Assets**
   - Build production assets: `npm run build`
   - Optimize assets: `php artisan optimize`

4. **Permissions**
   - Set proper file permissions
   - Ensure storage and cache directories are writable

5. **Security**
   - Enable HTTPS
   - Configure firewall
   - Set secure session cookies

### 9.2 Server Requirements

- PHP 8.0.2+
- MySQL 5.7+ or MariaDB 10.3+
- Web server (Apache/Nginx)
- SSL certificate (recommended)

### 9.3 Optimization Commands

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

---

## 10. Troubleshooting

### 10.1 Common Issues

#### Issue: "Route not found"
**Solution:** Clear route cache
```bash
php artisan route:clear
php artisan cache:clear
```

#### Issue: "Class not found"
**Solution:** Regenerate autoloader
```bash
composer dump-autoload
```

#### Issue: "Permission denied"
**Solution:** Set proper permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### Issue: "Session limit reached"
**Solution:** The system limits users to 2 concurrent sessions. Logout from other devices.

#### Issue: "Column not found"
**Solution:** Run migrations
```bash
php artisan migrate:fresh
php artisan db:seed
```

### 10.2 Debug Mode

Enable debug mode in `.env`:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

Check logs in `storage/logs/laravel.log`

---

## 11. Development Guidelines

### 11.1 Code Standards

- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Follow Laravel conventions

### 11.2 Database Migrations

- Always create migrations for schema changes
- Use descriptive migration names
- Include rollback logic in `down()` method

### 11.3 Testing

Run tests:
```bash
php artisan test
```

### 11.4 Version Control

- Use meaningful commit messages
- Create feature branches
- Test before merging

---

## 12. Additional Resources

### 12.1 Documentation Files

- `README.md` - Basic project information
- `BUILD_INSTRUCTIONS.md` - Build setup guide
- `DEMO_DATA_README.md` - Demo data information
- `PROJECT_DOCUMENTATION.md` - This file

### 12.2 Support

For issues or questions:
1. Check this documentation
2. Review Laravel documentation: https://laravel.com/docs
3. Check application logs: `storage/logs/`

---

## Appendix A: Database Schema Overview

### Key Tables and Fields

**users**
- id, name, email, password, role_id, email_verified_at

**students**
- id, user_id, counselor_id, first_name, last_name, email, phone, status, student_id

**applications**
- id, student_id, university_id, counselor_id, status, course_type, intake

**payments**
- id, student_id, application_id, amount, status, payment_id

**employees**
- id, user_id, employee_id, first_name, last_name, position, department, status

**courses**
- id, course_code, course_name, level, duration_hours, fee, status

**teacher_courses**
- teacher_id, course_id, hourly_rate, hours_per_week, status

---

## Appendix B: Role Permissions Matrix

| Feature | Super Admin | Admin | Editor | Student | Employee | Teacher | HR | Counselor |
|---------|-------------|-------|--------|---------|----------|---------|----|-----------|
| User Management | ✓ | ✗ | ✗ | ✗ | ✗ | ✗ | ✗ | ✗ |
| Student Management | ✓ | ✓ | View | Own | ✗ | ✗ | ✗ | Assigned |
| Application Management | ✓ | ✓ | View | Own | ✗ | ✗ | ✗ | Assigned |
| Payment Management | ✓ | ✓ | View | Own | ✗ | ✗ | ✗ | ✗ |
| Document Management | ✓ | ✓ | View | Own | ✗ | ✗ | ✗ | Assigned |
| Task Management | ✓ | ✓ | View | ✗ | ✗ | ✗ | ✗ | Assigned |
| Communication | ✓ | ✓ | View | Own | ✗ | ✗ | ✗ | Assigned |
| Reports | ✓ | ✓ | View | ✗ | ✗ | ✗ | ✗ | ✗ |
| Employee Management | ✓ | ✓ | ✗ | ✗ | ✗ | ✗ | View | ✗ |
| Attendance | ✓ | ✓ | ✗ | ✗ | Own | Own | All | ✗ |
| Course Management | ✓ | ✓ | ✗ | ✗ | ✗ | Assigned | ✗ | ✗ |
| University Management | ✓ | ✗ | ✗ | ✗ | ✗ | ✗ | ✗ | ✗ |

---

**Document Version:** 1.0  
**Last Updated:** January 2026  
**Maintained By:** Development Team
