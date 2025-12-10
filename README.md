<div align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="350" alt="Laravel Logo">
</div>

<div align="center">

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red)](https://laravel.com)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Database-blue)](https://www.postgresql.org)
[![Vite](https://img.shields.io/badge/Vite-Bundler-purple)](https://vitejs.dev)
[![License](https://img.shields.io/github/license/Vinnzz-coy/administrator-pkl)](LICENSE)

</div>

## Aplikasi Administrasi PKL

Aplikasi administrasi PKL berbasis web menggunakan Laravel, PostgreSQL, dan Vite.

Dokumentasi ini berisi langkah lengkap untuk instalasi dan konfigurasi project setelah clone dari GitHub.

Instalasi Project (Laravel + PostgreSQL + Vite)

# 1. Clone Repository

git clone https://github.com/Vinnzz-coy/administrator-pkl.git
cd administrator-pkl

# 2. Install Dependency Backend (Composer)

composer install

# 3. Install Dependency Frontend (Vite)

npm install

# 4. Generate file .env

cp .env.example .env

# (Windows)

copy .env.example .env

# 5. Sesuaikan konfigurasi database PostgreSQL di file .env

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=administrasi_pkl
DB_USERNAME=postgres
DB_PASSWORD=YOUR_PASSWORD

# 6. Generate key Laravel

php artisan key:generate

# 7. Migrasi database

php artisan migrate

# (Opsional bila ada seeder)

php artisan db:seed

# 8. Jalankan Laravel

php artisan serve

# 9. Jalankan Vite (agar CSS & JS aktif)

npm run dev
