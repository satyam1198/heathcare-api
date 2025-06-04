# Healthcare Appointment Booking API

This guide provides a clear and concise overview to set up and use the Healthcare Appointment Booking API.

---

## 1. Clone the Project

```bash
git clone https://github.com/satyam1198/heathcare-api.git
cd healthcare-api
```

---

## 2. Install Dependencies

```bash
composer install
```

---

## 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your DB credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=healthcare_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

## 4. Database Setup

```bash
php artisan migrate
php artisan db:seed # compulsory
```

---

## 5. Authentication

### Register

**POST /api/register**

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}
```

**Response:**

```json
{
  "token": "<auth-token>"
}
```

### Login

**POST /api/login**

```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response:**

```json
{
  "token": "<auth-token>"
}
```

Use this token for accessing protected APIs.

---

## 6. Using Authorization Token

Include in headers:

```
Authorization: Bearer <auth-token>
```

---

## 7. API Endpoints

### Get Appointments (Auth Required)

**GET /api/appointments**

**Response:**

```json
{
  "appointments": [...]
}
```

---

### Book Appointment (Auth Required)

**POST /api/appointments**

```json
{
  "healthcare_professional_id": 1,
  "appointment_start_time": "2025-06-04 10:00:00",
  "appointment_end_time": "2025-06-04 11:00:00"
}
```

**Response:**

```json
{
  "message": "Appointment booked successfully.",
  "appointment": { ... }
}
```

---

### Cancel Appointment (Auth Required)

**DELETE /api/appointments/{id}/cancel**

**Response:**

```json
{
  "message": "Cancelled Successfully"
}
```

---

### Complete Appointment (Auth Required)

**PATCH /api/appointments/{id}/complete**

**Response:**

```json
{
  "message": "Completed",
  "appointment": { ... }
}
```

---

### Get Healthcare Professionals (Public)

**GET /api/healthcare-professionals**

**Response:**

```json
{
  "healthcare_professionals": [...]
}
```

---

## 8. Run Tests

Configure `.env.testing` and run:

```bash
php artisan test
```

---

## Notes

* Used Laravel Sanctum for token-based auth
* Keep `.env` secure

---

**End of Guide**
