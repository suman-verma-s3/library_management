# Library Management System

A complete Library Management System built with Laravel 12, MySQL, and Bootstrap 5.

## Features

### Admin
- Category management (CRUD)
- Book management (CRUD)
- Physical copies management with unique accession numbers
- Dashboard with real-time stats
- Inventory reports

### Librarian
- Student management (CRUD)
- Issue books (transaction-safe, prevents double issue)
- Return books (preserves history)
- Borrowing history tracking
- Overdue tracking

### Reports
- Currently Issued Books
- Overdue Books
- Student Borrowing History
- Inventory Summary

### Security
- Login / Logout with hashed passwords
- Role-based access control (Admin, Librarian)
- CSRF protection
- DB transactions with row locking for issue/return
- Input validation on all forms

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2
- **Database:** MySQL
- **Frontend:** Blade, Bootstrap 5, Bootstrap Icons
- **Auth:** Laravel Breeze
- **Roles:** Spatie Laravel Permission

## Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR-USERNAME/library-management.git
   cd library-management