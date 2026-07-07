<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class MainSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        // Truncate tabel terlebih dahulu agar tidak duplikat saat seeding ulang
        $this->db->disableForeignKeyChecks();
        $this->db->table('loans')->truncate();
        $this->db->table('books')->truncate();
        $this->db->table('users')->truncate();
        $this->db->enableForeignKeyChecks();

        // ==========================================
        // 1. SEEDING DATA USERS (Urutan & Jumlah Key Identik)
        // ==========================================
        $users = [
            [
                'id' => 1,
                'name' => 'Admin Pustakawan',
                'email' => 'admin@perpus.com',
                'password' => password_hash('123', PASSWORD_BCRYPT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'name' => 'Member Pustakawan',
                'email' => 'member@perpus.com',
                'password' => password_hash('123', PASSWORD_BCRYPT),
                'role' => 'member',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Tambah data Faker dengan susunan key yang sama persis dengan di atas
        for ($i = 3; $i <= 10; $i++) {
            $users[] = [
                'id' => $i,
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => password_hash('member123', PASSWORD_BCRYPT),
                'role' => 'member',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('users')->insertBatch($users);


        // ==========================================
        // 2. SEEDING DATA BUKU (Dipastikan Struktur Baris Identik)
        // ==========================================
        $books = [
            [
                'id' => 1,
                'title' => 'Mastering Laravel 11',
                'author' => 'Taylor Otwell',
                'isbn' => '978-1-2345-6789-0',
                'cover_image' => 'default-laravel.jpg',
                'stock' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'title' => 'Flutter UI Bootcamp: Modern Design',
                'author' => 'Google Dev Team',
                'isbn' => '978-1-9876-5432-1',
                'cover_image' => 'default-flutter.jpg',
                'stock' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'title' => 'Clean Architecture & Bento Grid Layouts',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0-1344-9416-6',
                'cover_image' => 'default-ui.jpg',
                'stock' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Tambah data buku Faker, pastikan urutan key dan strukturnya sama persis dengan array manual di atas
        for ($i = 4; $i <= 50; $i++) {
            $books[] = [
                'id' => $i,
                'title' => ucwords($faker->words($faker->numberBetween(2, 4), true)),
                'author' => $faker->name(),
                'isbn' => $faker->isbn13(),
                'cover_image' => 'default_cover.jpg',
                'stock' => $faker->numberBetween(5, 15),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('books')->insertBatch($books);


        // ==========================================
        // 3. SEEDING DATA SIRKULASI PEMINJAMAN (LOANS)
        // ==========================================
        $loans = [
            // Simulasi 1: Buku sedang dipinjam, belum kembali, denda Rp 0 (payment_status: none)
            [
                'user_id' => 2,
                'book_id' => 1,
                'loan_date' => date('Y-m-d', strtotime('-3 days')),
                'due_date' => date('Y-m-d', strtotime('+4 days')),
                'return_date' => null, // Masih dipinjam
                'fine_amount' => 0,
                'payment_status' => 'none',
            ],
            // Simulasi 2: Buku terlambat, belum kembali, kena denda (Siap diuji coba ke Midtrans!)
            [
                'user_id' => 2,
                'book_id' => 2,
                'loan_date' => date('Y-m-d', strtotime('-12 days')),
                'due_date' => date('Y-m-d', strtotime('-5 days')),
                'return_date' => null, // Masih dipinjam
                'fine_amount' => 37000,
                'payment_status' => 'unpaid', // Belum dibayar, tombol bayar denda akan muncul
            ],
            // Simulasi 3: Buku sudah dikembalikan dengan aman (return_date terisi)
            [
                'user_id' => 2,
                'book_id' => 3,
                'loan_date' => date('Y-m-d', strtotime('-20 days')),
                'due_date' => date('Y-m-d', strtotime('-13 days')),
                'return_date' => date('Y-m-d', strtotime('-14 days')), // Sudah dikembalikan
                'fine_amount' => 0,
                'payment_status' => 'none',
            ],
        ];

        $this->db->table('loans')->insertBatch($loans);

        echo "Seeding Sukses! 10 Users, 50 Books, dan 3 Transaksi Sirkulasi berhasil dimasukkan ke Database.\n";
    }
}