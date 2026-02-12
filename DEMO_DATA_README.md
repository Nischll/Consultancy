# Demo Data Seeder

This seeder creates comprehensive dummy data for all tables in the consultancy management system.

## What Data is Created

### Users & Roles
- **Roles**: Super Admin, Admin, Editor, Student, Employee, Teacher, HR, Counselor
- **Users**: 
  - 2 Admin users
  - 8 Student users
  - 3 Employee users
  - 2 Counselor users
  - 3 Teacher users

### Students
- 8 students with complete profiles
- Linked to user accounts
- Assigned to counselors
- Various statuses (active, inactive, pending, enrolled)

### Employees
- 3 employees with job details
- Different positions and departments
- Employment history

### Counselors
- 2 counselors with specializations
- Linked to employee records
- Active and ready to assist students

### Teachers
- 3 teachers with employee records
- Positions: Japanese Language Teacher, English Teacher, IELTS Instructor
- Each assigned to 2–4 courses (Japanese, English, IELTS, JLPT prep)
- 22 days of attendance records per teacher (present, late, absent, on_leave)

### Universities
- 5 Japanese universities
- Complete information including tuition, programs, contact details
- Featured universities marked

### Consultancy Profile
- Complete company profile
- Services, contact information, social media links

### Applications
- Multiple university applications
- Various statuses (draft, submitted, under review, accepted, rejected)
- Linked to students and universities

### Documents
- 3-6 documents per student
- Various document types (passport, transcript, diploma, etc.)
- Different verification statuses

### Inquiries
- 15 inquiries from potential students
- Various types and priorities
- Assigned to counselors

### Visa Applications
- Visa applications for accepted students
- Various stages of processing
- Embassy locations and interview schedules

### Payments
- Application fees
- Tuition fees
- Various payment statuses
- Payment methods and records

### Tasks
- 2-5 tasks per student
- Different priorities and statuses
- Assigned to counselors and admins

### Communications
- 3-8 communications per student
- Various types (email, phone, meeting, message)
- Follow-up tracking

### Employee Attendances
- 20 attendance records per employee
- Check-in/check-out times
- Hours worked calculations

### Courses
- 7 courses (Japanese Beginner/Intermediate/Advanced, English Foundation, IELTS, JLPT N5/N4)
- Course codes, levels, duration, fees in NPR
- Status: active or draft

### Teacher–Course Assignments
- Each teacher assigned to 2–4 courses
- Hourly rate and hours per week per course
- Status: active or assigned

### Teacher Attendances
- 22 attendance records per teacher
- Statuses: present, late, absent, on_leave
- Check-in/check-out and hours worked when present

## How to Run

### Option 1: Run All Seeders (Recommended)
```bash
php artisan db:seed
```

This will run the DatabaseSeeder which includes the DemoDataSeeder.

### Option 2: Run Only Demo Data Seeder
```bash
php artisan db:seed --class=DemoDataSeeder
```

### Option 3: Fresh Migration with Demo Data
```bash
php artisan migrate:fresh --seed
```

**Warning**: This will delete all existing data and recreate the database with demo data.

## Default Login Credentials

After seeding, you can login with:

- **Admin**: 
  - Email: `admin@consultancy.com`
  - Password: `password`

- **Manager**: 
  - Email: `manager@consultancy.com`
  - Password: `password`

- **Students**: 
  - Email: `rajesh.kumar@student.com` (or any student email)
  - Password: `password`

- **Employees**: 
  - Email: `sarah.johnson@consultancy.com` (or any employee email)
  - Password: `password`

- **Counselors**: 
  - Email: `lisa.anderson@consultancy.com` (or any counselor email)
  - Password: `password`

- **Teachers**: 
  - Email: `suresh.adhikari@consultancy.com` (or `anu.pandey@consultancy.com`, `bimal.thapa@consultancy.com`)
  - Password: `password`
  - Teachers can log in and use the Teacher Portal at `/teacher/dashboard`.

## Notes

- All passwords are set to: `password`
- Student IDs are auto-generated (STU-YYYY-####)
- Application IDs are auto-generated (APP-YYYY-####)
- Payment IDs are auto-generated (PAY-YYYY-####)
- Visa Application IDs are auto-generated (VISA-YYYY-####)
- Inquiry IDs are auto-generated (INQ-YYYY-####)

## Data Relationships

The seeder maintains proper relationships:
- Students are linked to Users and Counselors
- Employees are linked to Users
- Counselors are linked to Users and Employees
- Applications link Students, Universities, and Counselors
- Documents belong to Students
- Payments belong to Students and Applications
- Tasks are assigned to Users and linked to Students/Applications
- Communications link Students and Users (Counselors)
- Employee Attendances belong to Employees
- Teachers are Employees with role_id 6; each has an Employee record
- Courses are assigned to teachers via the teacher_courses pivot (hourly_rate, hours_per_week)
- Teacher attendances use the same employee_attendances table (employee_id = teacher’s Employee id)

## Customization

You can modify the `DemoDataSeeder.php` file to:
- Change the number of records created
- Modify the data values
- Add more variations
- Adjust relationships
