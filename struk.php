<?php
// struk.php - Receipt Page
require_once 'config.php';
session_start();

if (!isset($_SESSION['transaction_id'])) {
    header('Location: index.php');
    exit;
}

$transaction_id = $_SESSION['transaction_id'];

// Fetch transaction details using view
$stmt = $pdo->prepare("SELECT * FROM view_transaksi_detail WHERE id_transaksi = ?");
$stmt->execute([$transaction_id]);
$transaction = $stmt->fetch();

if (!$transaction) {
    header('Location: index.php');
    exit;
}

// Calculate duration
$sewa_date = new DateTime($transaction['tanggal_sewa']);
$kembali_date = new DateTime($transaction['tanggal_kembali']);
$days = max(1, $sewa_date->diff($kembali_date)->days);

// Get pelanggan details
$stmt = $pdo->prepare("
    SELECT p.* FROM pelanggan p 
    JOIN transaksi t ON p.id_pelanggan = t.id_pelanggan 
    WHERE t.id_transaksi = ?
");
$stmt->execute([$transaction_id]);
$pelanggan = $stmt->fetch();

// Clear session
unset($_SESSION['transaction_id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #<?= $transaction_id ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        @media print {
            body { background: white !important; }
            .header, .action-buttons { display: none !important; }
            .receipt { box-shadow: none !important; margin: 0 !important; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🧾 STRUK TRANSAKSI</h1>
    </div>

    <div class="container">
        <div class="receipt">
            <div class="receipt-header">
                <div class="receipt-title">RENTAL MOBIL TERPERCAYA</div>
                <div class="receipt-number">Transaksi #<?= str_pad($transaction_id, 6, '0', STR_PAD_LEFT) ?></div>
                <div style="color: #666; font-size: 0.9rem; margin-top: 0.5rem;">
                    Tanggal: <?= date('d/m/Y H:i:s') ?>
                </div>
            </div>

            <div class="receipt-content">
                <!-- Customer Information -->
                <div class="receipt-section">
                    <div class="section-title">👤 Data Pelanggan</div>
                    <div class="receipt-row">
                        <span class="receipt-label">Nama:</span>
                        <span class="receipt-value"><?= htmlspecialchars($pelanggan['nama']) ?></span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">No. KTP:</span>
                        <span class="receipt-value"><?= htmlspecialchars($pelanggan['no_ktp']) ?></span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">No. Telepon:</span>
                        <span class="receipt-value"><?= htmlspecialchars($pelanggan['no_telp']) ?></span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">Alamat:</span>
                        <span class="receipt-value"><?= htmlspecialchars($pelanggan['alamat']) ?></span>
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="receipt-section">
                    <div class="section-title">🚗 Informasi Kendaraan</div>
                    <div class="receipt-row">
                        <span class="receipt-label">Mobil:</span>
                        <span class="receipt-value"><?= htmlspecialchars($transaction['merek'] . ' ' . $transaction['tipe']) ?></span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">Plat Nomor:</span>
                        <span class="receipt-value"><?= htmlspecialchars($transaction['plat_nomor']) ?></span>
                    </div>
                </div>

                <!-- Rental Information -->
                <div class="receipt-section">
                    <div class="section-title">📅 Detail Rental</div>
                    <div class="receipt-row">
                        <span class="receipt-label">Tanggal Sewa:</span>
                        <span class="receipt-value"><?= date('d/m/Y', strtotime($transaction['tanggal_sewa'])) ?></span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">Tanggal Kembali:</span>
                        <span class="receipt-value"><?= date('d/m/Y', strtotime($transaction['tanggal_kembali'])) ?></span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">Durasi:</span>
                        <span class="receipt-value"><?= $days ?> hari</span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">Status:</span>
                        <span class="receipt-value">
                            <span class="status-badge status-<?= $transaction['status'] == 'berlangsung' ? 'disewa' : 'tersedia' ?>">
                                <?= ucfirst($transaction['status']) ?>
                            </span>
                        </span>
                    </div>
                </div>

                <!-- Staff Information -->
                <div class="receipt-section">
                    <div class="section-title">👨‍💼 Petugas</div>
                    <div class="receipt-row">
                        <span class="receipt-label">Nama Petugas:</span>
                        <span class="receipt-value"><?= htmlspecialchars($transaction['nama_karyawan']) ?></span>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="receipt-section">
                    <div class="section-title">💰 Rincian Pembayaran</div>
                    <div class="receipt-row">
                        <span class="receipt-label">Harga per Hari:</span>
                        <span class="receipt-value">Rp <?= number_format($transaction['total_bayar'] / $days, 0, ',', '.') ?></span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">Durasi:</span>
                        <span class="receipt-value"><?= $days ?> hari</span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">Subtotal:</span>
                        <span class="receipt-value">Rp <?= number_format($transaction['total_bayar'], 0, ',', '.') ?></span>
                    </div>
                </div>

                <!-- Total -->
                <div class="total-section">
                    <div class="receipt-row" style="font-size: 1.2rem;">
                        <span class="receipt-label"><strong>TOTAL PEMBAYARAN:</strong></span>
                        <span class="receipt-value total-amount">
                            Rp <?= number_format($transaction['total_bayar'], 0, ',', '.') ?>
                        </span>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="receipt-section" style="border: none; font-size: 0.8rem; color: #666; text-align: center;">
                    <div style="margin-bottom: 1rem;">
                        <strong>SYARAT DAN KETENTUAN:</strong><br>
                        1. Kendaraan harus dikembalikan sesuai jadwal yang telah ditentukan<br>
                        2. Keterlambatan pengembalian dikenakan denda 10% per hari<br>
                        3. Kerusakan kendaraan menjadi tanggung jawab penyewa<br>
                        4. SIM dan KTP asli wajib diserahkan sebagai jaminan<br>
                        5. Struk ini merupakan bukti sah transaksi rental
                    </div>
                    <div style="border-top: 1px dashed #ccc; padding-top: 1rem;">
                        <strong>Terima kasih atas kepercayaan Anda!</strong><br>
                        Rental Mobil Terpercaya - Melayani dengan sepenuh hati
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <button onclick="window.print()" class="btn btn-secondary">🖨️ Cetak Struk</button>
            <a href="index.php" class="btn">🏠 Kembali ke Beranda</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus for print functionality
            window.focus();
            
            // Add animation effect
            const receipt = document.querySelector('.receipt');
            receipt.style.opacity = '0';
            receipt.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                receipt.style.transition = 'all 0.6s ease';
                receipt.style.opacity = '1';
                receipt.style.transform = 'translateY(0)';
            }, 100);
            
            // Show success message
            setTimeout(() => {
                const successMsg = document.createElement('div');
                successMsg.className = 'alert alert-success';
                successMsg.innerHTML = '✅ <strong>Transaksi Berhasil!</strong> Silakan simpan atau cetak struk ini sebagai bukti transaksi.';
                successMsg.style.animation = 'fadeIn 0.5s ease';
                
                const container = document.querySelector('.container');
                container.insertBefore(successMsg, container.firstChild);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    successMsg.style.animation = 'fadeOut 0.5s ease';
                    setTimeout(() => successMsg.remove(), 500);
                }, 5000);
            }, 1000);
        });
        
        // Add CSS animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeOut {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(-10px); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>