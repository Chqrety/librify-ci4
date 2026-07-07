<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Librify' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body>

  <div class="wrapper">
    <aside class="sidebar d-none d-md-flex">
      <div class="sidebar-header">
        <h4>Libri<span>fy</span>.</h4>
      </div>
      <div class="sidebar-menu">
        <small class="text-muted ms-3 fw-bold text-uppercase" style="font-size: 0.7rem;">Menu Utama</small>

        <?php if (session()->get('role') === 'admin'): ?>
          <a href="<?= base_url('admin/dashboard') ?>"
            class="nav-link-custom <?= url_is('admin/dashboard') ? 'active' : '' ?> mt-2">
            Dashboard
          </a>
          <a href="<?= base_url('admin/books') ?>" class="nav-link-custom <?= url_is('admin/books*') ? 'active' : '' ?>">
            Katalog Buku
          </a>
          <a href="#" class="nav-link-custom" title="Fitur dalam pengembangan">
            Data Peminjaman
          </a>
        <?php else: ?>
          <a href="<?= base_url('member/dashboard') ?>"
            class="nav-link-custom <?= url_is('member/dashboard') ? 'active' : '' ?> mt-2">
            Dashboard
          </a>
          <a href="<?= base_url('member/search') ?>"
            class="nav-link-custom <?= url_is('member/search') ? 'active' : '' ?>">
            Cari Buku
          </a>
          <a href="<?= base_url('member/loans') ?>"
            class="nav-link-custom <?= url_is('member/loans*') ? 'active' : '' ?>">
            Peminjaman Saya
          </a>
        <?php endif; ?>
      </div>
      <div class="sidebar-footer">
        <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger w-100 fw-bold"
          style="border-radius: 10px;">Logout</a>
      </div>
    </aside>

    <main class="main-content">
      <nav class="top-navbar">
        <div class="fw-bold text-dark fs-5">
          <?= $title ?? 'Dashboard' ?>
        </div>
        <div class="d-flex align-items-center">
          <span class="me-3 fw-medium" style="color: #475569;">Halo,
            <?= session()->get('name') ?>
          </span>
          <div class="bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold"
            style="width: 40px; height: 40px; color: #10B981; border: 2px solid #10B981;">
            <?= strtoupper(substr(session()->get('name') ?? 'U', 0, 1)) ?>
          </div>
        </div>
      </nav>

      <div class="content-wrapper">
        <?= $this->renderSection('content') ?>
      </div>
    </main>
  </div>

</body>

</html>