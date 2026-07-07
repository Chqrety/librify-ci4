<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Modern Soft UI & Bento Grid Custom Layout */
    .search-wrapper {
        max-width: 720px;
        margin: 0 auto;
    }

    .bento-search-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 6px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
    }

    .bento-search-box:focus-within {
        border-color: #10B981;
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.1);
    }

    .bento-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.5rem;
    }

    @media (min-width: 576px) {
        .bento-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media (min-width: 768px) {
        .bento-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    }
    @media (min-width: 1024px) {
        .bento-grid { grid-template-columns: repeat(5, minmax(0, 1fr)); }
    }

    .book-bento-card {
        border: 1px solid #edf2f7;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .book-bento-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    }

    .cover-container {
        position: relative;
        width: 100%;
        padding-top: 133.33%; /* Aspect Ratio 3:4 Presisi */
        background-color: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .cover-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .book-bento-card:hover .cover-img {
        transform: scale(1.03);
    }

    .card-content {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .text-clamp-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-weight: 700;
        color: #1e293b;
        font-size: 0.9rem;
        line-height: 1.35;
        margin-bottom: 0.25rem;
    }

    .text-clamp-author {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 0.75rem;
        color: #94a3b8;
        margin-bottom: 1rem;
    }

    .btn-bento-primary {
        background-color: #10B981;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.75rem;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: background 0.2s;
    }

    .btn-bento-primary:hover {
        background-color: #059669;
        color: #ffffff;
    }

    .btn-bento-secondary {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 0.75rem;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        text-align: center;
        text-decoration: none;
        display: block;
        transition: all 0.2s;
    }

    .btn-bento-secondary:hover {
        background-color: #f1f5f9;
        color: #334155;
    }
</style>

<div class="container py-4">

    <div class="row mb-5">
        <div class="col-12 text-center search-wrapper">
            <h3 class="fw-bold mb-2" style="color: #1e293b;">Temukan Buku Favoritmu</h3>
            <p class="text-muted small mb-4">Cari buku dari koleksi perpustakaan lokal atau database Google Books API.</p>

            <form action="" method="GET" class="d-flex align-items-center bento-search-box shadow-sm">
                <input type="text" name="q" value="<?= esc($keyword ?? '') ?>"
                    class="form-control border-0 bg-transparent shadow-none ps-3 text-secondary"
                    placeholder="Masukkan judul buku, penulis, atau ISBN...">
                <button class="btn btn-bento-primary px-4 py-2 flex-shrink-0" type="submit">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12 max-w-4xl mx-auto">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 14px; background-color: #ecfdf5; color: #065f46;">
                    <span class="me-2">🎉</span> <?= session()->getFlashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 14px; background-color: #fff5f5; color: #9b1c1c;">
                    <span class="me-2">⚠️</span> <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <h5 class="fw-bold text-dark mb-1">Koleksi Perpustakaan</h5>
            <p class="text-muted small mb-3">Buku fisik yang tersedia untuk dipinjam langsung.</p>
        </div>
    </div>

    <?php if (empty($local_books)): ?>
        <div class="row mb-5">
            <div class="col-12 text-center py-5 border rounded-3 bg-white border-dashed max-w-4xl mx-auto" style="border-style: dashed !important; border-radius: 16px !important; border-color: #e2e8f0 !important;">
                <span style="font-size: 2.5rem;">📚</span>
                <h5 class="text-secondary fw-semibold mt-3">Buku Tidak Ditemukan</h5>
                <p class="text-muted small mb-0">Koleksi internal perpustakaan untuk kata kunci ini belum tersedia.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="bento-grid mb-5">
            <?php foreach ($local_books as $book): ?>
                <div class="book-bento-card">
                    <div class="cover-container">
                        <?php if (!empty($book['cover_image']) && file_exists(FCPATH . 'uploads/covers/' . $book['cover_image'])): ?>
                            <img src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>" class="cover-img" alt="Cover">
                        <?php else: ?>
                            <div class="absolute-center d-flex flex-column align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 text-muted bg-light">
                                <span class="fs-2 mb-1">📘</span>
                                <span class="text-uppercase tracking-wider font-weight-bold text-muted" style="font-size: 10px; opacity: 0.6;">No Cover</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-content">
                        <div>
                            <div class="mb-2">
                                <?php if ($book['stock'] > 0): ?>
                                    <span class="badge bg-opacity-10 text-success" style="background-color: #e6f4ea; color: #137333; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                        Tersedia (<?= $book['stock'] ?>)
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-opacity-10 text-danger" style="background-color: #fce8e6; color: #c5221f; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                        Habis
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="text-clamp-title" title="<?= esc($book['title']) ?>">
                                <?= esc($book['title']) ?>
                            </div>
                            <div class="text-clamp-author">
                                <?= esc($book['author']) ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <form action="/member/loans/borrow/<?= $book['id']; ?>" method="POST" class="w-full d-grid">
                                <?= csrf_field(); ?>
                                <button type="submit"
                                    class="btn btn-bento-primary shadow-sm"
                                    <?= ($book['stock'] <= 0) ? 'disabled style="background-color: #e2e8f0; color: #94a3b8; cursor: not-allowed;"' : '' ?>>
                                    <?= ($book['stock'] > 0) ? '⚡ Pinjam Buku' : 'Stok Habis' ?>
                                </button>
                            </form>

                            <a href="/admin/books/show/<?= $book['id']; ?>" class="btn-bento-secondary">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($api_books)): ?>
        <hr class="my-5" style="border-color: #e2e8f0;">

        <div class="row mb-3">
            <div class="col-12">
                <h5 class="fw-bold text-dark mb-1">Rekomendasi Global (Google Books API)</h5>
                <p class="text-muted small mb-3">Referensi pustaka internasional yang diakses secara realtime via Webservice.</p>
            </div>
        </div>

        <div class="bento-grid">
            <?php foreach ($api_books as $apiBook): ?>
                <div class="book-bento-card">
                    <div class="cover-container">
                        <?php if (!empty($apiBook['cover_image'])): ?>
                            <img src="<?= $apiBook['cover_image'] ?>" class="cover-img" alt="Cover" referrerpolicy="no-referrer">
                        <?php else: ?>
                            <div class="absolute-center d-flex flex-column align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 text-muted bg-light">
                                <span class="fs-2 mb-1">📘</span>
                                <span class="text-uppercase tracking-wider font-weight-bold text-muted" style="font-size: 10px; opacity: 0.6;">No Cover</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-content">
                        <div>
                            <div class="mb-2">
                                <span class="badge" style="background-color: #e0f2fe; color: #0369a1; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                    🌐 Digital Book
                                </span>
                            </div>

                            <div class="text-clamp-title" title="<?= esc($apiBook['title']) ?>">
                                <?= esc($apiBook['title']) ?>
                            </div>
                            <div class="text-clamp-author">
                                <?= esc($apiBook['author']) ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-sm btn-outline-secondary" style="border-radius: 10px; cursor: not-allowed;" disabled>
                                Hanya Baca di Tempat
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>