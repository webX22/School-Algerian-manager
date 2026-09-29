markdown
# 🏫 School Management System

<p align="center">
  <strong>Modern • Secure • Responsive • Full-Stack</strong>
</p>

<p align="center">
  A complete school management platform for administrators, teachers, students, and parents.
</p>

<p align="center">

[![Node.js](https://img.shields.io/badge/Node.js-18%2B-111827?style=for-the-badge&logo=node.js&logoColor=22c55e)](https://nodejs.org/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-14%2B-111827?style=for-the-badge&logo=postgresql&logoColor=60a5fa)](https://www.postgresql.org/)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES2022-111827?style=for-the-badge&logo=javascript&logoColor=facc15)](https://developer.mozilla.org/)
[![License](https://img.shields.io/badge/License-MIT-111827?style=for-the-badge)](#-license)

</p>

---

# ✨ Overview

**School Management System** is a full-stack web application designed to centralize and simplify daily school operations.

It provides dedicated functionality for:

- 👑 Administrators
- 👨‍🏫 Teachers
- 🎓 Students
- 👨‍👩‍👧 Parents
- 📚 Classes
- 🕐 Timetables
- 📊 Grades
- 📋 Attendance
- 📝 Assignments
- 📤 Assignment submissions
- 🏖️ Leave requests
- 📢 Announcements
- 🍽️ School meal management
- 📁 File management
- 🖼️ Profile pictures
- 📈 Reports
- 🧹 Duties
- 🛡️ Audit logs

The system uses a **Node.js backend**, **PostgreSQL database**, and a responsive frontend.

---

# 💎 Features

| Feature | Description |
|---|---|
| 🔐 Authentication | Secure login and role-based access |
| 👑 Admin Dashboard | Complete school administration |
| 👨‍🏫 Teacher Management | Classes, grades, assignments and attendance |
| 🎓 Student Portal | Timetable, grades, assignments and profile |
| 👨‍👩‍👧 Parent Access | Student information and school updates |
| 📚 Classes | Create and manage school classes |
| 🕐 Timetable | Manage schedules |
| 📊 Attendance | Track student attendance |
| 🎓 Grades | Record and review academic grades |
| 📝 Assignments | Create and manage assignments |
| 📤 Submissions | Student assignment submissions |
| 🏖️ Leave Requests | Submit and manage leave requests |
| 📢 Announcements | School-wide announcements |
| 🍽️ Meal System | Menus and meal orders |
| 💳 Meal Balance | Student meal balance and top-up |
| 📁 Files | Upload and access files |
| 🖼️ Profile Pictures | User profile image management |
| 📈 Reports | Administrative reports |
| 🧹 Duties | Manage assigned duties |
| 🛡️ Audit Logs | Track important system actions |
| 📱 Responsive UI | Desktop, tablet and mobile support |

---

# 🖥️ Technology Stack

## Frontend

- HTML5
- CSS3
- JavaScript
- Responsive design
- Fetch API

## Backend

- Node.js
- HTTP server
- REST-style API
- Role-based authorization
- File upload handling

## Database

- PostgreSQL
- Automatic initialization
- Database schema creation
- Seed/demo data

---

# 📁 Project Structure


school-management-system/
│
├── public/
│   ├── index.html
│   ├── login.html
│   ├── dashboard.html
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/
│
├── lib/
│   ├── db.js
│   ├── core.js
│   ├── routes_a.js
│   └── routes_b.js
│
├── server.js
├── seed.js
├── package.json
├── package-lock.json
├── .env.example
├── .gitignore
└── README.md


---

# ⚙️ Requirements

Before installing the system, install the following.

## Node.js

Recommended:


Node.js 18+


Download:


https://nodejs.org/


## PostgreSQL

Recommended:


PostgreSQL 14+


Download:


https://www.postgresql.org/download/


## Git

Download:


https://git-scm.com/


---

# 🚀 Installation — A to Z

## 1. Clone the project

bash
git clone https://github.com/YOUR_USERNAME/school-management-system.git


Enter the project:

bash
cd school-management-system


---

## 2. Install dependencies

bash
npm install


---

## 3. Create the PostgreSQL database

Open PostgreSQL or pgAdmin.

Create a database:

sql
CREATE DATABASE school_management;


---

# 🔐 4. Configure Environment Variables

Create a `.env` file in the project root.

Example:

env
PORT=3000

DATABASE_URL=postgresql://postgres:YOUR_PASSWORD@localhost:5432/school_management

SESSION_SECRET=CHANGE_THIS_TO_A_LONG_RANDOM_SECRET


Example:

env
PORT=3000

DATABASE_URL=postgresql://postgres:admin123@localhost:5432/school_management

SESSION_SECRET=my-super-secret-school-session-key


> ⚠️ **Never upload your real `.env` file to GitHub.**

---

# 🗄️ 5. Initialize the Database

Run:

bash
npm run seed


If database initialization is handled automatically by the server, simply start:

bash
npm start


---

# ▶️ 6. Start the Application

bash
npm start


You should see:


Server running on http://localhost:3000


Open:


http://localhost:3000


---

# 🧪 7. Check JavaScript

Before pushing the project to GitHub:

bash
npm run check


The following files should pass syntax checking:


server.js
lib/db.js
lib/core.js
lib/routes_a.js
lib/routes_b.js
seed.js


---

# 👤 Demo Accounts

> ⚠️ These accounts are for local/demo development only.
>
> Change all passwords before production deployment.

| Role             | Username / Email      | Password     |
| ---------------- | --------------------- | ------------ |
| 👑 Administrator | `admin@example.com`   | `admin123`   |
| 👨‍🏫 Teacher    | `teacher@example.com` | `teacher123` |
| 🎓 Student       | `student@example.com` | `student123` |
| 👨‍👩‍👧 Parent  | `parent@example.com`  | `parent123`  |

If your seeded database uses different credentials, check:


seed.js


---

# 🔐 Security

For production, change all demo passwords.

## Demo passwords


admin123
teacher123
student123
parent123


Use strong passwords instead.

## Change the session secret

env
SESSION_SECRET=YOUR_LONG_RANDOM_SECRET


Generate a long random value for production.

## Never upload


.env


to GitHub.

---

# 🔌 API

All application API routes use:


/api/


The routing system correctly extracts the route after `/api/`.

---

# 📊 Dashboard

http
GET /api/dashboard


---

# 👥 Users

http
GET /api/users


---

# 📚 Classes

http
GET /api/classes


---

# 🕐 Timetable

http
GET /api/timetable


---

# 📋 Attendance

http
GET /api/attendance


---

# 🎓 Grades

http
GET /api/grades


---

# 📝 Assignments

http
GET /api/assignments


---

# 📤 Submissions

http
GET /api/submissions


---

# 🏖️ Leave Requests

http
GET /api/leave-requests


---

# 📢 Announcements

http
GET /api/announcements


---

# 🍽️ Menu

http
GET /api/menu


---

# 🍴 Meal Orders

http
GET /api/meal-orders


---

# 🖼️ Profile Pictures

http
GET /api/profile-pic


---

# 📁 Files

http
GET /api/files/...


Uploaded files are correctly handled through:


/api/files/


Example:


/api/files/avatars/user.jpg


---

# 📈 Reports

http
GET /api/reports


---

# 🧹 Duties

http
GET /api/duties


---

# 🛡️ Audit Logs

http
GET /api/audit-logs


---

# 🛠️ Routing Fix

The original version had an important routing problem.

For example:


/api/dashboard


was incorrectly interpreted as:


api


instead of:


dashboard


This has been corrected.

The router now correctly handles:


/api/dashboard
/api/users
/api/classes
/api/timetable
/api/attendance
/api/grades
/api/assignments
/api/submissions
/api/leave-requests/...
/api/announcements
/api/menu
/api/meal-orders
/api/profile-pic
/api/files/...
/api/reports
/api/duties
/api/audit-logs


---

# 📁 Uploaded Files

Uploaded files are served through:


/api/files/...


Example:


/api/files/avatars/example.jpg


The `/api/files/` prefix is handled correctly by the server.

---

# 🧪 Testing Checklist

Before deployment:


☐ npm install
☐ npm run check
☐ PostgreSQL connection
☐ Database initialization
☐ Login
☐ Logout
☐ Admin dashboard
☐ Teacher dashboard
☐ Student dashboard
☐ Parent dashboard
☐ Users
☐ Classes
☐ Timetable
☐ Attendance
☐ Grades
☐ Assignments
☐ Submissions
☐ Leave requests
☐ Announcements
☐ Menu
☐ Meal orders
☐ Profile pictures
☐ File uploads
☐ Reports
☐ Duties
☐ Audit logs


---

# 🧰 Troubleshooting

## Database connection error

Check:

env
DATABASE_URL


Example:

env
DATABASE_URL=postgresql://postgres:password@localhost:5432/school_management


Make sure PostgreSQL is running.

---

## Port already in use

Change:

env
PORT=3000


to:

env
PORT=3001


Then open:


http://localhost:3001


---

## `npm install` fails

Try:

bash
npm cache clean --force


Then:

bash
npm install


---

## JavaScript syntax error

Run:

bash
npm run check


Or check an individual file:

bash
node --check server.js


---

## API returns 404

Make sure the server is running.

Test:


http://localhost:3000/api/dashboard


All API routes use:


/api/


---

# 🐙 Push to GitHub

## 1. Create a GitHub repository

Go to:


https://github.com/new


Create:


school-management-system


Do not upload `.env`.

---

## 2. Open the project

bash
cd school-management-system


---

## 3. Initialize Git

bash
git init -b main


---

## 4. Add files

bash
git add .


---

## 5. Commit

bash
git commit -m "Initial school management system"


---

## 6. Connect GitHub

Replace `YOUR_USERNAME`:

bash
git remote add origin https://github.com/YOUR_USERNAME/school-management-system.git


---

## 7. Push

bash
git push -u origin main


---

# 🔄 Updating GitHub

After making changes:

bash
npm run check


Then:

bash
git add .


Commit:

bash
git commit -m "Update school management system"


Finally:

bash
git push


---

# 🧹 Recommended `.gitignore`

Create or verify `.gitignore`:

gitignore
node_modules/

.env
.env.*
!.env.example

uploads/*
!uploads/.gitkeep

*.log

.DS_Store
Thumbs.db


---

# 📦 Recommended `.env.example`

Create:


.env.example


with:

env
PORT=3000

DATABASE_URL=postgresql://postgres:YOUR_PASSWORD@localhost:5432/school_management

SESSION_SECRET=CHANGE_ME


This allows other developers to understand which environment variables are required without exposing your private credentials.

---

# 🧑‍💻 Development Workflow

Start from the project directory:

bash
cd school-management-system


Install dependencies:

bash
npm install


Check syntax:

bash
npm run check


Start the server:

bash
npm start


Open:


http://localhost:3000


Make your changes.

Run:

bash
npm run check


Then:

bash
git add .
git commit -m "Update application"
git push


---

# 🌐 Production Checklist

Before publishing the application:


☐ Change every demo password
☐ Generate a strong SESSION_SECRET
☐ Configure production PostgreSQL
☐ Configure production DATABASE_URL
☐ Enable HTTPS
☐ Protect environment variables
☐ Do not expose .env
☐ Do not expose database credentials
☐ Test authentication
☐ Test every role
☐ Test every API route
☐ Test file uploads
☐ Test database backups
☐ Test mobile responsiveness
☐ Run npm run check


---

# 🤝 Contributing

Contributions are welcome.

## 1. Fork the repository

bash
git clone https://github.com/YOUR_USERNAME/school-management-system.git


## 2. Create a branch

bash
git checkout -b feature/my-feature


## 3. Make your changes

Implement your feature or fix.

## 4. Check the code

bash
npm run check


## 5. Commit

bash
git add .
git commit -m "Add new feature"


## 6. Push

bash
git push origin feature/my-feature


## 7. Open a Pull Request

Open a Pull Request on GitHub and describe your changes.

---

# 📜 License

This project is released under the **MIT License**.

You are free to:

* Use the software
* Modify the software
* Distribute the software
* Use it commercially

Subject to the conditions of the MIT License.

---

# ⭐ Support

If you find this project useful:

⭐ Star the repository

🐛 Report bugs

💡 Suggest features

🤝 Contribute improvements

---

<p align="center">

<strong>🏫 School Management System</strong>

<br>

<em>Built for modern school administration.</em>

<br><br>

⭐ Made with Node.js • PostgreSQL • HTML • CSS • JavaScript ⭐

</p>



If this project is useful to you, configure `DONATION_URL` in `.env` to display the Donate button and point it to your preferred donation/support page.
