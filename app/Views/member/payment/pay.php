<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
  /* Modern Soft UI Bento Card Style */
  .bento-pay-card {
    background: #ffffff;
    border: 1px solid #edf2f7;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    padding: 3rem 2rem;
    transition: transform 0.3s ease;
  }

  /* Icon Wrapper Accent */
  .icon-box-accent {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: #fef3c7;
    /* Soft amber pulse */
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    border: 2px solid #fde68a;
  }

  /* Soft UI Custom Primary Button */
  .btn-bento-pay {
    background-color: #10B981;
    color: #ffffff;
    font-weight: 700;
    border: none;
    padding: 1rem 1.5rem;
    border-radius: 14px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
  }

  .btn-bento-pay:hover {
    background-color: #059669;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(5, 150, 105, 0.25);
  }

  .btn-bento-pay:active {
    transform: translateY(0);
  }
</style>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 text-center">

      <div class="bento-pay-card">
        <div class="icon-box-accent">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
            class="bi bi-wallet2 text-warning" viewBox="0 0 16 16">
            <path
              d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
          </svg>
        </div>

        <h4 class="fw-bold mb-1" style="color: #1e293b;">Tagihan Denda</h4>
        <p class="text-muted small mb-4" style="letter-spacing: 0.05em;">ID PEMINJAMAN: #<?= esc($loan_id) ?></p>

        <div class="py-2 mb-3">
          <h1 class="fw-extrabold mb-0" style="color: #10B981; font-size: 2.75rem;">
            Rp <?= number_format($dendaAmount, 0, ',', '.') ?>
          </h1>
        </div>

        <p class="text-secondary small mx-auto mb-5" style="max-width: 280px; line-height: 1.5;">
          Harap segera lunasi denda keterlambatan Anda agar status sirkulasi kembali bersih.
        </p>

        <button id="pay-button" class="btn btn-bento-pay w-100 fs-6 shadow-sm">
          ⚡ Bayar Sekarang via Midtrans
        </button>
      </div>

    </div>
  </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $clientKey ?>"></script>
<script type="text/javascript">
  document.getElementById('pay-button').onclick = function () {
    // Eksekusi Snap Handler menggunakan token dinamis dari Controller
    window.snap.pay('<?= $snapToken ?>', {
      onSuccess: function (result) {
        console.log(result);
        // Diarahkan langsung ke route handle success agar payment_status terupdate jadi 'paid'
        window.location.href = '<?= base_url("member/payment/success/") ?>' + '<?= $loan_id ?>';
      },
      onPending: function (result) {
        console.log(result);
        alert("Transaksi pending! Segera selesaikan pembayaran sebelum kedaluwarsa.");
        window.location.href = '<?= base_url("member/loans") ?>';
      },
      onError: function (result) {
        console.log(result);
        alert("Pembayaran gagal! Silakan coba kembali beberapa saat lagi.");
      },
      onClose: function () {
        alert('Anda menutup panel pembayaran gateway tanpa menyelesaikan transaksi.');
      }
    });
  };
</script>

<?= $this->endSection() ?>