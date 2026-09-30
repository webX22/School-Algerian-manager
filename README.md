# 🏫 School Algerian Manager

<p align="center">
  <strong>A complete school management system built with Laravel, MySQL, PHP, JavaScript, and Tailwind CSS.</strong>
</p>

<p align="center">
  Manage administrators, school staff, students, classes, meals, menus, reservations, and school-related operations from one centralized platform.
</p>

<p align="center">

![Laravel](https://img.shields.io/badge/Laravel-PHP-red?style=for-the-badge\&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge\&logo=php\&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge\&logo=mysql\&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge\&logo=javascript\&logoColor=black)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-UI-06B6D4?style=for-the-badge\&logo=tailwindcss\&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-Build_Tool-646CFF?style=for-the-badge\&logo=vite\&logoColor=white)
![Git](https://img.shields.io/badge/Git-Version_Control-F05032?style=for-the-badge\&logo=git\&logoColor=white)
![GitHub](https://img.shields.io/badge/GitHub-Repository-181717?style=for-the-badge\&logo=github)

</p>

---

# 📋 Table of Contents

* [📖 About the Project](#-about-the-project)
* [✨ Features](#-features)
* [👥 User Roles](#-user-roles)
* [🔐 Login Pages](#-login-pages)
* [🛠️ Technologies](#️-technologies)
* [📁 Project Structure](#-project-structure)
* [💻 Requirements](#-requirements)
* [⚙️ Installation](#️-installation)
* [🗄️ Database Configuration](#️-database-configuration)
* [👤 Demo Accounts](#-demo-accounts)
* [🚀 Running the Application](#-running-the-application)
* [📸 Screenshots](#-screenshots)
* [🔧 Troubleshooting](#-troubleshooting)
* [🌐 GitHub Deployment](#-github-deployment)
* [🔒 Security](#-security)
* [📌 Development Workflow](#-development-workflow)
* [📄 License](#-license)

---

# 📖 About the Project

**School Algerian Manager** is a web-based school management system designed to centralize and simplify common school administration tasks.

The application provides different dashboards depending on the user's role:

* 👨‍💼 Administrator
* 🧑‍💼 Gestionnaire / Manager
* 🎓 Student

Each role receives access to the features and pages appropriate for that account.

The system is designed as a practical Laravel project that can be used for:

* School administration
* Student management
* Class management
* Meal and menu management
* Food reservations
* School staff management
* Student dashboards
* Administrative dashboards
* Portfolio demonstration
* Laravel development practice

---

# ✨ Features

## 👨‍💼 Administrator

The administrator dashboard provides centralized control over the school system.

Possible administration features include:

* Dashboard overview
* Student management
* User management
* School class management
* Menu management
* Dish management
* Meal distribution
* Reservations
* Administrative controls
* System statistics

---

## 🧑‍💼 Gestionnaire

The Gestionnaire dashboard is designed for staff members responsible for operational school activities.

Features include:

* Dashboard
* Student-related management
* Menu management
* Dish management
* Meal distribution
* Reservations
* School operations

---

## 🎓 Student

Students have their own dedicated dashboard.

Student functionality includes:

* Student dashboard
* Personal information
* School class information
* Menu information
* Meal reservations
* Available school services

---

# 👥 User Roles

The application uses role-based access control.

| Role           | Description                          |
| -------------- | ------------------------------------ |
| `admin`        | Full administrative access           |
| `gestionnaire` | School management/operational access |
| `eleve`        | Student access                       |

The role is associated with the authenticated user.

The application uses the user's role to determine which dashboard and protected routes they can access.

---

# 🔐 Login Pages

The application provides three separate login areas.

## 👨‍💼 Administrator Login

```text
http://127.0.0.1:8000/admin/login/
```

Demo username:

```text
admin@admin.com
```

Demo password:

```text
password123!
```

---

## 🧑‍💼 Gestionnaire Login

```text
http://127.0.0.1:8000/gestionnaire/login/
```

Demo username:

```text
gst@gst.com
```

Demo password:

```text
password123!
```

---

## 🎓 Student Login

```text
http://127.0.0.1:8000/eleve/login/
```

Demo username:

```text
std@std.com
```

Demo password:

```text
password123!
```

> ⚠️ **Important:** These credentials are intended for local/demo development. Do not use these passwords for a production deployment. If this repository is public, replace them with safe demo credentials or remove the passwords from the README.

---

# 🛠️ Technologies

The project is built using the following technologies.

### Backend

* PHP
* Laravel
* Laravel Eloquent ORM
* Laravel Authentication
* Laravel Middleware
* REST-style application routes

### Database

* MySQL
* SQL
* Laravel Migrations
* Eloquent ORM

### Frontend

* HTML5
* CSS3
* JavaScript
* Tailwind CSS
* Vite

### Development Tools

* Composer
* npm
* Git
* GitHub
* Visual Studio Code

---

# 📁 Project Structure

The main project structure looks like this:

```text
School_manager/
│
├── app/
│   ├── Http/
│   ├── Models/
│   └── ...
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── Pictures/
│   ├── Admin dashboard/
│   │   ├── 1.png
│   │   ├── 2.png
│   │   ├── 3.png
│   │   ├── 4.png
│   │   ├── 5.png
│   │   ├── 6.png
│   │   ├── 7.png
│   │   └── 8.png
│   │
│   ├── Gestionnaire dashboard/
│   │   ├── 1.png
│   │   ├── 2.png
│   │   ├── 3.png
│   │   ├── 4.png
│   │   └── 5.png
│   │
│   └── Student dashboard/
│       ├── 1.png
│       ├── 2.png
│       └── 3.png
│
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
│
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── phpunit.xml
├── tailwind.config.js
├── postcss.config.js
└── vite.config.js
```

---

# 💻 Requirements

Before installing the project, make sure the following software is installed.

## PHP

Check:

```powershell
php -v
```

---

## Composer

Check:

```powershell
composer -V
```

Composer is required to install Laravel/PHP dependencies.

---

## MySQL

Check that MySQL is installed and running.

You can use:

* MySQL Workbench
* MySQL Server
* XAMPP
* WAMP
* Another MySQL-compatible environment

---

## Node.js

Check:

```powershell
node -v
```

---

## npm

Check:

```powershell
npm -v
```

---

## Git

Check:

```powershell
git --version
```

---

# ⚙️ Installation

## 1. Clone the Repository

Clone the GitHub repository:

```powershell
git clone https://github.com/webX22/School-Algerian-manager.git
```

Enter the project:

```powershell
cd School-Algerian-manager
```

If your local folder is already available, simply open it:

```powershell
cd D:\School-Algerian-manager\School_manager
```

---

# 2. Install PHP Dependencies

Run:

```powershell
composer install
```

This installs the packages defined in:

```text
composer.json
```

The `vendor/` directory is generated automatically.

> `vendor/` should not normally be uploaded to GitHub.

---

# 3. Install JavaScript Dependencies

Run:

```powershell
npm install
```

This installs the frontend dependencies from:

```text
package.json
```

The `node_modules/` directory is generated automatically.

> `node_modules/` should not normally be uploaded to GitHub.

---

# 4. Create the Environment File

Copy:

```text
.env.example
```

to:

```text
.env
```

PowerShell:

```powershell
Copy-Item .env.example .env
```

Or manually create `.env`.

---

# 5. Generate the Laravel Application Key

Run:

```powershell
php artisan key:generate
```

You should see:

```text
Application key set successfully.
```

---

# 🗄️ Database Configuration

This project uses MySQL.

Open:

```text
.env
```

Configure the database section.

Example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=madrassati
DB_USERNAME=root
DB_PASSWORD=
```

If your MySQL installation has a password, replace:

```env
DB_PASSWORD=
```

with your MySQL password.

---

# 🔎 Check Database Connection

After configuring `.env`, clear Laravel's cached configuration:

```powershell
php artisan optimize:clear
```

Then check migration status:

```powershell
php artisan migrate:status
```

If Laravel can communicate with MySQL, it should display the migration information.

---

# ⚠️ Existing Database

If you already have an existing database containing the project's tables and data, **do not create another database unnecessarily**.

Configure `.env` to point to the existing database.

For example:

```env
DB_DATABASE=madrassati
```

Then:

```powershell
php artisan optimize:clear
```

---

# 🧱 Creating Database Tables

If you are setting up the project from an empty database, Laravel migrations can create the tables.

Run:

```powershell
php artisan migrate
```

If the project includes seeders and you want to use them:

```powershell
php artisan db:seed
```

Or:

```powershell
php artisan migrate --seed
```

> ⚠️ Do not run destructive migration commands such as `migrate:fresh` on a database containing important data.

---

# 🔑 Authentication and Roles

The application uses user roles such as:

```text
admin
gestionnaire
eleve
```

The role determines which dashboard a user can access.

For example:

```text
admin
    ↓
Admin Dashboard

gestionnaire
    ↓
Gestionnaire Dashboard

eleve
    ↓
Student Dashboard
```

---

# 🚀 Running the Application

Laravel's development server can be started with:

```powershell
php artisan serve
```

You should get something similar to:

```text
Server running on [http://127.0.0.1:8000]
```

Open:

```text
http://127.0.0.1:8000
```

---

# 🎨 Running the Frontend

For Vite development:

```powershell
npm run dev
```

Keep this terminal running while developing the frontend.

You may need two terminals.

### Terminal 1

```powershell
php artisan serve
```

### Terminal 2

```powershell
npm run dev
```

---

# 🔐 Login URLs

After starting Laravel:

### Administrator

```text
http://127.0.0.1:8000/admin/login/
```

### Gestionnaire

```text
http://127.0.0.1:8000/gestionnaire/login/
```

### Student

```text
http://127.0.0.1:8000/eleve/login/
```

---

# 📸 Screenshots

The screenshots below are stored directly inside the repository.

---

# 👨‍💼 Admin Dashboard

## Admin Screenshot 1

<p align="center">
  <img src="./Pictures/Admin%20dashboard/1.png" width="90%" alt="Admin Dashboard Screenshot 1">
</p>

## Admin Screenshot 2

<p align="center">
  <img src="./Pictures/Admin%20dashboard/2.png" width="90%" alt="Admin Dashboard Screenshot 2">
</p>

## Admin Screenshot 3

<p align="center">
  <img src="./Pictures/Admin%20dashboard/3.png" width="90%" alt="Admin Dashboard Screenshot 3">
</p>

## Admin Screenshot 4

<p align="center">
  <img src="./Pictures/Admin%20dashboard/4.png" width="90%" alt="Admin Dashboard Screenshot 4">
</p>

## Admin Screenshot 5

<p align="center">
  <img src="./Pictures/Admin%20dashboard/5.png" width="90%" alt="Admin Dashboard Screenshot 5">
</p>

## Admin Screenshot 6

<p align="center">
  <img src="./Pictures/Admin%20dashboard/6.png" width="90%" alt="Admin Dashboard Screenshot 6">
</p>

## Admin Screenshot 7

<p align="center">
  <img src="./Pictures/Admin%20dashboard/7.png" width="90%" alt="Admin Dashboard Screenshot 7">
</p>

## Admin Screenshot 8

<p align="center">
  <img src="./Pictures/Admin%20dashboard/8.png" width="90%" alt="Admin Dashboard Screenshot 8">
</p>

---

# 🧑‍💼 Gestionnaire Dashboard

## Gestionnaire Screenshot 1

<p align="center">
  <img src="./Pictures/Gestionnaire%20dashboard/1.png" width="90%" alt="Gestionnaire Dashboard Screenshot 1">
</p>

## Gestionnaire Screenshot 2

<p align="center">
  <img src="./Pictures/Gestionnaire%20dashboard/2.png" width="90%" alt="Gestionnaire Dashboard Screenshot 2">
</p>

## Gestionnaire Screenshot 3

<p align="center">
  <img src="./Pictures/Gestionnaire%20dashboard/3.png" width="90%" alt="Gestionnaire Dashboard Screenshot 3">
</p>

## Gestionnaire Screenshot 4

<p align="center">
  <img src="./Pictures/Gestionnaire%20dashboard/4.png" width="90%" alt="Gestionnaire Dashboard Screenshot 4">
</p>

## Gestionnaire Screenshot 5

<p align="center">
  <img src="./Pictures/Gestionnaire%20dashboard/5.png" width="90%" alt="Gestionnaire Dashboard Screenshot 5">
</p>

---

# 🎓 Student Dashboard

## Student Screenshot 1

<p align="center">
  <img src="./Pictures/Student%20dashboard/1.png" width="90%" alt="Student Dashboard Screenshot 1">
</p>

## Student Screenshot 2

<p align="center">
  <img src="./Pictures/Student%20dashboard/2.png" width="90%" alt="Student Dashboard Screenshot 2">
</p>

## Student Screenshot 3

<p align="center">
  <img src="./Pictures/Student%20dashboard/3.png" width="90%" alt="Student Dashboard Screenshot 3">
</p>

---

# 🔧 Troubleshooting

## `vendor/autoload.php` does not exist

Run:

```powershell
composer install
```

---

## `php` is not recognized

PHP is not available in your system PATH.

Verify:

```powershell
php -v
```

If it fails, install PHP or add the PHP installation directory to Windows PATH.

---

## `composer` is not recognized

Verify:

```powershell
composer -V
```

Install Composer if necessary.

---

## `npm` is not recognized

Verify:

```powershell
node -v
npm -v
```

Install Node.js if necessary.

---

## Laravel uses SQLite instead of MySQL

Check `.env`.

Make sure:

```env
DB_CONNECTION=mysql
```

and not:

```env
DB_CONNECTION=sqlite
```

Then run:

```powershell
php artisan optimize:clear
```

---

## Database connection error

Check:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

Make sure MySQL is running.

---

## Table does not exist

Check migration status:

```powershell
php artisan migrate:status
```

If using a new empty database:

```powershell
php artisan migrate
```

---

## Changes to `.env` are not working

Laravel may have cached configuration.

Run:

```powershell
php artisan optimize:clear
```

Then restart the Laravel server:

```powershell
php artisan serve
```

---

## Vite is not working

Try:

```powershell
npm install
```

Then:

```powershell
npm run dev
```

---

# 🌐 GitHub Deployment

After making changes to the project:

Check the status:

```powershell
git status
```

Add changes:

```powershell
git add .
```

Create a commit:

```powershell
git commit -m "Update school management system"
```

Push:

```powershell
git push
```

---

# 📌 Git Workflow

A simple development workflow is:

```text
1. Edit project
       ↓
2. Test locally
       ↓
3. git status
       ↓
4. git add .
       ↓
5. git commit
       ↓
6. git push
       ↓
7. GitHub updated
```

Example:

```powershell
git status

git add .

git commit -m "Improve student dashboard"

git push
```

---

# 🔒 Security

Never upload your real `.env` file.

Your `.gitignore` should contain:

```gitignore
.env
/vendor/
/node_modules/
```

The `.env` file can contain:

* Database passwords
* API keys
* Application secrets
* Credentials
* Environment-specific configuration

Therefore:

```text
.env
```

should remain local.

The repository should contain:

```text
.env.example
```

instead.

---

# 📦 Important GitHub Files

The following files should normally be committed:

```text
composer.json
composer.lock
package.json
package-lock.json
artisan
.env.example
.gitignore
README.md
```

Generated dependency directories should normally not be committed:

```text
vendor/
node_modules/
```

---

# 🧪 Testing

Laravel testing can be executed using:

```powershell
php artisan test
```

Or:

```powershell
./vendor/bin/phpunit
```

---

# 🏗️ Production Build

Before deploying the frontend:

```powershell
npm run build
```

This creates the production frontend assets.

Do not use development commands as your production server configuration without appropriate deployment setup.

---

# 📊 Application Architecture

A simplified view of the application:

```text
                    SCHOOL ALGERIAN MANAGER
                              │
             ┌────────────────┼────────────────┐
             │                │                │
          ADMIN          GESTIONNAIRE       ELEVE
             │                │                │
             ▼                ▼                ▼
       Admin Dashboard  Manager Dashboard  Student Dashboard
             │                │                │
             └────────────────┼────────────────┘
                              │
                              ▼
                        Laravel Backend
                              │
                    ┌─────────┴─────────┐
                    │                   │
                 Eloquent             Routes
                    │                   │
                    └─────────┬─────────┘
                              │
                              ▼
                           MySQL
```

---

# 🎯 Project Goals

This project demonstrates practical experience with:

* Laravel application development
* PHP backend development
* MySQL database integration
* Authentication
* Role-based authorization
* Eloquent ORM
* Laravel migrations
* MVC architecture
* JavaScript
* Tailwind CSS
* Vite
* Git
* GitHub
* Responsive dashboard development
* School management workflows

---

# 🚀 Future Improvements

Potential future improvements include:

* 📱 Improved mobile responsiveness
* 📊 Advanced statistics
* 📈 Analytics dashboard
* 🔔 Notifications
* 📧 Email notifications
* 📄 PDF reports
* 📥 Excel export
* 🔎 Advanced search and filtering
* 👤 Improved user profile management
* 🔐 Additional security controls
* 🌍 Multi-language support
* ☁️ Production deployment
* 🧪 Expanded automated testing

---

# 👨‍💻 Developer

**Elhadri Allal**

Full-Stack Web Developer

### GitHub

https://github.com/webX22

### LinkedIn

https://www.linkedin.com/in/allaldsgnr/

### Portfolio

https://hadriallalportfolio.netlify.app/

---

# 📄 License

This project is provided for educational, portfolio, and development purposes.

If you intend to use this project commercially, review and define an appropriate license and verify the licensing requirements of all third-party dependencies.

---

# ⭐ Project

If you find this project useful or interesting, consider giving the repository a ⭐ on GitHub.

<p align="center">
  <strong>School Algerian Manager</strong>
  <br>
  Laravel • MySQL • PHP • JavaScript • Tailwind CSS
</p>
