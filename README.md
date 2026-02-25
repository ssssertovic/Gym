# GymApp

A professional gym management web application built with **Laravel** and **MySQL**. GymApp enables gym members to browse plans, view trainers, book sessions, and manage their profiles, while administrators can oversee operations through a dedicated admin interface.

---

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Database Structure](#database-structure)
- [Installation](#installation)
- [Running the Project](#running-the-project)
- [Author](#author)

---

## Features

| Feature | Description |
|--------|-------------|
| **User registration & authentication** | Secure sign-up and login with Laravel Jetstream (email verification, password reset). |
| **Membership plans** | View available membership plans with pricing, duration, and descriptions. |
| **Trainers** | Browse trainer profiles including name, level, and description. |
| **Training session booking** | Book training sessions by selecting a plan, trainer, and date/time. |
| **User profile management** | Update name, email, height, weight; change password; upload profile image; delete account. |
| **Admin role support** | Role-based access (user/admin) for administrative functionality. |
| **External API integration** | Motivational quotes displayed via Fetch API (REST). |

---

## Technologies Used

- **Backend:** PHP 7.3+ / 8.0+, Laravel 8.x
- **Frontend:** Laravel Livewire, Alpine.js, Tailwind CSS, Laravel Mix
- **Authentication:** Laravel Jetstream, Laravel Sanctum
- **Database:** MySQL
- **HTTP client:** Guzzle (for server-side API calls)
- **Other:** Laravel CORS, Faker (dev), PHPUnit (testing)

---

## Database Structure

Overview of the main tables and relationships:

| Table | Description |
|-------|-------------|
| **users** | Application users: `name`, `email`, `password`, `role` (user/admin), `height_cm`, `weight_kg`, `profile_photo_path`, timestamps. |
| **members** | Legacy/supplementary member data (e.g. code, plan, photo_path, fitness fields). |
| **plans** | Membership plans: `name`, `price`, `duration_days`, `description`. |
| **trainers** | Trainers: `name`, `lastname`, `level`, `description`. |
| **bookings** | Training session bookings: `user_id` → users, `plan_id` → plans, `trainer_id` → trainers, `scheduled_at`, `notes`. |
| **workouts** | Workout records (code, date, grade, description, trainer, member). |

**Relationships:**

- **bookings** → `user_id` (users), `plan_id` (plans), `trainer_id` (trainers), with cascade on delete.

---

## Installation

### Prerequisites

- **PHP** ≥ 7.3 or 8.0 (with extensions: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `curl`)
- **Composer**
- **Node.js** and **npm**
- **MySQL** (or MariaDB)

### Steps

1. **Clone the repository**

   ```bash
   git clone https://github.com/your-username/GymApp.git
   cd GymApp
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Environment configuration**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Edit `.env` and set your database credentials:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gym
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

   Set `APP_URL` to your local URL (e.g. `http://localhost:8000`) to avoid CSRF/session issues.

4. **Create the database**

   Create a MySQL database named `gym` (or the name you set in `DB_DATABASE`).

5. **Run migrations**

   ```bash
   php artisan migrate
   ```

   Optionally seed data:

   ```bash
   php artisan db:seed
   ```

6. **Install frontend dependencies and build assets**

   ```bash
   npm install
   npm run dev
   ```

   For production:

   ```bash
   npm run production
   ```

---

## Running the Project

1. **Start the Laravel development server**

   ```bash
   php artisan serve
   ```

   The app will be available at **http://localhost:8000** (or the host/port shown in the terminal).

2. **Optional: watch frontend assets during development**

   In a separate terminal:

   ```bash
   npm run watch
   ```

3. **Optional: create an admin user**

   Use the registration page to create an account, then set the user's `role` to `admin` in the `users` table, or use a seeder if you have one.

---

## Author

**Your Name**  
- GitHub: [@your-username](https://github.com/your-username)  
- Email: your.email@example.com  

---

## License

This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).
