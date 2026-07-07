<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class LibrifySeeder extends Seeder
{
    public function run()
    {
        // Inisialisasi Faker dengan lokalisasi Indonesia
        $faker = Factory::create('id_ID');

        // ==========================================
        // 1. SEEDING DATA MEMBER (10 Data)
        // ==========================================
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                // Sesuaikan nama kolom dengan struktur tabel users kamu
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => password_hash('member123', PASSWORD_DEFAULT),
                'role' => 'member',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Insert Batch untuk performa query yang lebih cepat
        // ==========================================
        // 2. SEEDING DATA BUKU (50 Data) - REVISI
        // ==========================================
        $books = [];

        for ($i = 0; $i < 50; $i++) {
            $books[] = [
                // Menyesuaikan persis dengan kolom di gambar struktur tabel
                'title' => ucwords($faker->words($faker->numberBetween(2, 6), true)),
                'author' => $faker->name(),
                'isbn' => $faker->isbn13(), // Faker punya fungsi khusus generate nomor ISBN
                'cover_image' => 'default_cover.jpg',
                'stock' => $faker->numberBetween(1, 50), // Random stok dari 1 sampai 50
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Insert Batch ke tabel 'books'
        $this->db->table('books')->insertBatch($books);

        echo "50 Data Books berhasil di-seed sesuai skema terbaru!\n";
    }
}
