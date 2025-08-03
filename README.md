# 📇 Contact Manager (Laravel 11 + Sanctum + Docker)

A **Contact Management System** built with **Laravel 11**, featuring:
✅ Contact CRUD (Create, Read, Update, Delete)
✅ File Upload (Profile Picture)
✅ Email Notifications
✅ Logging (Custom Log File)
✅ Dashboard with Caching (Manual Refresh Supported)
✅ REST API with Sanctum Authentication
✅ Google Maps Integration for Address Preview
✅ Laravel Sail (Docker-based Development)
✅ **Live Deployment:** [https://contact-manager-1lyk.onrender.com](https://contact-manager-1lyk.onrender.com)

---

## 🚀 Features

### ✅ Web Features

* 👤 User authentication (Laravel Breeze)
* 📇 Manage contacts (CRUD)
* 📤 Upload contact photo
* 📧 Email notifications on contact creation
* 📝 **Custom logging** (`storage/logs/contact.log`)
* 📊 **Dashboard with cached statistics (10 min cache + refresh button)**
* 🗺️ Google Maps preview for contact addresses

### ✅ API Features

* 🔐 API authentication using Laravel Sanctum
* 📄 Protected `/api/contacts` CRUD endpoints
* 🔑 API token-based register/login/logout
* 🌍 JSON-based responses for easy frontend/mobile integration

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

🔧 Update `.env` (DB, MAIL, APP\_URL, Google Maps API Key)

### 4️⃣ Start Docker

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

### 📌 Register a user

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

### 📌 Login to get token

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
  "user": { "id": 1, "name": "John Doe", "email": "john@example.com" },
  "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
  "token_type": "Bearer"
}
```

---

### 📌 Use token in API requests

```bash
curl -X GET https://contact-manager-1lyk.onrender.com/api/contacts \
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

## 📊 Dashboard Features

✔ Total contacts (cached for 10 minutes)
✔ Recently added contacts
✔ Last updated contact
✔ **Manual Refresh Cache Button**

---

## 📝 Logging

📂 **Custom Log File:**
`storage/logs/contact.log`

✅ Logs for:
✔ Contact Created
✔ Contact Updated
✔ Contact Deleted

---

## 🗺️ Google Maps Integration

* Add/Edit a contact → Enter address → Preview map
* Dashboard → "View Map" button shows location in modal

---

## 📦 Deployment

🚀 **Live App:** [https://contact-manager-1lyk.onrender.com](https://contact-manager-1lyk.onrender.com)
✔ Hosted on **Render (Free Tier)** with MySQL database
✔ Public GitHub Repo: [https://github.com/shamryigat/contact-manager](https://github.com/shamryigat/contact-manager)

---

## 📜 License

MIT License – free to use and modify.

---