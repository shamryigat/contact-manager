# 📇 Contact Manager (Laravel 11 + Sanctum + Docker)

A **Contact Management System** built with **Laravel 11**, featuring:
✅ Contact CRUD (Create, Read, Update, Delete)
✅ File Upload (Profile Picture)
✅ Email Notifications
✅ Logging (Custom Log File)
✅ Dashboard with Caching
✅ REST API with Sanctum Authentication
✅ Google Maps Integration for Address Preview
✅ Laravel Sail (Docker-based Development)

---

## 🚀 Features

### ✅ Web Features

* 👤 User authentication (Laravel Breeze)
* 📇 Manage contacts (CRUD)
* 📤 Upload contact photo
* 📧 Email notifications on contact creation
* 📝 Custom logging (`storage/logs/contact.log`)
* 📊 Dashboard with cached statistics
* 🗺️ Google Maps preview for contact addresses

### ✅ API Features

* 🔐 API authentication using Laravel Sanctum
* 📄 Protected `/api/contacts` CRUD endpoints
* 🔑 API token-based register/login/logout
* 🌍 JSON-based responses, easy to use in frontend or mobile apps

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

Update `.env` file (database, mail, app URL, Google Maps API key).

### 4️⃣ Start Docker (Laravel Sail)

```bash
./vendor/bin/sail up -d
```

### 5️⃣ Generate app key

```bash
./vendor/bin/sail artisan key:generate
```

### 6️⃣ Run migrations & link storage

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan storage:link
```

---

## 🔑 API Authentication (Laravel Sanctum)

### 1️⃣ Register a user

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

### 2️⃣ Login to get token

```bash
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password"
}
```

✅ **Response**

```json
{
  "message": "Login successful",
  "user": { "id": 1, "name": "John Doe", "email": "john@example.com" },
  "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
  "token_type": "Bearer"
}
```

---

### 3️⃣ Use the token in API requests

Example using Curl:

```bash
curl -X GET http://localhost/api/contacts \
  -H "Authorization: Bearer 1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
```

---

### 📌 API Endpoints

| Method | Endpoint             | Auth | Description    |
| ------ | -------------------- | ---- | -------------- |
| POST   | `/api/register`      | ❌    | Register user  |
| POST   | `/api/login`         | ❌    | Login user     |
| GET    | `/api/contacts`      | ✅    | List contacts  |
| POST   | `/api/contacts`      | ✅    | Create contact |
| GET    | `/api/contacts/{id}` | ✅    | Show contact   |
| PUT    | `/api/contacts/{id}` | ✅    | Update contact |
| DELETE | `/api/contacts/{id}` | ✅    | Delete contact |
| POST   | `/api/logout`        | ✅    | Logout user    |

---

## 🚀 Quick Start with Postman

1. Open Postman and create a **New Collection**
2. Add `{{base_url}}` variable → `http://localhost` (or your deployed URL)
3. Test the following requests in order:
   ✅ `POST /api/register`
   ✅ `POST /api/login` (copy token)
   ✅ Add token to **Authorization → Bearer Token**
   ✅ Call `GET /api/contacts`, `POST /api/contacts`, etc.

---

## 📊 Dashboard Features

✔ Total contacts
✔ Recently added
✔ Last updated contact
✔ Cached for 10 minutes (manual refresh button)

---

## 🗺️ Google Maps Integration

* Add or edit a contact → enter an address → preview map before saving
* Dashboard table → **View Map** button opens a modal with the location

---

## 📨 Email Notifications

* Email sent to the logged-in user when a new contact is created

---

## 📦 Deployment

* Can be deployed to **Render**, **Railway**, **Laravel Forge**, or any PHP 8.2+ hosting
* Requires MySQL or MariaDB database

---

## 📜 License

MIT License – free to use and modify.

---
