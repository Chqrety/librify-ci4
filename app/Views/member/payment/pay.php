<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="flat-card text-center p-5">
      <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
        style="width: 80px; height: 80px; border: 2px solid #E2E8F0;">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
          class="bi bi-wallet2 text-warning" viewBox="0 0 16 16">
          <path
            d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
        </svg>
      </div>

      <h4 class="fw-bold text-dark mb-2">Tagihan Denda</h4>
      <p class="text-muted mb-4">ID Peminjaman: #<?= $loan_id ?></p>

      <h1 class="fw-bold" style="color: #10B981;">Rp <?= number_format($dendaAmount, 0, ',', '.') ?></h1>
      <p class="text-secondary small mb-5">Harap segera lunasi denda keterlambatan Anda agar dapat meminjam buku
        kembali.</p>

      <!-- Tombol Pay -->
      <button id="pay-button" class="btn btn-custom w-100 fs-5 py-3">Bayar Sekarang</button>
    </div>
  </div>
</div>

<!-- Mengambil Script Midtrans Sandbox (Ganti src dengan production jika sudah live) -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $clientKey ?>"></script>
<script type="text/javascript">
  document.getElementById('pay-button').onclick = function () {
    // Menjalankan Snap dengan token dari Controller
    window.snap.pay('<?= $snapToken ?>', {
      onSuccess: function (result) {
        alert("Pembayaran berhasil!"); console.log(result);
        // Nanti bisa diarahkan ke fungsi update status denda di Controller
        window.location.href = '/member/dashboard';
      },
      onPending: function (result) {
        alert("Menunggu pembayaran Anda!"); console.log(result);
      },
      onError: function (result) {
        alert("Pembayaran gagal!"); console.log(result);
      },
      onClose: function () {
        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
      }
    });
  };
</script>
<?= $this->endSection() ?>