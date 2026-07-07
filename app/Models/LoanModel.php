<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
  protected $table = 'loans';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType = 'array';

  // Sesuaikan persis dengan kolom migrasi asli kamu
  protected $allowedFields = [
    'user_id',
    'book_id',
    'loan_date',
    'due_date',
    'return_date',
    'fine_amount',
    'payment_status',
    'payment_token'
  ];

  protected $useTimestamps = true;

  public function getLoansByUserId($userId)
  {
    return $this->select('loans.*, books.title as book_title, books.cover_image, books.isbn')
      ->join('books', 'books.id = loans.book_id')
      ->where('loans.user_id', $userId)
      ->orderBy('loans.loan_date', 'DESC')
      ->findAll();
  }
}