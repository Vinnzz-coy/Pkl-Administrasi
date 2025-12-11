
## 🚀 ADMINISTRASI PKL: Aplikasi Pengelolaan Praktik Kerja Lapangan

<div align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
    <p>Aplikasi administrasi Praktik Kerja Lapangan (PKL) berbasis web modern.</p>
</div>

<div align="center">

| Teknologi Inti | Versi | Status |
| :--- | :--- | :--- |
| **Laravel** | `12.x` | [![Laravel](https://img.shields.io/badge/Laravel-12.x-red)](https://laravel.com) |
| **Database** | `PostgreSQL` | [![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Database-blue)](https://www.postgresql.org) |
| **Assets Bundler** | `Vite` | [![Vite](https://img.shields.io/badge/Vite-Bundler-purple)](https://vitejs.dev) |
| **Lisensi** | `MIT` | [![License](https://img.shields.io/github/license/Vinnzz-coy/administrator-pkl)](LICENSE) |

</div>

---

### ✨ Fitur Utama (TODO: Sesuaikan dengan Fitur Aplikasi Anda)

Aplikasi ini dirancang untuk mempermudah administrasi dan pengelolaan data PKL, termasuk:

* **Manajemen Data Siswa/Mahasiswa:** Pencatatan dan pengelolaan data peserta PKL.
* **Pengelolaan Tempat PKL:** Data perusahaan/instansi yang menjadi lokasi PKL.
* **Sistem Penilaian:** Pencatatan dan perhitungan nilai PKL.
* **Laporan & Rekapitulasi:** Generasi laporan administrasi secara otomatis.

---

### 🛠️ Persyaratan Sistem

Pastikan sistem Anda memenuhi persyaratan berikut sebelum memulai instalasi:

* **PHP:** Versi 8.2 atau lebih tinggi.
* **Composer:** Terinstal di sistem Anda.
* **Node.js & NPM:** Terinstal untuk menjalankan Vite.
* **PostgreSQL:** Server database berjalan dan dapat diakses.

---

### 💻 Panduan Instalasi dan Konfigurasi Project

Ikuti langkah-langkah di bawah ini untuk menginstal dan menjalankan aplikasi secara lokal.

#### 1. Menggandakan Repositori (Clone)

Buka Terminal atau Command Prompt, lalu jalankan perintah berikut:

```bash
git clone [https://github.com/Vinnzz-coy/administrator-pkl.git](https://github.com/Vinnzz-coy/administrator-pkl.git)
cd administrator-pkl
````

#### 2\. Instalasi Dependensi

Instal dependensi *backend* (PHP/Laravel) menggunakan **Composer**:

```bash
composer install
```

Instal dependensi *frontend* (JavaScript/Vite) menggunakan **NPM/Yarn**:

```bash
npm install
# atau
# yarn install
```

#### 3\. Konfigurasi Lingkungan (`.env`)

Salin file lingkungan contoh (`.env.example`) untuk membuat file konfigurasi (`.env`):

```bash
# Untuk Linux/macOS
cp .env.example .env

# Untuk Windows
# copy .env.example .env
```

#### 4\. Penyesuaian Database

Buka file `.env` dan sesuaikan pengaturan koneksi database PostgreSQL Anda:

```dotenv
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=administrasi_pkl # Ganti sesuai nama database Anda
DB_USERNAME=postgres         # Ganti sesuai username database Anda
DB_PASSWORD=YOUR_PASSWORD    # Ganti sesuai password database Anda
```

#### 5\. Generate Application Key

Hasilkan kunci enkripsi Laravel untuk keamanan:

```bash
php artisan key:generate
```

#### 6\. Migrasi Database dan Seeding (Opsional)

Jalankan migrasi untuk membuat tabel database dan *seeder* (jika ada) untuk mengisi data awal:

```bash
php artisan migrate

# Opsional: Jika Anda memiliki seeder data awal
# php artisan db:seed
```

#### 7\. Menjalankan Aplikasi

Aplikasi Laravel memerlukan dua proses yang berjalan bersamaan: server backend (PHP) dan bundler frontend (Vite).

  * **Jalankan Server Laravel (Backend)**
    Buka Terminal/CMD **pertama** dan jalankan:

    ```bash
    php artisan serve
    ```

    Aplikasi akan tersedia di `http://127.0.0.1:8000`.

  * **Jalankan Vite (Frontend Assets)**
    Buka Terminal/CMD **kedua** dan jalankan:

    ```bash
    npm run dev
    # atau
    # yarn dev
    ```

    Ini akan mengompilasi CSS dan JS agar fitur frontend seperti Livewire/Vue/React (jika digunakan) dapat berfungsi.


```

Apakah ada bagian lain dari dokumentasi proyek Anda yang ingin Anda perjelas atau perbaiki?
```
