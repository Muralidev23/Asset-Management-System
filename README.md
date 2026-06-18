<div align="center">

# 🏢 AssetFlow — Employee & Asset Management System

**A professional Employee & Asset Management System built with Laravel, designed to help organizations track employees, manage hardware inventory, assign assets, and maintain a full audit trail.**

[![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-8.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

</div>

---

## 📋 Table of Contents

- [About the Project](#-about-the-project)
- [Features](#-features)
- [Technology Stack](#-technology-stack)
- [Database Schema](#-database-schema)
- [Project Structure](#-project-structure)
- [Getting Started](#-getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Running the App](#running-the-app)
- [Default Credentials](#-default-credentials)
- [Usage Guide](#-usage-guide)
- [Screenshots](#-screenshots)
- [API / Routes Reference](#-routes-reference)
- [Contributing](#-contributing)
- [License](#-license)

---

## 📖 About the Project

**AssetFlow** is a full-featured Employee & Asset Management System built as an interview/task project. It allows an **Admin** to manage a company's workforce and hardware inventory in one place — from onboarding employees and bulk importing records via CSV, to assigning laptops, monitors, and other hardware to specific employees with a complete audit history.

Employees can also **self-register** and view their own dashboard, seeing what assets are assigned to them and their personal transaction history.

---

## ✨ Features

### 👤 Authentication & Roles
- Secure login via **Laravel Breeze** authentication
- Two roles: **Admin** and **Employee**
- Role-based route protection via custom middleware
- Employee self-registration with profile details

### 🧑‍💼 Employee Management (Admin)
- ✅ Create, Read, Update, Delete employee profiles
- ✅ Bulk import employees via **CSV upload** (with validation & error reporting)
- ✅ Download pre-formatted **CSV template** for bulk upload
- ✅ Auto-create login accounts for each employee
- ✅ View employee profile with currently assigned assets
- ✅ Return assets directly from the employee profile page

### 💻 Asset Management (Admin)
- ✅ Register hardware assets (Laptop, Monitor, Keyboard, Mouse, Headset, Mobile Phone, Other)
- ✅ View full asset inventory with status badges (Available / Assigned)
- ✅ **Assign assets** to employees with a single click
- ✅ **Return assets** back to the available pool
- ✅ Full **Asset History** — every assignment and return is logged with timestamp, employee name, and notes
- ✅ Edit and delete assets

### 📊 Admin Dashboard
- Summary stat cards with live counts
- Asset utilisation percentage indicator
- **Chart.js** charts:
  - 🍩 Donut chart — Asset distribution (Assigned vs Available)
  - 📊 Bar chart — Activity timeline (assignments & returns by date)
- Recent activity feed showing the last 5 events
- Quick action buttons for common tasks

### 🙋 Employee Dashboard
- Personal profile information
- List of currently assigned hardware
- Complete personal asset transaction history

---

## 🛠 Technology Stack

| Layer          | Technology                        |
|----------------|-----------------------------------|
| **Backend**    | PHP 8.0+, Laravel 8.x             |
| **Auth**       | Laravel Breeze                    |
| **Frontend**   | Blade Templates, Bootstrap 5.3    |
| **Fonts**      | Google Fonts — Poppins            |
| **Icons**      | Font Awesome 6                    |
| **Charts**     | Chart.js 4.4                      |
| **Database**   | MySQL 8.0                         |
| **ORM**        | Laravel Eloquent                  |
| **Dev Server** | XAMPP / PHP built-in server       |

---

## 🗄 Database Schema

Only **3 database tables** are used as per requirements:

### `users`
| Column       | Type      | Notes                        |
|--------------|-----------|------------------------------|
| `id`         | BIGINT PK | Auto-increment               |
| `name`       | VARCHAR   | Full name                    |
| `email`      | VARCHAR   | Unique, used for login       |
| `password`   | VARCHAR   | Bcrypt hashed                |
| `role`       | ENUM      | `admin` or `employee`        |
| `timestamps` | —         | created_at, updated_at       |

### `employees`
| Column        | Type      | Notes                              |
|---------------|-----------|------------------------------------|
| `id`          | BIGINT PK | Auto-increment                     |
| `user_id`     | BIGINT FK | References `users.id`, nullable    |
| `emp_id`      | VARCHAR   | Unique, e.g. `EMP-001`             |
| `name`        | VARCHAR   | Display name                       |
| `department`  | VARCHAR   | e.g. Technology                    |
| `designation` | VARCHAR   | e.g. Software Engineer             |
| `emp_role`    | VARCHAR   | e.g. Full Stack Developer          |
| `doj`         | DATE      | Date of joining                    |
| `timestamps`  | —         | created_at, updated_at             |

### `assets`
| Column          | Type      | Notes                                        |
|-----------------|-----------|----------------------------------------------|
| `id`            | BIGINT PK | Auto-increment                               |
| `asset_id`      | VARCHAR   | Unique code, e.g. `AST-001`                  |
| `name`          | VARCHAR   | Device name, e.g. MacBook Pro M2             |
| `type`          | VARCHAR   | Laptop / Monitor / Keyboard / etc.           |
| `serial_number` | VARCHAR   | Unique hardware serial                       |
| `status`        | ENUM      | `available` or `assigned`                   |
| `employee_id`   | BIGINT FK | References `employees.id`, nullable          |
| `history`       | JSON      | Full audit log of all assignment/return events |
| `timestamps`    | —         | created_at, updated_at                       |

> **Note:** Asset history (assignments & returns) is stored as a **JSON column** within the `assets` table, keeping the schema to exactly 3 tables as required.

---

## 📁 Project Structure

```
tecdata-task/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── RegisteredUserController.php   # Employee self-registration
│   │   │   ├── AdminDashboardController.php        # Admin dashboard stats & charts
│   │   │   ├── AssetController.php                 # Asset CRUD, assign, return, history
│   │   │   ├── EmployeeController.php              # Employee CRUD & bulk CSV upload
│   │   │   └── EmployeeDashboardController.php     # Employee self-service dashboard
│   │   └── Middleware/
│   │       └── AdminMiddleware.php                 # Restricts admin-only routes
│   └── Models/
│       ├── User.php
│       ├── Employee.php
│       └── Asset.php
├── database/
│   ├── migrations/
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_employees_table.php
│   │   └── ..._create_assets_table.php
│   └── seeders/
│       └── DatabaseSeeder.php                     # Seeds default admin account
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php                          # Main layout with sidebar
│   ├── auth/
│   │   ├── login.blade.php                        # Split-screen login page
│   │   └── register.blade.php                     # Employee registration form
│   ├── admin/
│   │   ├── dashboard.blade.php                    # Admin dashboard with charts
│   │   ├── employees/                             # Employee CRUD views
│   │   └── assets/                                # Asset CRUD & history views
│   └── employee/
│       └── dashboard.blade.php                    # Employee self-service dashboard
├── routes/
│   ├── web.php                                    # Main routes (admin & employee groups)
│   └── auth.php                                   # Breeze authentication routes
├── test_employees.csv                             # Sample CSV file for bulk upload testing
└── .env                                           # Environment configuration
```

---

## 🚀 Getting Started

### Prerequisites

Make sure you have the following installed:

- **PHP** >= 8.0
- **Composer** >= 2.0
- **MySQL** >= 8.0 (or MariaDB)
- **XAMPP** (recommended) or any LAMP/LEMP stack

---

### Installation

**1. Clone the repository**
```bash
git clone https://github.com/your-username/tecdata-task.git
cd tecdata-task
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Copy the environment file**
```bash
cp .env.example .env
```

**4. Generate the application key**
```bash
php artisan key:generate
```

**5. Configure the database**

Open `.env` and update the database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tecdata_task
DB_USERNAME=root
DB_PASSWORD=
```

**6. Create the database**

Using MySQL CLI or phpMyAdmin, create a database named `tecdata_task`:
```sql
CREATE DATABASE tecdata_task;
```

Or via MySQL CLI:
```bash
mysql -u root -e "CREATE DATABASE tecdata_task;"
```

**7. Run migrations and seed the database**
```bash
php artisan migrate --seed
```

This will:
- Create all 3 tables (`users`, `employees`, `assets`)
- Seed a default **admin account**

---

### Running the App

**Option A — Using XAMPP (recommended)**

Place the project inside `C:\xampp8.2\htdocs\tecdata-task` and access it at:
```
http://localhost/tecdata-task/public/
```

**Option B — Using PHP built-in server**
```bash
php artisan serve
```
Then open: `http://localhost:8000`

---

## 🔑 Default Credentials

After running `php artisan migrate --seed`, the following admin account is created:

| Role      | Email                    | Password   |
|-----------|--------------------------|------------|
| **Admin** | `admin@example.com`      | `admin123` |

> ⚠️ **Change the admin password after first login in a production environment.**

Employees can **self-register** via the `/register` route, or be added/imported by the admin.

---

## 📖 Usage Guide

### Admin Workflow

1. **Login** at `/login` using the admin credentials above
2. **Dashboard** — View live stats, charts, and recent activity
3. **Employees** → Add single employee or bulk upload via CSV
   - Download the CSV template first
   - Fill in employee data (one row per employee)
   - Upload the filled CSV to create all accounts at once
4. **Assets** → Register hardware devices, then assign them to employees
5. **Asset History** → Click the history icon on any asset to view its full audit log

### Employee Workflow

1. **Self-register** at `/register` with your employee details
2. **Login** — Redirected to your personal dashboard
3. **Dashboard** — View your profile, assigned assets, and transaction history

---

## 📸 Screenshots

> Run the project locally to see the full UI.

| Page | Description |
|------|-------------|
| 🔐 Login | Split-screen design with feature highlights and sign-in form |
| 📊 Dashboard | KPI strip, gradient stat cards, Chart.js charts, activity feed |
| 👥 Employees | Searchable table with avatar initials and action buttons |
| 💻 Assets | Inventory table with assign/return inline actions |
| 📋 Asset History | Timeline of all assignment and return events |
| 🙋 Employee Portal | Personal dashboard with assigned hardware and logs |

---

## 🗺 Routes Reference

### Public Routes
| Method | URI         | Description              |
|--------|-------------|--------------------------|
| GET    | `/`         | Redirects to login       |
| GET    | `/login`    | Login page               |
| POST   | `/login`    | Authenticate user        |
| GET    | `/register` | Employee self-register   |
| POST   | `/register` | Create employee account  |
| POST   | `/logout`   | Log out                  |

### Admin Routes (requires `auth` + `admin` middleware)
| Method    | URI                              | Description                     |
|-----------|----------------------------------|---------------------------------|
| GET       | `/admin/dashboard`               | Admin dashboard with charts     |
| GET/POST  | `/admin/employees`               | List / create employees         |
| GET/PUT   | `/admin/employees/{id}/edit`     | Edit employee                   |
| DELETE    | `/admin/employees/{id}`          | Delete employee                 |
| GET       | `/admin/employees/upload`        | Bulk upload form                |
| POST      | `/admin/employees/upload`        | Process CSV import              |
| GET       | `/admin/employees/download-template` | Download CSV template       |
| GET/POST  | `/admin/assets`                  | List / create assets            |
| PUT       | `/admin/assets/{id}`             | Update asset                    |
| DELETE    | `/admin/assets/{id}`             | Delete asset                    |
| POST      | `/admin/assets/{id}/assign`      | Assign asset to employee        |
| POST      | `/admin/assets/{id}/return`      | Return asset to pool            |
| GET       | `/admin/assets/{id}/history`     | View asset assignment history   |

### Employee Routes (requires `auth` middleware)
| Method | URI                    | Description              |
|--------|------------------------|--------------------------|
| GET    | `/employee/dashboard`  | Employee self-service    |

---

## 📄 CSV Bulk Upload Format

Download the template from the admin panel or use this column structure:

```csv
name,email,password,emp_id,department,designation,emp_role,doj
John Doe,john@company.com,Secret123,EMP-001,Technology,Software Engineer,Full Stack Developer,2024-01-15
Jane Smith,jane@company.com,Secret123,EMP-002,HR,HR Manager,Talent Acquisition,2024-02-01
```

> All fields are **required**. The system validates each row and rolls back the entire import if any row is invalid, reporting all errors.

---

## 🤝 Contributing

Contributions, issues and feature requests are welcome!

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📜 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

<div align="center">

**Built with ❤️ using Laravel 8 · Bootstrap 5 · Chart.js · Font Awesome**

</div>
