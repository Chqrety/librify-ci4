<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Librify</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>

<body>

  <div class="login-card">
    <h3 class="fw-bold mb-2 text-center" style="letter-spacing: -0.5px; color: #0F172A;">Welcome Back</h3>
    <p class="text-center mb-4" style="color: #64748B; font-weight: 400; font-size: 0.95rem;">Masuk ke sistem Librify
    </p>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-custom mb-4">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <form action="/login" method="POST">
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="admin@perpus.com" required
          autocomplete="off">
      </div>
      <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn btn-custom w-100">Sign In</button>
    </form>
  </div>

</body>

</html>