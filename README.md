# Consultancy Management System

A comprehensive consultancy management system built with Laravel for managing students, applications, documents, payments, and communications.

## Features

- **Student Management**: Manage student profiles and information
- **Application Management**: Track and manage student applications
- **Document Management**: Handle document uploads and verification
- **Visa Application Management**: Manage visa application processes
- **Payment Management**: Track payments and installments
- **Task Management**: Create and manage tasks
- **Communication**: Handle communications and follow-ups
- **Counselor Management**: Manage counselor assignments
- **University Management**: Manage university information
- **Reports**: Generate various reports for students, applications, financials, and visas
- **Student Portal**: Self-service portal for students

## Requirements

- PHP >= 8.0.2
- Laravel >= 9.19
- Composer
- Node.js and NPM

## Installation

1. Clone the repository
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env` and configure your database
4. Generate application key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Install frontend dependencies: `npm install`
7. Build assets: `npm run build` or `npm run dev`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
