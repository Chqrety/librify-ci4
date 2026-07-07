<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
        <h5 class="fw-bold mb-4">Tambah Koleksi Buku</h5>

        <div class="mb-4 p-3 bg-light rounded-3 border">
          <label class="form-label fw-semibold small text-secondary">Ambil Data Otomatis via Open Library API</label>
          <div class="input-group">
            <input type="text" id="isbn-search" class="form-control"
              placeholder="Masukkan Nomor ISBN... (Contoh: 9780134190440)">
            <button type="button" id="btn-cari-api" class="btn btn-success fw-bold px-3">🔍 Cari Data</button>
          </div>
          <small id="api-status-text" class="text-muted d-block mt-1 style='font-size:11px;'"></small>
        </div>

        <form action="/admin/books/store" method="POST" enctype="multipart/form-data">
          <?= csrf_field(); ?>

          <div class="mb-3">
            <label class="form-label fw-bold">Nomor ISBN Resmi</label>
            <input type="text" name="isbn" id="form-isbn" class="form-control" required readonly
              placeholder="Akan terisi setelah cari data...">
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Judul Buku</label>
            <input type="text" name="title" id="form-title" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Penulis / Author</label>
            <input type="text" name="author" id="form-author" class="form-control" required>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Penerbit</label>
              <input type="text" name="publisher" id="form-publisher" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Tahun Terbit</label>
              <input type="text" name="publish_date" id="form-year" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Jumlah Stok Buku</label>
            <input type="number" name="stock" class="form-control" value="5" required min="1">
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold">Upload Cover File Buku</label>
            <input type="file" name="cover_image" class="form-control">

            <input type="hidden" name="api_cover_url" id="form-cover-url">
            <div id="cover-preview-wrapper" class="mt-2 d-none">
              <small class="text-muted d-block mb-1">Preview Cover dari API:</small>
              <img id="cover-preview" src="" style="width: 80px; height: 110px; object-fit: cover; border-radius: 6px;"
                alt="Preview">
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="/admin/books" class="btn btn-light px-4" style="border-radius: 10px;">Batal</a>
            <button type="submit" class="btn btn-primary px-4"
              style="border-radius: 10px; background-color: #10B981; border:none;">Simpan Buku</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('btn-cari-api').onclick = function () {
    const isbnInput = document.getElementById('isbn-search').value.trim();
    const statusText = document.getElementById('api-status-text');
    const btn = document.getElementById('btn-cari-api');

    if (!isbnInput) {
      alert('Tolong masukkan nomor ISBN terlebih dahulu.');
      return;
    }

    // Ubah UI menjadi Loading State
    btn.disabled = true;
    btn.innerText = 'Memuat...';
    statusText.className = "text-primary d-block mt-1 animate-pulse";
    statusText.innerText = '⏳ Sedang mengkonsumsi Open Library Webservice...';

    // Eksekusi AJAX GET ke Controller internal CodeIgniter 4
    fetch(`/admin/books/fetch-isbn?isbn=${isbnInput}`, {
      method: 'GET',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
      .then(response => response.json())
      .then(res => {
        btn.disabled = false;
        btn.innerText = '🔍 Cari Data';

        if (res.status === true) {
          statusText.className = "text-success d-block mt-1 fw-semibold";
          statusText.innerText = `🎉 Data berhasil ditarik! (Sumber: ${res.source.toUpperCase()})`;

          // 4. AUTO-FILL FORM SECARA REALTIME
          document.getElementById('form-isbn').value = isbnInput;
          document.getElementById('form-title').value = res.data.title;
          document.getElementById('form-author').value = res.data.author;
          document.getElementById('form-publisher').value = res.data.publisher;
          document.getElementById('form-year').value = res.data.publish_date;

          // Handle preview gambar cover dari API
          if (res.data.cover_url) {
            document.getElementById('form-cover-url').value = res.data.cover_url;
            document.getElementById('cover-preview').src = res.data.cover_url;
            document.getElementById('cover-preview-wrapper').classList.remove('d-none');
          } else {
            document.getElementById('cover-preview-wrapper').classList.add('d-none');
          }
        } else {
          statusText.className = "text-danger d-block mt-1";
          statusText.innerText = '⚠️ ' + res.message;
          alert(res.message);
        }
      })
      .catch(err => {
        btn.disabled = false;
        btn.innerText = '🔍 Cari Data';
        statusText.className = "text-danger d-block mt-1";
        statusText.innerText = '❌ Gagal terhubung ke internal server.';
        console.error(err);
      });
  };
</script>
<?= $this->endSection() ?>