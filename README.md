# 📇 Contact Manager (Laravel 11 + Sanctum + Docker)

A simple **Contact Management System** built with **Laravel 11**, featuring:
✅ Contact CRUD (Create, Read, Update, Delete)
✅ File Upload (Contact Photo)
✅ Email Notifications
✅ Logging (Custom Log File)
✅ Dashboard with Caching
✅ REST API with Sanctum Authentication
✅ Laravel Sail (Docker-based local dev environment)

---

## 🚀 Features

### ✅ Web Features

* 👤 User authentication (Laravel Breeze)
* 📇 Manage contacts (CRUD)
* 📤 Upload contact photo
* 📧 Email notifications on new contact creation
* 📝 Custom logging of contact events (`storage/logs/contact.log`)
* 📊 Dashboard with cached statistics and cache refresh button

### ✅ API Features

* 🔐 API authentication using Laravel Sanctum
* 📄 Fully protected `/api/contacts` CRUD endpoints
* 🔑 API token-based login & logout
* 📌 Endpoints for registration, login, logout, and contacts management

---

## 🛠️ Installation (Laravel Sail + Docker)

### 1️⃣ Clone the repository

```bash
git clone https://github.com/shamryigat/contact-manager.git
cd contact-manager
```

### 2️⃣ Install dependencies

```bash
composer install
npm install && npm run build
```

### 3️⃣ Copy environment file

```bash
cp .env.example .env
```

Update your `.env` file (database, mail, app URL).

### 4️⃣ Start Docker (Laravel Sail)

```bash
./vendor/bin/sail up -d
```

### 5️⃣ Generate app key

```bash
./vendor/bin/sail artisan key:generate
```

### 6️⃣ Run migrations & storage link

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan storage:link
```

---

## 🔑 API Authentication (Laravel Sanctum)

### 📌 1. Register a new user

```bash
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

✅ Response:

```json
{
  "user": { "id": 1, "name": "John Doe", "email": "john@example.com" },
  "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
}
```

---

### 📌 2. Login to get API Token

```bash
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password"
}
```

✅ Response:

```json
{
  "user": { ... },
  "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
}
```

---

### 📌 3. Use Bearer Token for API Requests

Example:

```bash
GET /api/contacts
Authorization: Bearer 1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

---

### 📌 4. Logout

```bash
POST /api/logout
Authorization: Bearer 1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

✅ Response:

```json
{ "message": "Logged out" }
```

---

### 📌 API Endpoints

| Method | Endpoint             | Auth Required | Description         |
| ------ | -------------------- | ------------- | ------------------- |
| POST   | `/api/register`      | ❌             | Register user       |
| POST   | `/api/login`         | ❌             | Login and get token |
| GET    | `/api/contacts`      | ✅             | List contacts       |
| POST   | `/api/contacts`      | ✅             | Create contact      |
| GET    | `/api/contacts/{id}` | ✅             | Show contact        |
| PUT    | `/api/contacts/{id}` | ✅             | Update contact      |
| DELETE | `/api/contacts/{id}` | ✅             | Delete contact      |
| POST   | `/api/logout`        | ✅             | Logout user         |

---

## 📊 Dashboard Features

* Shows **total contacts**, **recently added**, **last updated**
* Cached for 10 minutes
* "🔄 Refresh Cache" button to clear cache

---

## 📨 Email Notifications

* When a new contact is created, an email is sent to the logged-in user
* Email events are **logged in `storage/logs/contact.log`**

---

## 📝 Logging

Custom log file:

```
storage/logs/contact.log
```

Logs events for:
✅ Contact Created
✅ Contact Updated
✅ Contact Deleted

---

## 📦 Deployment

* You can deploy this app on any hosting that supports **PHP 8.2+ & MySQL**
* For free hosting, use **Render**, **Railway**, or **Laravel Forge** (paid)

---

## 📜 License

MIT License – free to use and modify.

---

🔥 **Do you want me to also include a *"Quick Start API Testing with Postman / Curl"* section and a **visual API flow diagram** in the README?**
This would make your GitHub project look more **professional for job applications.**
