<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="flat-card text-center p-5">
      <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
        style="width: 80px; height: 80px; border: 2px solid #10B981;">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
          class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
          <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
      </div>

      <h4 class="fw-bold text-dark mb-2">Pembayaran Berhasil!</h4>
      <p class="text-muted mb-4">ID Peminjaman: #<?= $loan_id ?></p>

      <div class="alert alert-info mb-5" style="border-radius: 12px; font-weight: 500;">
        <?= $statusEmail ?>
      </div>

      <a href="/member/dashboard" class="btn btn-custom w-100 fs-5 py-3">Kembali ke Dashboard</a>
    </div>
  </div>
</div>
<?= $this->endSection() ?>