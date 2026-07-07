<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
  /* Modern Soft UI Bento Style Layout */
  .bento-wrapper {
    background: #ffffff;
    border: 1px solid #edf2f7;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    padding: 1.5rem;
  }

  .table-container-bento {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
  }

  .table-bento {
    margin-bottom: 0;
  }

  .table-bento thead {
    background-color: #f8fafc;
  }

  .table-bento th {
    color: #64748b;
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.25rem;
  }

  .table-bento td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
    color: #334155;
    font-size: 0.85rem;
    border-bottom: 1px solid #f1f5f9;
  }

  .table-bento tbody tr:last-child td {
    border-bottom: none;
  }

  .table-bento tbody tr:hover {
    background-color: #f8fafc;
  }

  /* Cover Thumbnail */
  .bento-cover-thumb {
    width: 42px;
    height: 56px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    background-color: #f8fafc;
  }

  /* Custom Badges */
  .badge-bento-warning {
    background-color: #fef3c7;
    color: #d97706;
    font-weight: 600;
    font-size: 11px;
    padding: 5px 10px;
    border-radius: 6px;
    display: inline-block;
  }

  .badge-bento-success {
    background-color: #d1fae5;
    color: #059669;
    font-weight: 600;
    font-size: 11px;
    padding: 5px 10px;
    border-radius: 6px;
    display: inline-block;
  }

  /* Custom Buttons */
  .btn-bento-action {
    background-color: #ef4444;
    color: #ffffff;
    font-weight: 700;
    font-size: 0.75rem;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.2s;
  }

  .btn-bento-action:hover {
    background-color: #dc2626;
    color: #ffffff;
  }

  .btn-bento-nav {
    background-color: #10B981;
    color: #ffffff;
    font-weight: 700;
    font-size: 0.8rem;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 12px;
    text-decoration: none;
    transition: background-color 0.2s;
  }

  .btn-bento-nav:hover {
    background-color: #059669;
    color: #ffffff;
  }
</style>

<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1" style="color: #1e293b;"><?= esc($title); ?></h4>
      <p class="text-muted small mb-0">Pantau sirkulasi buku yang sedang kamu pinjam dan riwayat pengembalian.</p>
    </div>
    <a href="/member/search" class="btn btn-bento-nav shadow-sm">
      + Cari & Pinjam Buku
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center"
      style="border-radius: 14px; background-color: #ecfdf5; color: #065f46;">
      <span class="me-2">🎉</span> <?= session()->getFlashdata('success'); ?>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center"
      style="border-radius: 14px; background-color: #fff5f5; color: #9b1c1c;">
      <span class="me-2">⚠️</span> <?= session()->getFlashdata('error'); ?>
    </div>
  <?php endif; ?>

  <?php if (empty($loans)): ?>
    <div class="text-center py-5 border rounded-3 bg-white border-dashed"
      style="border-style: dashed !important; border-radius: 16px !important; border-color: #e2e8f0 !important;">
      <span style="font-size: 2.5rem;">📚</span>
      <h5 class="text-secondary fw-semibold mt-3">Belum Ada Peminjaman</h5>
      <p class="text-muted small mb-4 max-w-sm mx-auto">Kamu tidak sedang meminjam buku apa pun saat ini. Yuk, cari buku
        menarik di katalog perpustakaan!</p>
      <a href="/member/search" class="btn btn-sm btn-outline-secondary px-3" style="border-radius: 8px;">
        Buka Katalog Buku
      </a>
    </div>
  <?php else: ?>

    <div class="bento-wrapper">
      <div class="table-responsive table-container-bento">
        <table class="table table-bento align-middle">
          <thead>
            <tr>
              <th scope="col">Buku</th>
              <th scope="col">Tanggal Pinjam</th>
              <th scope="col">Batas Kembali</th>
              <th scope="col">Status</th>
              <th scope="col">Denda</th>
              <th scope="col" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($loans as $loan): ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <?php if (!empty($loan['cover_image']) && file_exists(FCPATH . 'uploads/covers/' . $loan['cover_image'])): ?>
                      <img src="<?= base_url('uploads/covers/' . $loan['cover_image']) ?>" class="bento-cover-thumb me-3"
                        alt="Cover">
                    <?php else: ?>
                      <div class="bento-cover-thumb me-3 d-flex align-items-center justify-content-center text-muted bg-light"
                        style="font-size: 1.25rem;">
                        📘
                      </div>
                    <?php endif; ?>
                    <div>
                      <div class="fw-bold text-dark mb-0" style="font-size: 0.9rem;"><?= esc($loan['book_title']); ?></div>
                      <div class="text-muted" style="font-size: 11px;">ISBN: <?= esc($loan['isbn'] ?? '-'); ?></div>
                    </div>
                  </div>
                </td>

                <td class="text-secondary">
                  <?= date('d M Y', strtotime($loan['loan_date'])); ?>
                </td>

                <td class="text-secondary">
                  <?= date('d M Y', strtotime($loan['due_date'])); ?>

                  <?php if (empty($loan['return_date']) && strtotime(date('Y-m-d')) > strtotime($loan['due_date'])): ?>
                    <span class="d-block text-danger fw-medium mt-1" style="font-size: 11px;">⚠️ Terlambat Kembali</span>
                  <?php endif; ?>
                </td>

                <td>
                  <?php if (empty($loan['return_date'])): ?>
                    <span class="badge-bento-warning">Sedang Dipinjam</span>
                  <?php else: ?>
                    <span class="badge-bento-success">Sudah Kembali</span>
                  <?php endif; ?>
                </td>

                <td class="fw-bold text-dark">
                  Rp <?= number_format($loan['fine_amount'], 0, ',', '.'); ?>
                </td>

                <td class="text-center">
                  <?php if ($loan['fine_amount'] > 0 && $loan['payment_status'] === 'unpaid'): ?>
                    <a href="/member/payment/fine/<?= $loan['id']; ?>" class="btn-bento-action shadow-sm">
                      💳 Bayar Denda
                    </a>
                  <?php elseif ($loan['fine_amount'] > 0 && $loan['payment_status'] === 'paid'): ?>
                    <span class="text-success small fw-semibold">✓ Lunas</span>
                  <?php else: ?>
                    <span class="text-muted small">-</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  <?php endif; ?>
</div>

<?= $this->endSection() ?>