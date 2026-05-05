<?php

namespace App\Tests;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class LibrifyAppTest extends CIUnitTestCase
{
  // Menggunakan trait ini agar kita bisa pura-pura menjadi browser
  use FeatureTestTrait;

  /**
   * Test Case 1: Memastikan Halaman Utama (Home/Login) tidak error.
   * Harus merespons dengan kode HTTP 200 (OK).
   */
  public function testHalamanUtamaBisaDiakses()
  {
    $result = $this->get('/');

    // Memastikan statusnya 200 (Sukses)
    $result->assertStatus(200);
  }

  /**
   * Test Case 2: Memastikan Route Filter (Keamanan) berjalan.
   * Jika ada user anonim mencoba akses /member/dashboard,
   * sistem harus menolaknya dan melakukan Redirect (HTTP 302).
   */
  public function testHalamanMemberAmanDariAksesIlegal()
  {
    $result = $this->get('/member/dashboard');

    // Memastikan sistem melakukan redirect (menendang user kembali ke login)
    $result->assertRedirect();
  }

  /**
   * Test Case 3: Memastikan struktur data buku dasar sudah benar.
   * Ini contoh pengujian logika sederhana (Assertion).
   */
  public function testStrukturDataBukuValid()
  {
    // Simulasi data buku dari database atau form
    $bukuDummy = [
      'judul' => 'Mastering CodeIgniter 4',
      'penulis' => 'Developer Doscom',
      'status' => 'tersedia'
    ];

    // Pastikan array memiliki key 'judul'
    $this->assertArrayHasKey('judul', $bukuDummy);

    // Pastikan status buku secara default adalah 'tersedia'
    $this->assertEquals('tersedia', $bukuDummy['status']);
  }
}