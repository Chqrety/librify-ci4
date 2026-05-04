<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookModel;
use CodeIgniter\HTTP\ResponseInterface;

class BookController extends BaseController
{
    protected $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Katalog Buku',
            'books' => $this->bookModel->findAll()
        ];
        return view('admin/books/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Buku Baru'];
        return view('admin/books/create', $data);
    }

    public function store()
    {
        // 1. Aturan Validasi Input & File Upload
        $rules = [
            'title' => 'required|min_length[3]',
            'author' => 'required',
            'isbn' => 'required|is_unique[books.isbn]',
            'stock' => 'required|numeric',
            'cover_image' => 'uploaded[cover_image]|is_image[cover_image]|mime_in[cover_image,image/jpg,image/jpeg,image/png]|max_size[cover_image,2048]'
        ];

        // 2. Jika validasi gagal, kembalikan ke form dengan pesan error
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Proses Upload File
        $coverImage = $this->request->getFile('cover_image');
        $coverName = $coverImage->getRandomName(); // Generate nama unik
        $coverImage->move('uploads/covers', $coverName); // Pindah ke folder public/uploads/covers

        // 4. Simpan ke Database
        $this->bookModel->save([
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'isbn' => $this->request->getPost('isbn'),
            'stock' => $this->request->getPost('stock'),
            'cover_image' => $coverName
        ]);

        // 5. Flash Message Sukses
        return redirect()->to('/admin/books')->with('success', 'Buku berhasil ditambahkan ke katalog.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Buku',
            'book' => $this->bookModel->find($id)
        ];

        // Cek jika buku tidak ditemukan
        if (!$data['book']) {
            return redirect()->to('/admin/books')->with('error', 'Buku tidak ditemukan.');
        }

        return view('admin/books/edit', $data);
    }

    public function update($id)
    {
        $bookLama = $this->bookModel->find($id);

        // 1. Aturan Validasi
        // Pengecekan is_unique diabaikan jika ISBN tidak berubah
        $rule_isbn = $bookLama['isbn'] == $this->request->getPost('isbn') ? 'required' : 'required|is_unique[books.isbn]';

        $rules = [
            'title' => 'required|min_length[3]',
            'author' => 'required',
            'isbn' => $rule_isbn,
            'stock' => 'required|numeric',
            'cover_image' => 'is_image[cover_image]|mime_in[cover_image,image/jpg,image/jpeg,image/png]|max_size[cover_image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $coverImage = $this->request->getFile('cover_image');
        $namaCoverLama = $this->request->getPost('old_cover');

        // 2. Cek apakah ada file cover baru yang diupload
        if ($coverImage->getError() == 4) {
            // Jika tidak ada upload, pakai gambar lama
            $coverName = $namaCoverLama;
        } else {
            // Generate nama baru & pindahkan file
            $coverName = $coverImage->getRandomName();
            $coverImage->move('uploads/covers', $coverName);

            // Hapus gambar lama jika bukan default
            if ($namaCoverLama != 'default-laravel.jpg' && $namaCoverLama != 'default-flutter.jpg' && $namaCoverLama != 'default-ui.jpg') {
                if (file_exists('uploads/covers/' . $namaCoverLama)) {
                    unlink('uploads/covers/' . $namaCoverLama);
                }
            }
        }

        // 3. Simpan Update ke Database
        $this->bookModel->update($id, [
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'isbn' => $this->request->getPost('isbn'),
            'stock' => $this->request->getPost('stock'),
            'cover_image' => $coverName
        ]);

        return redirect()->to('/admin/books')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function delete($id)
    {
        $book = $this->bookModel->find($id);

        // Hapus file fisik gambar jika ada (dan bukan gambar default dari seeder)
        if ($book && $book['cover_image'] != 'default-laravel.jpg' && $book['cover_image'] != 'default-flutter.jpg' && $book['cover_image'] != 'default-ui.jpg') {
            if (file_exists('uploads/covers/' . $book['cover_image'])) {
                unlink('uploads/covers/' . $book['cover_image']);
            }
        }

        $this->bookModel->delete($id);
        return redirect()->to('/admin/books')->with('success', 'Buku berhasil dihapus dari sistem.');
    }

    public function show($id)
    {
        $book = $this->bookModel->find($id);

        if (!$book) {
            return redirect()->to('/admin/books')->with('error', 'Buku tidak ditemukan.');
        }

        // 1. Inisialisasi layanan Cache CI4
        $cache = \Config\Services::cache();

        // Buat kunci cache unik berdasarkan ISBN
        $cacheKey = 'google_books_isbn_' . str_replace('-', '', $book['isbn']);

        // 2. Cek apakah data API sudah ada di dalam cache
        $apiData = $cache->get($cacheKey);

        if ($apiData === null) {
            // 3. Jika belum di-cache, panggil Webservice Server (Google Books API)
            $client = \Config\Services::curlrequest();

            try {
                // Request GET ke Google Books API
                $response = $client->request('GET', 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $book['isbn']);
                $body = json_decode($response->getBody(), true);

                // Parsing data jika buku ditemukan di API
                if (isset($body['items'][0]['volumeInfo'])) {
                    $info = $body['items'][0]['volumeInfo'];
                    $apiData = [
                        'synopsis' => $info['description'] ?? 'Sinopsis tidak tersedia di database Google Books.',
                        'pageCount' => $info['pageCount'] ?? 'Tidak diketahui',
                        'publisher' => $info['publisher'] ?? 'Tidak diketahui',
                        'publishedDate' => $info['publishedDate'] ?? 'Tidak diketahui',
                        'categories' => isset($info['categories']) ? implode(', ', $info['categories']) : 'Uncategorized'
                    ];
                } else {
                    // Jika ISBN tidak ditemukan di Google Books
                    $apiData = [
                        'synopsis' => 'Buku ini tidak memiliki catatan di database global Google Books.',
                        'pageCount' => '-',
                        'publisher' => '-',
                        'publishedDate' => '-',
                        'categories' => '-'
                    ];
                }

                // 4. Simpan hasil API ke dalam Cache selama 24 jam (86400 detik)
                $cache->save($cacheKey, $apiData, 86400);

            } catch (\Exception $e) {
                // 5. Error Handling: Jika server Google down atau tidak ada internet
                $apiData = [
                    'synopsis' => 'Gagal mengambil data dari server. Error: ' . $e->getMessage(),
                    'pageCount' => '-',
                    'publisher' => '-',
                    'publishedDate' => '-',
                    'categories' => '-'
                ];
            }
        }

        $data = [
            'title' => 'Detail Buku',
            'book' => $book,
            'apiData' => $apiData
        ];

        return view('admin/books/show', $data);
    }
}
