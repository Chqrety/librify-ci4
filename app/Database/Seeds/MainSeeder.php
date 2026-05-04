<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin Pustakawan',
                'email' => 'admin@perpus.com',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Member Pustakawan',
                'email' => 'member@perpus.com',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'role' => 'member',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($users);

        $books = [
            [
                'title' => 'Mastering Laravel 11',
                'author' => 'Taylor Otwell',
                'isbn' => '978-1-2345-6789-0',
                'cover_image' => 'default-laravel.jpg',
                'stock' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Flutter UI Bootcamp: Modern Design',
                'author' => 'Google Dev Team',
                'isbn' => '978-1-9876-5432-1',
                'cover_image' => 'default-flutter.jpg',
                'stock' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Clean Architecture & Bento Grid Layouts',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0-1344-9416-6',
                'cover_image' => 'default-ui.jpg',
                'stock' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('books')->insertBatch($books);
    }
}
