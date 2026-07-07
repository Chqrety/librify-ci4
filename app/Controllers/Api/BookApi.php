<?php

namespace App\Controllers\Api;

use App\Models\BookModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class BookApi extends ResourceController
{
    protected $modelName = 'App\Models\BookModel';
    protected $format = 'json';

    // endpoint: GET /api/books
    public function index()
    {
        // Mengambil semua data buku dari database internal perpustakaan
        $books = $this->model->orderBy('id', 'DESC')->findAll();

        if (empty($books)) {
            return $this->respond([
                'status' => true,
                'message' => 'Katalog buku masih kosong.',
                'data' => []
            ], 200);
        }

        // Response JSON rapi berstandar RESTful
        return $this->respond([
            'status' => true,
            'message' => 'Berhasil mengambil seluruh data katalog internal.',
            'total' => count($books),
            'data' => $books
        ], 200);
    }
}