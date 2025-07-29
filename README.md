# 🧑‍💼 Job Portal - Laravel 10

A full-featured job portal built with Laravel 10, allowing employers to post jobs and job seekers to apply, manage resumes, save jobs, and more.

---

## 🚀 Features

### ✅ For Job Seekers:
- 🔍 Browse & filter job listings
- 💾 Save/unsave jobs
- 📄 Upload resume & apply to jobs
- ✉️ Build & use cover letters
- ⚠️ Create job alerts
- 📝 Manage profile, certificates, applications

### 🧑‍💼 For Employers:
- 🏢 Manage company profile
- 📢 Post, edit & delete jobs
- 👀 View and manage applications
- 💬 Message applicants

### 📊 Admin Panel:
- 👥 Manage users
- 🏭 Manage companies
- 📂 Manage job categories

---

## 🛠️ Tech Stack

- Laravel 10
- MySQL
- Blade Templates
- Bootstrap 5
- JavaScript (Vanilla/AJAX)
- Authentication with Laravel Breeze

---



## 📦 Installation

```bash
# Clone the repo
git clone https://github.com/shebinbalan/job-portal.git
cd job-portal

# Install dependencies
composer install
npm install && npm run dev

# Create environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Set up database in .env then run:
php artisan migrate --seed

# Optional: create storage link
php artisan storage:link

# Run the server
php artisan serve
