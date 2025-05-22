<?php
// transaksi.php - Transaction Page with CRUD functionality
require_once 'config.php';
session_start();

if (!isset($_SESSION['booking_data'])) {
    header('Location: index.php');
    exit;
}

$booking_data = $_SESSION['booking_data'];
$error = '';
$success = '';

// Fetch car details
$stmt = $pdo->prepare("SELECT * FROM mobil WHERE id_mobil = ?");
$stmt->execute([$booking_data['id_mobil']]);
$car = $stmt->fetch();

// Calculate total using stored procedure
function calculateTotal($pdo, $tanggal_sewa, $tanggal_kembali, $harga_per_hari) {
    try {
        $stmt = $pdo->prepare("CALL HitungTotalSewa(?, ?, ?, @total)");
        $stmt->execute([$tanggal_sewa, $tanggal_kembali, $harga_per_hari]);
        
        $result = $pdo->query("SELECT @total as total")->fetch();
        return $result['total'];
    } catch (Exception $e) {
        // Fallback calculation
        $sewa = new DateTime($tanggal_sewa);
        $kembali = new DateTime($tanggal_kembali);
        $diff = $sewa->diff($kembali);
        $days = max(1, $diff->days);
        return $days * $harga_per_hari;
    }
}

// Handle form updates
if ($_POST && isset($_POST['action'])) {
    if ($_POST['action'] == 'update') {
        $booking_data['nama'] = trim($_POST['nama'] ?? '');
        $booking_data['no_ktp'] = trim($_POST['no_ktp'] ?? '');
        $booking_data['no_telp'] = trim($_POST['no_telp'] ?? '');
        $booking_data['alamat'] = trim($_POST['alamat'] ?? '');
        $booking_data['tanggal_sewa'] = $_POST['tanggal_sewa'] ?? '';
        $booking_data['tanggal_kembali'] = $_POST['tanggal_kembali'] ?? '';
        
        // Validation
        if (empty($booking_data['nama']) || empty($booking_data['no_ktp']) || empty($booking_data['no_telp']) || 
            empty($booking_data['alamat']) || empty($booking_data['tanggal_sewa']) || empty($booking_data['tanggal_kembali'])) {
            $error = 'Semua field harus diisi!';
        } elseif (strtotime($booking_data['tanggal_sewa']) >= strtotime($booking_data['tanggal_kembali'])) {
            $error = 'Tanggal kembali harus setelah tanggal sewa!';
        } elseif (strtotime($booking_data['tanggal_sewa']) < strtotime('today')) {
            $error = 'Tanggal sewa tidak boleh sebelum hari ini!';
        } else {
            $_SESSION['booking_data'] = $booking_data;
            $success = 'Data berhasil diupdate!';
        }
    } elseif ($_POST['action'] == 'confirm') {
        // Process the transaction
        try {
            $pdo->beginTransaction();
            
            // Insert or update pelanggan
            $stmt = $pdo->prepare("INSERT INTO pelanggan (nama, no_ktp, no_telp, alamat) VALUES (?, ?, ?, ?) 
                                   ON DUPLICATE KEY UPDATE nama = VALUES(nama), no_telp = VALUES(no_telp), alamat = VALUES(alamat)");
            $stmt->execute([$booking_data['nama'], $booking_data['no_ktp'], $booking_data['no_telp'], $booking_data['alamat']]);
            
            // Get pelanggan ID
            $stmt = $pdo->prepare("SELECT id_pelanggan FROM pelanggan WHERE no_ktp = ?");
            $stmt->execute([$booking_data['no_ktp']]);
            $pelanggan = $stmt->fetch();
            
            // Get default karyawan (admin)
            $stmt = $pdo->query("SELECT id_karyawan FROM karyawan WHERE posisi = 'Admin' LIMIT 1");
            $karyawan = $stmt->fetch();
            
            // Calculate total
            $total = calculateTotal($pdo, $booking_data['tanggal_sewa'], $booking_data['tanggal_kembali'], $booking_data['harga_per_hari']);
            
            // Insert transaksi
            $stmt = $pdo->prepare("INSERT INTO transaksi (id_mobil, id_pelanggan, id_karyawan, tanggal_sewa, tanggal_kembali, total_bayar) 
                                   VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $booking_data['id_mobil'],
                $pelanggan['id_pelanggan'],
                $karyawan['id_karyawan'],
                $booking_data['tanggal_sewa'],
                $booking_data['tanggal_kembali'],
                $total
            ]);
            
            $transaction_id = $pdo->lastInsertId();
            
            $pdo->commit();
            
            // Store transaction ID in session and redirect to receipt
            $_SESSION['transaction_id'] = $transaction_id;
            unset($_SESSION['booking_data']);
            header('Location: struk.php');
            exit;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }
}

$total_bayar = calculateTotal($pdo, $booking_data['tanggal_sewa'], $booking_data['tanggal_kembali'], $booking_data['harga_per_hari']);
$sewa_date = new DateTime($booking_data['tanggal_sewa']);
$kembali_date = new DateTime($booking_data['tanggal_kembali']);
$days = max(1, $sewa_date->diff($kembali_date)->days);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>🧾 KONFIRMASI TRANSAKSI</h1>
    </div>

    <div class="container">
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="form-container">
            <h3 style="margin-bottom: 1.5rem; color: #333;">Detail Transaksi</h3>
            
            <!-- Car Information -->
            <div class="receipt-section">
                <div class="section-title">📋 Informasi Mobil</div>
                <div class="receipt-row">
                    <span class="receipt-label">Mobil:</span>
                    <span class="receipt-value"><?= htmlspecialchars($car['merek'] . ' ' . $car['tipe']) ?></span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Plat Nomor:</span>
                    <span class="receipt-value"><?= htmlspecialchars($car['plat_nomor']) ?></span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Harga per Hari:</span>
                    <span class="receipt-value">Rp <?= number_format($car['harga_per_hari'], 0, ',', '.') ?></span>
                </div>
            </div>

            <form method="POST" id="transactionForm">
                <input type="hidden" name="action" value="update">
                
                <div class="receipt-section">
                    <div class="section-title">👤 Data Pelanggan</div>
                    
                    <div class="form-group">
                        <label for="nama">Nama Lengkap:</label>
                        <input type="text" id="nama" name="nama" required value="<?= htmlspecialchars($booking_data['nama']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="no_ktp">Nomor KTP:</label>
                        <input type="text" id="no_ktp" name="no_ktp" required value="<?= htmlspecialchars($booking_data['no_ktp']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="no_telp">Nomor Telepon:</label>
                        <input type="text" id="no_telp" name="no_telp" required value="<?= htmlspecialchars($booking_data['no_telp']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat">Alamat:</label>
                        <textarea id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($booking_data['alamat']) ?></textarea>
                    </div>
                </div>

                <div class="receipt-section">
                    <div class="section-title">📅 Jadwal Rental</div>
                    
                    <div class="form-group">
                        <label for="tanggal_sewa">Tanggal Sewa:</label>
                        <input type="date" id="tanggal_sewa" name="tanggal_sewa" required 
                               min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($booking_data['tanggal_sewa']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_kembali">Tanggal Kembali:</label>
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali" required 
                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>" value="<?= htmlspecialchars($booking_data['tanggal_kembali']) ?>">
                    </div>
                </div>

                <div class="total-section">
                    <div class="receipt-row">
                        <span class="receipt-label">Durasi Sewa:</span>
                        <span class="receipt-value" id="duration"><?= $days ?> hari</span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">Harga per Hari:</span>
                        <span class="receipt-value">Rp <?= number_format($car['harga_per_hari'], 0, ',', '.') ?></span>
                    </div>
                    <div class="receipt-row">
                        <span class="receipt-label">Total Bayar:</span>
                        <span class="receipt-value total-amount" id="total">Rp <?= number_format($total_bayar, 0, ',', '.') ?></span>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="detail.php?id=<?= $booking_data['id_mobil'] ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Update Data</button>
                    <button type="button" onclick="confirmTransaction()" class="btn">Konfirmasi Transaksi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalSewa = document.getElementById('tanggal_sewa');
            const tanggalKembali = document.getElementById('tanggal_kembali');
            const durationElement = document.getElementById('duration');
            const totalElement = document.getElementById('total');
            const hargaPerHari = <?= $car['harga_per_hari'] ?>;
            
            function updateCalculation() {
                if (tanggalSewa.value && tanggalKembali.value) {
                    const sewa = new Date(tanggalSewa.value);
                    const kembali = new Date(tanggalKembali.value);
                    const diffTime = Math.abs(kembali - sewa);
                    const diffDays = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
                    const total = diffDays * hargaPerHari;
                    
                    durationElement.textContent = diffDays + ' hari';
                    totalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                }
            }
            
            tanggalSewa.addEventListener('change', function() {
                if (this.value) {
                    const minKembali = new Date(this.value);
                    minKembali.setDate(minKembali.getDate() + 1);
                    tanggalKembali.min = minKembali.toISOString().split('T')[0];
                    
                    if (tanggalKembali.value && tanggalKembali.value <= this.value) {
                        tanggalKembali.value = '';
                    }
                }
                updateCalculation();
            });
            
            tanggalKembali.addEventListener('change', updateCalculation);
        });
        
        function confirmTransaction() {
            if (confirm('Apakah Anda yakin ingin mengkonfirmasi transaksi ini?')) {
                const form = document.getElementById('transactionForm');
                const actionInput = form.querySelector('input[name="action"]');
                actionInput.value = 'confirm';
                form.submit();
            }
        }
    </script>
</body>
</html>