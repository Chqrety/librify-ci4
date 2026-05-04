<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold text-dark mb-0">Manajemen Buku</h4>
  <a href="/admin/books/create" class="btn btn-custom px-4">Tambah Buku</a>
</div>

<!-- Flash Message Sukses -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"
    style="border-radius: 12px; border: 1px solid #A7F3D0; background-color: #ECFDF5; color: #065F46; font-weight: 500;">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<div class="flat-card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th class="text-secondary fw-semibold">Cover</th>
          <th class="text-secondary fw-semibold">Judul Buku</th>
          <th class="text-secondary fw-semibold">Penulis</th>
          <th class="text-secondary fw-semibold">ISBN</th>
          <th class="text-secondary fw-semibold">Stok</th>
          <th class="text-secondary fw-semibold text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($books as $book): ?>
          <tr>
            <td>
              <?php
              // Logika sederhana untuk cover dummy dari seeder vs cover hasil upload
              $isDefault = strpos($book['cover_image'], 'default') !== false;
              $coverUrl = $isDefault ? 'https://via.placeholder.com/50x70?text=Cover' : base_url('uploads/covers/' . $book['cover_image']);
              ?>
              <img src="<?= $coverUrl ?>" alt="Cover"
                style="width: 50px; height: 70px; object-fit: cover; border-radius: 6px; border: 1px solid #E2E8F0;">
            </td>
            <td class="fw-bold text-dark"><?= $book['title'] ?></td>
            <td><?= $book['author'] ?></td>
            <td><?= $book['isbn'] ?></td>
            <td>
              <span class="badge bg-light text-dark border px-2 py-1"><?= $book['stock'] ?> Pcs</span>
            </td>
            <td class="text-center">
              <a href="/admin/books/edit/<?= $book['id'] ?>" class="btn btn-sm btn-outline-primary me-2"
                style="border-radius: 8px; font-weight: 600;">Edit</a>
              <a href="/admin/books/delete/<?= $book['id'] ?>" class="btn btn-sm btn-outline-danger"
                style="border-radius: 8px; font-weight: 600;"
                onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>

        <?php if (empty($books)): ?>
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">Belum ada data buku.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>