# 🎓 Final Year Project Archive – Laravel Backend

This is the **backend API** for the Final Year Project Archive — a web-based application that allows final year students to upload their projects, while the public can browse approved submissions without login. Built with **Laravel**, it manages users, project submissions, and admin approvals.

---

## 🔧 Tech Stack

- **Framework**: Laravel 10+
- **Authentication**: Passport (based on your setup)
- **Database**: MySQL
- **File Uploads**: Local or S3-compatible storage
- **API**: RESTful JSON

---

## 📌 Core Features

### 🧑‍💻 Public Users (No Login Required)
- View list of **approved projects**
- View **project details** and download files

### 🧑‍🎓 Final Year Students
- Can **sign in** only if listed in the `finalists` table
- Can **upload** or **update** their project details and files
- Cannot **approve** or **publish** their own project

### 🛡️ Admin Users (Only 2 Allowed)
- Cannot upload projects themselves
- Can:
  - Approve or reject submitted projects
  - Edit any project
  - Manage finalist records
  - Control project visibility (published/unpublished)

---

## 📁 API Endpoints Overview

| Method | Endpoint                  | Description                                | Auth Required |
|--------|---------------------------|--------------------------------------------|----------------|
| GET    | /api/projects             | List all approved & published projects     | ❌             |
| GET    | /api/projects/{id}        | View project details                        | ❌             |
| POST   | /api/login                | Student/admin login                         | ❌             |
| POST   | /api/students/upload     | Upload student project                      | ✅ Student     |
| PUT    | /api/students/project    | Edit uploaded project                       | ✅ Student     |
| GET    | /api/finalists/check     | Check if user is in `finalists` table       | ✅             |
| POST   | /api/admin/approve/{id}  | Approve/publish project                     | ✅ Admin       |
| POST   | /api/admin/reject/{id}   | Reject or unpublish project                 | ✅ Admin       |

---

## 🗂 Database Models

### `users`
- id, name, email, password, role (`student`, `admin`)

### `finalists`
- id, name, matric_no, email, department, session
- Only these can register or log in as students

### `projects`
- id, user_id, title, abstract, file_path, approved (bool), published (bool), timestamps

---
