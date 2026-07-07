<?= $this->extend('layouts/main') ?> <!-- Sesuaikan dengan nama file layout kamu -->

<?= $this->section('content') ?>

<style>
  /* Styling Soft UI & Bento Grid style untuk Card Buku */
  .book-card {
    border: none;
    border-radius: 16px;
    background: #ffffff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    overflow: hidden;
  }

  .book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }

  .book-cover {
    height: 250px;
    object-fit: cover;
    width: 100%;
    background-color: #f8fafc;
  }

  .search-box {
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    border: 1px solid #e2e8f0;
  }

  .search-box input:focus {
    box-shadow: none;
    border-color: #10B981;
  }
</style>

<div class="container-fluid py-3">

  <!-- Header & Search Bar -->
  <div class="row mb-4">
    <div class="col-12 col-md-8 mx-auto text-center">
      <h3 class="fw-bold mb-3" style="color: #1e293b;">Temukan Buku Favoritmu</h3>
      <p class="text-muted mb-4">Cari buku dari koleksi perpustakaan lokal atau database Google Books API.</p>

      <form action="" method="GET" class="d-flex search-box bg-white p-1">
        <input type="text" name="q" class="form-control border-0 ps-3"
          placeholder="Masukkan judul buku, penulis, atau ISBN..." aria-label="Search">
        <button class="btn text-white px-4 fw-bold" type="submit"
          style="background-color: #10B981; border-radius: 10px;">
          Cari
        </button>
      </form>
    </div>
  </div>

  <!-- Area Hasil Pencarian (Grid Layout) -->
  <div class="row g-4">

    <?php if (empty($local_books)): ?>
      <div class="col-12 text-center py-5">
        <h5 class="text-muted">Buku tidak ditemukan di database lokal.</h5>
      </div>
    <?php else: ?>

      <?php foreach ($local_books as $book): ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card book-card h-100">

            <!-- Cover Buku -->
            <?php if ($book['cover_image'] !== 'default_cover.jpg' && file_exists(FCPATH . 'uploads/' . $book['cover_image'])): ?>
              <img src="<?= base_url('uploads/' . $book['cover_image']) ?>" class="card-img-top book-cover" alt="Cover">
            <?php else: ?>
              <div class="d-flex align-items-center justify-content-center book-cover text-muted fs-1 bg-light">
                📚
              </div>
            <?php endif; ?>

            <div class="card-body d-flex flex-column">
              <!-- Status Badge -->
              <?php if ($book['stock'] > 0): ?>
                <span class="badge bg-success bg-opacity-10 text-success mb-2 align-self-start">Tersedia
                  (<?= $book['stock'] ?>)
                </span>
              <?php else: ?>
                <span class="badge bg-danger bg-opacity-10 text-danger mb-2 align-self-start">Habis</span>
              <?php endif; ?>

              <!-- Info Buku -->
              <h6 class="card-title fw-bold text-truncate" title="<?= esc($book['title']) ?>">
                <?= esc($book['title']) ?>
              </h6>
              <p class="card-text text-muted small mb-3">
                <?= esc($book['author']) ?>
              </p>

              <!-- Tombol -->
              <button class="btn btn-sm btn-outline-primary mt-auto w-100 fw-medium" style="border-radius: 8px;">
                Detail Buku
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    <?php endif; ?>

  </div>
</div>

<?= $this->endSection() ?>