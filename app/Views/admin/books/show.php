<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
/**
 * @var array $book Data buku dari database lokal
 * @var array $apiData Data buku dari Google API
 */
?>

<div class="mb-4">
  <a href="/admin/books" class="text-decoration-none fw-bold" style="color: #64748B;">Kembali ke Katalog</a>
</div>

<div class="row">
  <!-- Kolom Data Lokal (Database) -->
  <div class="col-md-4 mb-4">
    <div class="flat-card h-100 text-center">
      <?php
      $isDefault = strpos($book['cover_image'], 'default') !== false;
      $coverUrl = $isDefault ? 'https://via.placeholder.com/200x300?text=Cover' : base_url('uploads/covers/' . $book['cover_image']);
      ?>
      <img src="<?= $coverUrl ?>" alt="Cover Buku" class="img-fluid mb-3"
        style="border-radius: 12px; border: 1px solid #E2E8F0; max-height: 250px;">
      <h5 class="fw-bold text-dark mb-1"><?= $book['title'] ?></h5>
      <p class="text-muted mb-3"><?= $book['author'] ?></p>

      <div class="d-flex justify-content-between align-items-center bg-light px-3 py-2"
        style="border-radius: 8px; border: 1px solid #E2E8F0;">
        <span class="text-secondary fw-semibold small">Sistem Stok:</span>
        <span class="badge bg-success text-white px-2 py-1"><?= $book['stock'] ?> Pcs</span>
      </div>
      <div class="d-flex justify-content-between align-items-center bg-light px-3 py-2 mt-2"
        style="border-radius: 8px; border: 1px solid #E2E8F0;">
        <span class="text-secondary fw-semibold small">ISBN:</span>
        <span class="fw-bold text-dark small"><?= $book['isbn'] ?></span>
      </div>
    </div>
  </div>

  <!-- Kolom Data Eksternal (Google Books API) -->
  <div class="col-md-8 mb-4">
    <div class="flat-card h-100">
      <div class="d-flex align-items-center mb-3">
        <div class="bg-light d-flex align-items-center justify-content-center me-3"
          style="width: 40px; height: 40px; border-radius: 8px; border: 1px solid #E2E8F0;">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-cloud-arrow-down" viewBox="0 0 16 16" style="color: #0EA5E9;">
            <path fill-rule="evenodd"
              d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708l2 2z" />
            <path
              d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
          </svg>
        </div>
        <h5 class="fw-bold text-dark mb-0">Informasi Global (Google Books)</h5>
      </div>

      <p class="text-secondary mb-4" style="line-height: 1.6;">
        <?= $apiData['synopsis'] ?>
      </p>

      <div class="row g-3">
        <div class="col-sm-6">
          <div class="p-3 border rounded-3 bg-light">
            <small class="d-block text-muted fw-bold mb-1 text-uppercase" style="font-size: 0.75rem;">Kategori</small>
            <span class="text-dark fw-medium"><?= $apiData['categories'] ?></span>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="p-3 border rounded-3 bg-light">
            <small class="d-block text-muted fw-bold mb-1 text-uppercase" style="font-size: 0.75rem;">Penerbit</small>
            <span class="text-dark fw-medium"><?= $apiData['publisher'] ?> (<?= $apiData['publishedDate'] ?>)</span>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="p-3 border rounded-3 bg-light">
            <small class="d-block text-muted fw-bold mb-1 text-uppercase" style="font-size: 0.75rem;">Jumlah
              Halaman</small>
            <span class="text-dark fw-medium"><?= $apiData['pageCount'] ?> Halaman</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>