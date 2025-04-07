#  Smart Task Management System (STMS)

A full-stack task management system built with **HTML, CSS, JavaScript, PHP**, and **MySQL** to streamline task assignment, progress tracking, and team collaboration with role-based dashboards.

---

##  Features

-  **Authentication** for Admin, Team Lead, and Users
-  **Role-based dashboards** with dedicated functionalities:
  - **Admin** can create users, assign Team Leads, and manage tasks
  - **Team Lead** can assign tasks to users and track progress
  - **Users** can view only their tasks and update status
-  **Task Prioritization** (High, Medium, Low)
-  **Deadlines & Descriptions**
-  **Drag and Drop Kanban Board** for task progress (To Do, In Progress, Completed)
-  **Edit & Delete tasks**
-  **Real-time notification UI** on status updates

---

##  Design Patterns Used

-  **Factory Pattern** — For dynamically creating user roles  
-  **Observer Pattern** — To show toast notifications on task status updates  
-  **Singleton Pattern** — For managing the database connection  
-  **Strategy Pattern** — To implement task priority sorting  
-  **Command Pattern** (Optional) — To support undo/redo task updates (future scope)  

---

##  Technologies

- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: PHP  
- **Database**: MySQL (phpMyAdmin)  
- **Styling**: Custom CSS with responsive layout  

---

##  Folder Structure

```
STMS/
├── admin/
│   ├── login.html
│   ├── dashboard.html
│   ├── login.php
├── teamlead/
│   ├── login.html
│   ├── dashboard.html
├── user/
│   ├── dashboard.html
    ├── user.js
├── backend/
│   ├── db.php
│   ├── login.php
│   ├── create_user.php
│   ├── assign_team_lead.php
│   ├── create_task.php
│   ├── get_tasks.php
│   ├── updateTaskStatus.php
│   └── edit_task.php
├── assets/
│   ├── style.css
├── index.html
└── README.md
```

---

##  Setup Instructions

### 1.  Clone the Repository

```bash
git clone (https://github.com/yourusername/STMS)
cd STMS
```

### 2.  Setup MySQL Database

- Open **phpMyAdmin**
- Create a database named `stms_project`
- Import the provided `schema.sql` (or create tables manually as per `db.php`)

### 3.  Configure Database

Edit the `backend/db.php` file and update credentials:

```php
private $host = "localhost";
private $user = "root";
private $pass = "";
private $dbname = "stms_project";
```

### 4.  Run the App

- Use **XAMPP** or **MAMP** and place the project in the `htdocs/` directory
- Open your browser and go to:

```
http://localhost/STMS/index.html
```

---

##  Roles & Usage

| Role      | Access                         |
|-----------|--------------------------------|
| Admin     | Create users, assign Team Lead, manage all tasks |
| Team Lead | Assign tasks to users, update status |
| User      | View only assigned tasks, update progress |

---

##  Contribution Guide

- Use meaningful commits
- Follow consistent folder and file naming
- Stick to DRY principles in JS and PHP
- Maintain accessibility and responsive design

---

##  Future Enhancements

-  Mobile responsiveness improvements  
-  Email notifications on task updates  
-  Dashboard analytics with charts  
-  Undo/Redo with Command Pattern  

---


---

##  License

This project is licensed under the [MIT License](LICENSE).
