<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoansTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'book_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'loan_date' => ['type' => 'DATE'],
            'due_date' => ['type' => 'DATE'],
            'return_date' => ['type' => 'DATE', 'null' => true],
            'fine_amount' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'payment_status' => ['type' => 'ENUM', 'constraint' => ['none', 'unpaid', 'paid'], 'default' => 'none'],
            'payment_token' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('book_id', 'books', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('loans');
    }

    public function down()
    {
        $this->forge->dropTable('loans');
    }
}
