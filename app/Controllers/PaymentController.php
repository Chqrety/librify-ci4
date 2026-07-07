<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LoanModel; // WAJIB DI-USE
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends BaseController
{
    protected $loanModel;

    public function __construct()
    {
        // Inisialisasi LoanModel
        $this->loanModel = new LoanModel();

        // Set konfigurasi Midtrans
        Config::$serverKey = getenv('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
        Config::$curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => []
        ];
    }

    public function payFine($loan_id)
    {
        // 1. Ambil data denda asli milik member dari database
        $loan = $this->loanModel->find($loan_id);

        if (!$loan) {
            return redirect()->to('/member/loans')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        // Ambil nominal denda asli dari kolom database kamu
        $dendaAmount = (int) $loan['fine_amount'];

        if ($dendaAmount <= 0 || $loan['payment_status'] === 'paid') {
            return redirect()->to('/member/loans')->with('error', 'Tagihan denda tidak valid atau sudah lunas.');
        }

        // Detail pesanan yang dikirim ke Midtrans
        $transaction_details = [
            'order_id' => 'DENDA-LIBRIFY-' . time() . '-' . $loan_id,
            'gross_amount' => $dendaAmount, // Menggunakan total tagihan asli dari DB
        ];

        // Detail pelanggan (diambil dari session)
        $customer_details = [
            'first_name' => session()->get('name'),
            'email' => session()->get('email'),
        ];

        // Gabungkan data
        $transaction = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        try {
            // Minta Snap Token ke server Midtrans
            $snapToken = Snap::getSnapToken($transaction);

            // Simpan token ke database agar jika halaman di-refresh, token tidak hangus
            $this->loanModel->update($loan_id, ['payment_token' => $snapToken]);

            $data = [
                'title' => 'Bayar Denda Keterlambatan',
                'snapToken' => $snapToken,
                'clientKey' => getenv('MIDTRANS_CLIENT_KEY'),
                'dendaAmount' => $dendaAmount,
                'loan_id' => $loan_id
            ];

            return view('member/payment/pay', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function success($loan_id)
    {
        // 1. UPDATE DATA NYATA: Ubah payment_status di database kamu menjadi 'paid'
        // Kita juga set return_date ke tanggal hari ini sebagai tanda buku fisik sudah selesai disirkulasikan
        $this->loanModel->update($loan_id, [
            'payment_status' => 'paid',
            'return_date' => date('Y-m-d')
        ]);

        // 2. Persiapkan Email Notifikasi
        $email = \Config\Services::email();
        $userEmail = session()->get('email');
        $userName = session()->get('name');

        $email->setFrom('no-reply@librify.com', 'Admin Librify');
        $email->setTo($userEmail);
        $email->setSubject('Setruk Pembayaran Denda - Librify');

        // Isi Email dalam format HTML agar cantik
        $pesanHTML = "
            <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #F1F5F9; border-radius: 10px;'>
                <h2 style='color: #10B981;'>Pembayaran Berhasil! 🎉</h2>
                <p>Halo <b>{$userName}</b>,</p>
                <p>Terima kasih, pembayaran denda keterlambatan untuk ID Peminjaman <b>#{$loan_id}</b> telah kami terima dan dinyatakan lunas.</p>
                <div style='background-color: #FFFFFF; padding: 15px; border-radius: 8px; border: 1px solid #E2E8F0;'>
                    <p><b>Rincian:</b></p>
                    <ul>
                        <li>ID Transaksi: DENDA-{$loan_id}</li>
                        <li>Status Keuangan: <b>LUNAS (PAID)</b></li>
                        <li>Status Buku: <b>SUDAH DIKEMBALIKAN</b></li>
                        <li>Waktu Lunas: " . date('d M Y H:i:s') . "</li>
                    </ul>
                </div>
                <p>Sekarang kamu sudah memiliki reputasi bersih dan bisa meminjam buku kembali di perpustakaan Librify. Selamat membaca!</p>
            </div>
        ";

        $email->setMessage($pesanHTML);

        // 3. Kirim Email dan cek statusnya
        if ($email->send()) {
            $statusEmail = "Setruk bukti pembayaran telah dikirim ke email kamu.";
        } else {
            $statusEmail = "Pembayaran sukses tercatat di database, tetapi gagal mengirim email notifikasi. Cek pengaturan SMTP.";
        }

        $data = [
            'title' => 'Pembayaran Berhasil',
            'loan_id' => $loan_id,
            'statusEmail' => $statusEmail
        ];

        return view('member/payment/success', $data);
    }
}