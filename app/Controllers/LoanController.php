<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoanModel;

class LoanController extends BaseController
{
  protected $loanModel;

  public function __construct()
  {
    // 1. Inisialisasi LoanModel secara terpusat
    $this->loanModel = new LoanModel();
  }

  public function index()
  {
    // 2. Ambil User ID dari session login aktif
    $userId = session()->get('id');

    if (empty($userId)) {
      return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // 3. Ambil data pinjaman spesifik milik member yang sedang login
    // Method getLoansByUserId() otomatis melakukan JOIN dengan tabel books
    $myLoans = $this->loanModel->getLoansByUserId($userId);

    // 4. Siapkan data untuk dilempar ke dalam View rekap pinjaman
    $data = [
      'title' => 'Buku Pinjamanku',
      'loans' => $myLoans // <--- Variabel 'loans' ini yang dibaca oleh foreach di View!
    ];

    return view('member/loans/index', $data);
  }
}