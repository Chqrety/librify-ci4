<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends BaseController
{
    public function __construct()
    {
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

    public function index()
    {
        //
    }

    public function payFine($loan_id)
    {
        // Simulasi tagihan denda keterlambatan (Misal: Rp 25.000)
        $dendaAmount = 25000;

        // Detail pesanan yang dikirim ke Midtrans
        $transaction_details = [
            'order_id' => 'DENDA-LIBRIFY-' . time() . '-' . $loan_id,
            'gross_amount' => $dendaAmount, // total tagihan
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
        // 1. (Simulasi) Update status peminjaman di database menjadi lunas
        // $this->loanModel->update($loan_id, ['denda_status' => 'lunas']);

        // 2. Persiapkan Email Notifikasi
        $email = \Config\Services::email();
        $userEmail = session()->get('email'); // Mengambil email member yang sedang login
        $userName = session()->get('name');

        $email->setFrom('no-reply@librify.com', 'Admin Librify');
        $email->setTo($userEmail);
        $email->setSubject('Setruk Pembayaran Denda - Librify');

        // Isi Email dalam format HTML agar cantik
        $pesanHTML = "
            <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #F1F5F9; border-radius: 10px;'>
                <h2 style='color: #10B981;'>Pembayaran Berhasil! 🎉</h2>
                <p>Halo <b>{$userName}</b>,</p>
                <p>Terima kasih, pembayaran denda keterlambatan untuk ID Peminjaman <b>#{$loan_id}</b> telah kami terima.</p>
                <div style='background-color: #FFFFFF; padding: 15px; border-radius: 8px; border: 1px solid #E2E8F0;'>
                    <p><b>Rincian:</b></p>
                    <ul>
                        <li>ID Transaksi: DENDA-{$loan_id}</li>
                        <li>Status: <b>LUNAS</b></li>
                        <li>Waktu: " . date('d M Y H:i:s') . "</li>
                    </ul>
                </div>
                <p>Sekarang kamu sudah bisa meminjam buku kembali di perpustakaan Librify. Selamat membaca!</p>
            </div>
        ";

        $email->setMessage($pesanHTML);

        // 3. Kirim Email dan cek statusnya
        if ($email->send()) {
            $statusEmail = "Setruk bukti pembayaran telah dikirim ke email kamu.";
        } else {
            // Jika gagal kirim email (misal salah password SMTP)
            $statusEmail = "Pembayaran sukses, tapi gagal mengirim email notifikasi. Cek pengaturan SMTP.";
            // echo $email->printDebugger(['headers']); // Buka komen ini jika ingin melihat error detail
        }

        $data = [
            'title' => 'Pembayaran Berhasil',
            'loan_id' => $loan_id,
            'statusEmail' => $statusEmail
        ];

        return view('member/payment/success', $data);
    }
}
