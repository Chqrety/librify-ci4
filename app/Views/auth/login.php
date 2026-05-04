<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Libray.io</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      /* Latar belakang Soft Slate yang tenang di mata */
      background-color: #F1F5F9;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      font-family: 'Inter', system-ui, sans-serif;
      color: #334155;
    }

    .login-card {
      background: #FFFFFF;
      border-radius: 20px;
      padding: 48px 40px;
      width: 100%;
      max-width: 420px;
      /* Flat Design 2.0: Bayangan super lembut yang menyebar */
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
      border: 1px solid #E2E8F0;
    }

    .form-control {
      border-radius: 12px;
      padding: 14px 16px;
      border: 1px solid #CBD5E1;
      background-color: #F8FAFC;
      font-weight: 500;
      color: #0F172A;
      transition: all 0.2s ease;
    }

    .form-control:focus {
      /* Efek glow hijau zamrud saat input aktif */
      box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
      border-color: #10B981;
      background-color: #FFFFFF;
    }

    .btn-custom {
      /* Warna aksen Emerald Green */
      background-color: #10B981;
      color: #FFFFFF;
      border-radius: 12px;
      padding: 14px;
      font-weight: 600;
      letter-spacing: 0.5px;
      border: none;
      /* Bayangan tombol untuk efek elevasi material */
      box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2), 0 2px 4px -2px rgba(16, 185, 129, 0.2);
      transition: all 0.2s ease;
    }

    .btn-custom:hover {
      background-color: #059669;
      transform: translateY(-1px);
      box-shadow: 0 6px 8px -1px rgba(16, 185, 129, 0.3), 0 4px 6px -2px rgba(16, 185, 129, 0.2);
      color: #FFFFFF;
    }

    .btn-custom:active {
      transform: translateY(0);
      box-shadow: none;
    }

    .form-label {
      font-weight: 600;
      font-size: 0.85rem;
      color: #64748B;
      margin-bottom: 6px;
    }

    .alert-custom {
      border-radius: 12px;
      border: 1px solid #FECACA;
      background-color: #FEF2F2;
      color: #DC2626;
      font-weight: 500;
      font-size: 0.9rem;
      padding: 12px 16px;
    }
  </style>
</head>

<body>

  <div class="login-card">
    <h3 class="fw-bold mb-2 text-center" style="letter-spacing: -0.5px; color: #0F172A;">Welcome Back</h3>
    <p class="text-center mb-4" style="color: #64748B; font-weight: 400; font-size: 0.95rem;">Masuk ke sistem Libray.io
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