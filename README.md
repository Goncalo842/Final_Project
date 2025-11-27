# ISTP - University Platform

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Final project developed with Laravel, featuring a full web application built using modern PHP frameworks and the MVC architecture.

This project includes robust functionality, a well-structured organization, and follows best practices from the Laravel ecosystem.


## Features
- 🔐 Authentication system with role-based access control
- 👤 User profile management
- 📚 Course management for Licenciaturas, Pós-Graduações, and CTeSP
- 💬 Integrated chatbot powered by ARIS (Artificial Response Intelligence System)
- 🌐 Multilingual support (Portuguese and English)
- 📊 Dashboard with real-time statistics
  

## Project Structure

```bash
ISTP-University/
├── app/               # Laravel application logic
├── public/            # Public assets (CSS, JS, images)
├── resources/         # Blade templates, JS, and CSS
├── routes/            # Application routes
├── storage/           # Logs and cached files
├── tests/             # PHPUnit tests
├── composer.json      # PHP dependencies
├── package.json       # Node.js dependencies
└── README.md          # This file
```

## Prerequisites
- PHP 8.0 or higher
- Composer
- MySQL database server

## Quick Start

### 1. Install Dependencies
From the project root:

```bash
composer install
cp .env.example .env
php artisan key:generate
```


### 2. Configure Environment Variables
Copy and edit the environment file:

```bash
APP_NAME=ISTP-University
APP_ENV=local
APP_KEY=base64:your-app-key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=DBpap
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Setup Database
Run the database migrations and seeders:

```bash
php artisan migrate
```

### 4. Run Development Server
Start the Laravel development server:

```bash
php artisan serve
```
## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
