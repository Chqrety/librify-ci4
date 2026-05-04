<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php
/**
 * @var array $book Data buku dari controller
 */
?>

<div class="mb-4">
  <a href="/admin/books" class="text-decoration-none fw-bold" style="color: #64748B;">Kembali ke Katalog</a>
</div>

<div class="flat-card" style="max-width: 800px;">
  <h4 class="fw-bold text-dark mb-4">Edit Data Buku</h4>

  <!-- Flash Message Error Validasi -->
  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger"
      style="border-radius: 12px; border: 1px solid #FECACA; background-color: #FEF2F2; color: #DC2626;">
      <ul class="mb-0">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
          <li>
            <?= $error ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="/admin/books/update/<?= $book['id'] ?>" method="POST" enctype="multipart/form-data">
    <!-- Input Hidden untuk menyimpan nama file gambar lama -->
    <input type="hidden" name="old_cover" value="<?= $book['cover_image'] ?>">

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-secondary small">Judul Buku</label>
        <input type="text" name="title" class="form-control" value="<?= old('title', $book['title']) ?>" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-secondary small">Penulis</label>
        <input type="text" name="author" class="form-control" value="<?= old('author', $book['author']) ?>" required>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-secondary small">ISBN</label>
        <input type="text" name="isbn" class="form-control" value="<?= old('isbn', $book['isbn']) ?>" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-secondary small">Jumlah Stok</label>
        <input type="number" name="stock" class="form-control" value="<?= old('stock', $book['stock']) ?>" required>
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label fw-semibold text-secondary small">Cover Buku (Kosongkan jika tidak ingin mengubah
        cover)</label>
      <input type="file" name="cover_image" class="form-control" accept="image/jpeg, image/png">
      <small class="text-muted d-block mt-2">Cover saat ini:
        <?= $book['cover_image'] ?>
      </small>
    </div>

    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-custom px-5">Perbarui Data</button>
    </div>
  </form>
</div>
<?= $this->endSection() ?>