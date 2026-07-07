<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MemberController extends BaseController
{
    public function index()
    {
        //
    }

    public function dashboard()
    {
        $data = ['title' => 'Dashboard Member'];
        return view('member/dashboard', $data);
    }

    public function search()
    {
        $bookModel = new \App\Models\BookModel();

        // Ambil keyword dari input 'q'
        $keyword = $this->request->getVar('');

        if ($keyword !== null && $keyword !== '') {
            // Jika ada pencarian
            $books = $bookModel->asArray()
                ->groupStart() // Mengelompokkan LIKE agar logic OR benar
                ->like('title', $keyword)
                ->orLike('author', $keyword)
                ->groupEnd()
                ->findAll();
        } else {
            // Jika tidak ada keyword, ambil semua buku (Limit 12 untuk dashboard)
            $books = $bookModel->asArray()
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        $data = [
            'title' => 'Cari Buku',
            'keyword' => $keyword,
            'local_books' => $books
        ];

        return view('member/search', $data);
    }
}
