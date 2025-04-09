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

# Testing

## Authentication Test Cases

Login with valid credentials

→ Enter correct username, password, and role. The user should be successfully logged in and redirected to their respective dashboard.

Login with incorrect password

→ Enter a valid username but the wrong password. The system should display an “Incorrect password” message.

Login with non-existent username

→ Use a username that is not in the database. The system should display a “User not found” message.

Login with mismatched role

→ Choose a different role than the one stored in the database. Access should be denied with an appropriate message.

Session persistence after login

→ Refresh the page after login. The session should remain active and keep the user logged in.

Session expiry on logout

→ After clicking the logout button, the user should be redirected to the login screen and their session terminated.

## Admin Module Test Cases

Create a new user with valid inputs

→ Submit the create user form with a valid username, password, and role. The user should be saved to the database.

Create user with missing fields

→ Leave one or more fields blank. The system should show a validation error and prevent submission.

Assign a user as Team Lead

→ Select a user from the dropdown and assign them as a team lead. Their role in the database should be updated.

Reassign the same user as Team Lead

→ Attempt to assign a team lead who is already in that role. The system should either prevent it or handle it gracefully.

## Task Management Test Cases

Create a new task with all fields filled

→ Submit the task creation form with valid inputs. The task should be stored and appear in the “To Do” column.

Create a task with missing priority or title

→ Submit the form without selecting a priority or leaving the title empty. An error should appear.

Assign task to a user

→ Select a user from the dropdown. The task should be linked to that user and displayed in their dashboard.

Tasks should appear sorted by priority

→ When multiple tasks are created, high priority tasks should appear at the top of the list.

Drag and drop task to another status

→ Move a task from “To Do” to “In Progress” or “Completed”. The status should update in both the UI and the database.

Edit task

→ Open the edit modal, modify task details, and save. Changes should reflect immediately on the board.

Delete task

→ Remove a task from the dashboard. It should be deleted from the database and disappear from the UI.

## User Dashboard Test Cases

User views only their assigned tasks

→ Login as a user. Only the tasks assigned to them should be visible.

User updates task status

→ Drag a task to another status column. The change should be saved and visible on reload.

Unauthorized page access

→ Try accessing the admin or team lead pages directly via URL as a user. Access should be blocked with an error or redirection.

## UI/UX Behavior Test Cases

Responsive layout on different screen sizes

→ Resize the browser window or use mobile. Layout should adapt correctly.

Toast notification display

→ Trigger a task update or drag/drop action. A notification should appear temporarily.

Edit modal behavior

→ Click the edit icon and confirm that the modal opens. Click the close button or 
outside the modal to close it.

Hover and button effects

→ Hover over buttons and links. Transitions and hover states should be consistent.

## Backend and Database Test Cases

Task saved to the database

→ After creating a task, verify its entry in the tasks table.

Foreign key integrity

→ Try assigning a task to a user ID that doesn’t exist. The database should reject it.

Username uniqueness

→ Attempt to create a user with a duplicate username. The system should prevent it and display an error.
SQL injection protection

→ Try submitting SQL commands as input. The system should sanitize inputs and prevent any injection.

## Optional Advanced/Future Test Cases

Undo/Redo task updates

→ If implemented, allow users to revert task status changes.

Load testing

→ Simulate many users interacting with the app. The system should remain stable and responsive.

Email or external notifications

→ Test whether email notifications or external hooks trigger on task creation or updates (if applicable)
