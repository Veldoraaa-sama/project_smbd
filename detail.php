<?php
// detail.php - Car Detail Page
require_once 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$car_id = $_GET['id'];

// Fetch car details
$stmt = $pdo->prepare("SELECT * FROM mobil WHERE id_mobil = ?");
$stmt->execute([$car_id]);
$car = $stmt->fetch();

if (!$car) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

// Handle form submission
if ($_POST) {
    $nama = trim($_POST['nama'] ?? '');
    $no_ktp = trim($_POST['no_ktp'] ?? '');
    $no_telp = trim($_POST['no_telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $tanggal_sewa = $_POST['tanggal_sewa'] ?? '';
    $tanggal_kembali = $_POST['tanggal_kembali'] ?? '';
    
    // Validation
    if (empty($nama) || empty($no_ktp) || empty($no_telp) || empty($alamat) || empty($tanggal_sewa) || empty($tanggal_kembali)) {
        $error = 'Semua field harus diisi!';
    } elseif (strtotime($tanggal_sewa) >= strtotime($tanggal_kembali)) {
        $error = 'Tanggal kembali harus setelah tanggal sewa!';
    } elseif (strtotime($tanggal_sewa) < strtotime('today')) {
        $error = 'Tanggal sewa tidak boleh sebelum hari ini!';
    } else {
        // Store data in session and redirect to transaction page
        session_start();
        $_SESSION['booking_data'] = [
            'id_mobil' => $car_id,
            'nama' => $nama,
            'no_ktp' => $no_ktp,
            'no_telp' => $no_telp,
            'alamat' => $alamat,
            'tanggal_sewa' => $tanggal_sewa,
            'tanggal_kembali' => $tanggal_kembali,
            'harga_per_hari' => $car['harga_per_hari']
        ];
        
        header('Location: transaksi.php');
        exit;
    }
}
$imageMap = [
    1 => 'avanza.jpg',
    2 => 'jazz.jpg',
    3 => 'ertiga.jpg',
    4 => 'xenia.jpg',
    5 => 'pajero.jpg',
    6 => 'inova.jpg',
    7 => 'brioo.jpg',
    8 => 'march.jpg',
    9 => 'fortuner.jpg',
    10 => 'swift.jpg',
    11 => 'xpander.jpg',
    12 => 'yaris.jpg'
];
$imageFile = $imageMap[$car_id] ?? null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mobil - <?= htmlspecialchars($car['merek'] . ' ' . $car['tipe']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>DETAIL MOBIL</h1>
    </div>

    <div class="container">
        <div class="detail-container">
            <div class="detail-grid">
                <div class="detail-image">
                    <?php if ($imageFile && file_exists("images/$imageFile")): ?>
                        <img src="images/<?= htmlspecialchars($imageFile) ?>" alt="Gambar Mobil">
                    <?php else: ?>
                        <span style="font-size: 48px;">🚙</span>
                    <?php endif; ?>
                </div>
                <div class="detail-info">
                    <h2><?= htmlspecialchars($car['merek'] . ' ' . $car['tipe']) ?></h2>
                    
                    <div class="info-item">
                        <span class="info-label">Merek:</span>
                        <span class="info-value"><?= htmlspecialchars($car['merek']) ?></span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Tipe:</span>
                        <span class="info-value"><?= htmlspecialchars($car['tipe']) ?></span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Tahun:</span>
                        <span class="info-value"><?= htmlspecialchars($car['tahun']) ?></span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Plat Nomor:</span>
                        <span class="info-value"><?= htmlspecialchars($car['plat_nomor']) ?></span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Status:</span>
                        <span class="info-value">
                        <?php
                        $status = $car['status'] ?? 'tidak-diketahui';
                        ?>
                        <span class="status-badge status-<?= htmlspecialchars($status) ?>">
                         <?= ucfirst(htmlspecialchars($status)) ?>
                        </span>
                    </div>  
                    
                    <div class="info-item">
                        <span class="info-label">Harga per Hari:</span>
                        <span class="info-value" style="color: #e74c3c; font-weight: bold; font-size: 1.2rem;">
                            Rp <?= number_format($car['harga_per_hari'], 0, ',', '.') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

       <?php if ($car['status'] === 'tersedia'): ?>

            <div class="form-container">
                <h3 style="margin-bottom: 1.5rem; color: #333;">Form Pemesanan</h3>
                
                <?php if ($error): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap:</label>
                        <input type="text" id="nama" name="nama" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="no_ktp">Nomor KTP:</label>
                        <input type="text" id="no_ktp" name="no_ktp" required value="<?= htmlspecialchars($_POST['no_ktp'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="no_telp">Nomor Telepon:</label>
                        <input type="text" id="no_telp" name="no_telp" required value="<?= htmlspecialchars($_POST['no_telp'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat">Alamat:</label>
                        <textarea id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_sewa">Tanggal Sewa:</label>
                        <input type="date" id="tanggal_sewa" name="tanggal_sewa" required 
                               min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($_POST['tanggal_sewa'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_kembali">Tanggal Kembali:</label>
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali" required 
                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>" value="<?= htmlspecialchars($_POST['tanggal_kembali'] ?? '') ?>">
                    </div>
                    
                    <div class="action-buttons">
                        <a href="index.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn">Lanjut ke Transaksi</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-error">
                <strong>Maaf!</strong> Mobil ini sedang tidak tersedia untuk disewa.
            </div>
            <div class="action-buttons">
                <a href="index.php" class="btn">Kembali ke Beranda</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalSewa = document.getElementById('tanggal_sewa');
            const tanggalKembali = document.getElementById('tanggal_kembali');
            
            tanggalSewa.addEventListener('change', function() {
                if (this.value) {
                    const minKembali = new Date(this.value);
                    minKembali.setDate(minKembali.getDate() + 1);
                    tanggalKembali.min = minKembali.toISOString().split('T')[0];
                    
                    if (tanggalKembali.value && tanggalKembali.value <= this.value) {
                        tanggalKembali.value = '';
                    }
                }
            });
            
            // Real-time price calculation preview
            function updatePricePreview() {
                if (tanggalSewa.value && tanggalKembali.value) {
                    const sewa = new Date(tanggalSewa.value);
                    const kembali = new Date(tanggalKembali.value);
                    const diffTime = Math.abs(kembali - sewa);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    const hargaPerHari = <?= $car['harga_per_hari'] ?>;
                    const total = diffDays * hargaPerHari;
                    
                    let previewElement = document.getElementById('price-preview');
                    if (!previewElement) {
                        previewElement = document.createElement('div');
                        previewElement.id = 'price-preview';
                        previewElement.className = 'alert alert-info';
                        previewElement.style.marginTop = '1rem';
                        tanggalKembali.parentNode.appendChild(previewElement);
                    }
                    
                    previewElement.innerHTML = `
                        <strong>Estimasi Biaya:</strong><br>
                        ${diffDays} hari × Rp ${new Intl.NumberFormat('id-ID').format(hargaPerHari)} = 
                        <span style="font-size: 1.2rem; color: #e74c3c; font-weight: bold;">
                            Rp ${new Intl.NumberFormat('id-ID').format(total)}
                        </span>
                    `;
                }
            }
            
            tanggalSewa.addEventListener('change', updatePricePreview);
            tanggalKembali.addEventListener('change', updatePricePreview);
        });
    </script>
</body>
</html>