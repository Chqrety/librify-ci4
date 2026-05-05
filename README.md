# 📚 Librify - Modern Library Management System

Librify adalah sistem informasi manajemen perpustakaan modern berbasis web yang dibangun menggunakan **CodeIgniter 4**. Aplikasi ini dirancang dengan antarmuka yang ramah pengguna dan dilengkapi dengan berbagai fitur _enterprise-level_ seperti integrasi Payment Gateway, konsumsi API eksternal, dan Notifikasi Email otomatis.

Proyek ini dikembangkan untuk memenuhi penugasan mata kuliah Web Development.

## ✨ Fitur Utama (Berdasarkan Aspek Penilaian)

1. **Struktur MVC Murni (Aspek 1, 2, 9):** Menggunakan _Controller_, _Model_, dan _View_ CI4 secara ketat dengan prinsip _Clean Code_.
2. **Autentikasi & Multi-Role (Aspek 3):** Dilengkapi fitur Login dengan Route Filters untuk role **Admin** dan **Member**.
3. **CRUD Buku & Upload (Aspek 4):** Manajemen data buku yang dinamis dengan fitur upload _cover_ buku dan validasi form bawaan CI4.
4. **Google Books API Integration (Aspek 5):** Menggunakan cURL/Webservice Client untuk mencari dan menarik data buku secara _real-time_ dari Google Books.
5. **RESTful API Server (Aspek 6):** Menyediakan _endpoint_ API mandiri yang diamankan dengan validasi Bearer Token.
6. **Payment Gateway (Aspek 7):** Terintegrasi dengan **Midtrans Snap API** untuk pembayaran denda keterlambatan secara otomatis.
7. **Email Notification (Aspek 7):** Pengiriman _e-receipt_ atau bukti pembayaran otomatis ke email pengguna menggunakan library SMTP CI4.
8. **Modern UI/UX (Aspek 8):** Menggunakan layout _Flat Design_ yang responsif dan estetis menggunakan _templating engine_ (`$this->extend`).
9. **Automated Testing (Bonus/Aspek Tambahan):** Dilengkapi dengan PHPUnit Testing untuk memastikan stabilitas _route_ dan logika bisnis.

---

## 🛠️ Persyaratan Sistem (Prerequisites)

Sebelum menjalankan aplikasi ini, pastikan sistem Anda telah terinstal:

- **PHP** versi 8.1 atau lebih baru (Disarankan PHP 8.4)
- **Composer** (Dependency Manager)
- **MySQL / MariaDB**
- **Web Server** (Apache/Nginx atau gunakan CI4 Spark)

---

## 🚀 Cara Instalasi & Menjalankan Aplikasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi Librify di _local environment_ Anda:

1. **Clone Repository**

   ```bash
   git clone [https://github.com/][username-github-anda]/librify.git
   cd librify
   ```

2. **Install Dependencies**
   Jalankan perintah ini untuk mengunduh semua _library_ yang dibutuhkan (termasuk PHPUnit).
   ```bash
   composer install
   ```

````

3. **Pengaturan Konfigurasi (.env)**
   * Duplikat file `env` bawaan CI4 dan ubah namanya menjadi `.env`.
   ```bash
   cp env .env
````

- Buka file `.env`, lalu atur Environment dan Base URL:

```env
CI_ENVIRONMENT = development
app.baseURL    = 'http://localhost:8080'

```

4. **Konfigurasi Database**
   Masih di dalam file `.env`, temukan blok database dan sesuaikan dengan _credential_ lokal Anda:
   ```env
   database.default.hostname = localhost
   database.default.database = db_librify
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   ```

````
   *(Catatan: Buat database kosong bernama `db_librify` di phpMyAdmin, lalu import file `db_librify.sql` yang telah disediakan di dalam folder `database/` repository ini).*

5. **Konfigurasi Kunci API (Midtrans & Email)**
   Tambahkan baris berikut di bagian paling bawah file `.env` Anda:
   ```env
   # MIDTRANS CONFIG
   MIDTRANS_SERVER_KEY = 'SB-Mid-server-xxxxxx'
   MIDTRANS_CLIENT_KEY = 'SB-Mid-client-xxxxxx'
   MIDTRANS_IS_PRODUCTION = false

   # EMAIL SMTP CONFIG (GMAIL)
   email.protocol = 'smtp'
   email.SMTPHost = 'smtp.gmail.com'
   email.SMTPUser = 'email-pengirim@gmail.com'
   email.SMTPPass = 'password-aplikasi-16-digit'
   email.SMTPPort = 465
   email.SMTPCrypto = 'ssl'
   email.mailType = 'html'

````

6. **Jalankan Aplikasi**
   Jalankan server bawaan CodeIgniter melalui terminal:
   ```bash
   php spark serve
   ```

````
   Buka browser dan akses aplikasi pada **`http://localhost:8080`**.

---

## 🔑 Akun Demo (Testing)

Untuk keperluan pengujian (login), gunakan kredensial berikut:

| Role   | Email                     | Password |
| :---   | :---                      | :---     |
| Admin  | admin@librify.com         | admin123 |
| Member | member@librify.com        | member123|

---

## 🧪 Menjalankan Unit Testing

Aplikasi ini dilengkapi dengan pengujian PHPUnit. Untuk menjalankan *test suite*, eksekusi perintah berikut di terminal:
```bash
./vendor/bin/phpunit --no-coverage
````

_(Catatan pengguna Windows: Gunakan perintah `.\vendor\bin\phpunit --no-coverage`)_

---

_Developed with ❤️ by [Nama Mahasiswa] - [NIM Mahasiswa]_
