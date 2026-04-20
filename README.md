# 🍔 FastBite - Premium Restaurant Ordering System

FastBite is a state-of-the-art, full-featured restaurant management and ordering ecosystem built with **Laravel 12**. Designed for high-performance and seamless user experience, it bridges the gap between customer convenience and administrative control through real-time analytics, automated workflows, and a modern, modular architecture.

---

## 🌟 Core Features

### 🏛️ Enterprise-Grade Admin Dashboard
- **Real-time Analytics**: Interactive sales performance charts powered by **Chart.js**.
- **Product Lifecycle Management**: Comprehensive CRUD for menu items with rich image processing and real-time stock tracking.
- **Intelligent Reservations**: Manage table bookings with guest count tracking, status updates, and search capabilities.
- **Role-Based Access Control (RBAC)**: Distinct permissions for `Admin` and `Staff` users to ensure system integrity.
- **Dynamic Settings**: Global system configuration including featured dishes, ticker announcements, and brand identity management.

### 🍱 Premium Customer Experience
- **Fluid Menu Interface**: A highly optimized, mobile-responsive menu with instant category filtering and micro-animations.
- **Seamless Ordering**: "Fast-Track" checkout with table number association and real-time cart persistence.
- **Smart Reservations**: Intuitive frontend booking system for customers.
- **Next-Gen UI/UX**: Built with **Tailwind CSS 4.0**, featuring a fully reactive **Light/Dark mode** system that remembers user preferences.

### 🤖 Automation & Governance
- **Telegram Bot Integration**: Instant notifications for new orders, status changes, and critical system alerts.
- **Safe Delete Workflow**: A unique "Deletion Request" system where staff can request deletions that must be approved by an administrator.
- **Reporting Engine**: One-click generation of professional reports in **Excel** and **PDF** formats.
- **Session Tracking**: Robust monitoring of user logins and "last seen" activity.

---

## 🛠️ Technology Stack

| Layer | Technologies |
| :--- | :--- |
| **Backend** | Laravel 12.x, PHP 8.2+ |
| **Frontend** | Tailwind CSS 4.0, Alpine.js, Vite |
| **Database** | MySQL / MariaDB (Optimized Schema) |
| **Caching/Queues** | Redis (Predis) |
| **Storage** | Laravel Filesystem (S3 Compatible) |
| **Reporting** | Maatwebsite Excel, Barryvdh Laravel Snappy (PDF) |
| **DevOps** | Laravel Sail, Artisan CLI |

---

## 🚀 Intelligent Setup Guide

### 1. Prerequisites
- **PHP 8.2+** (with extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- **Composer** (PHP Package Manager)
- **Node.js 18+ & NPM**
- **Redis Server** (Highly recommended for high-performance queue processing)

### 2. Rapid Deployment
```bash
# 1. Acquire the Source
git clone <repository-url>
cd Restaurant_Ordering_System

# 2. Automated Foundation Setup
# This custom script handles composer, .env, key generation, and migrations
composer run setup

# 3. Security Check
# Ensure admin credentials are seeded
php artisan db:seed --class=AdminSeeder
```
> [!IMPORTANT]
> Default Administration Credentials:
> - **Username**: `admin`
> - **Password**: `admin@123`

---

## 📂 Architecture Overview

### Modular Asset Management
The project utilizes a decoupled asset strategy to ensure minimal bundle sizes:
- **`resources/css/userweb.css`**: Customer-facing design tokens and responsive layouts.
- **`resources/js/userweb.js`**: Frontend logic, cart management, and table selection logic.
- **`app/Http/Controllers/Admin`**: High-performance controllers for data-intensive operations.

### Key Database Entities
- **`Orders` & `OrderItems`**: High-fidelity transaction tracking with table association.
- **`Products` & `Categories`**: Multi-layered taxonomy for menu organization.
- **`DeletionRequests`**: Audit trail for system-wide record management.
- **`Logins`**: Real-time security and activity monitoring.

---

## 📢 Integration: Telegram Notifications

Enable real-time operational alerts by configuring your bot:
1. Contact [@BotFather](https://t.me/botfather) to create your bot.
2. Update your `.env` with the following:
   ```env
   TELEGRAM_BOT_TOKEN=your_token_here
   TELEGRAM_CHAT_ID=your_chat_id_here
   ```
3. Start the worker to process alerts in the background:
   ```bash
   php artisan queue:work
   ```

---

## 🖥️ Development Workflow

Run the development ecosystem concurrently:
```bash
composer run dev
```
*This command starts: Artisan Server, Vite Dev Server, Queue Worker, and Log Tailer.*

---

## 🛡️ Security & Performance
- **Cross-Site Request Forgery (CSRF) Protection** enabled on all state-changing routes.
- **SQL Injection Prevention** via Eloquent ORM.
- **Asset Minification** via Vite for sub-second page loads.
- **Persisted State Management** for theme preferences and session data.

---

Designed with ❤️ for modern dining establishments.