<?php
// index.php - Homepage
require_once 'config.php';

// Fetch all available cars
$stmt = $pdo->query("SELECT * FROM mobil ORDER BY id_mobil");
$cars = $stmt->fetchAll();
// Peta gambar berdasarkan id_mobil
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Mobil - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<style>
    /* ===== NAVBAR ===== */
    .navbar {
        background-color: #222;
        color: white;
        padding: 1rem 0;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }

    .navbar-container {
        width: 100%;
        margin: auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
        color: white;
        text-decoration: none;
    }

    .navbar-brand .highlight {
        color: #0d6efd;
    }

    .navbar-menu {
        list-style: none;
        display: flex;
        gap: 5px; /* ⬅️ Jarak antar item menu */
        margin: 0;
        padding: 8px 15px;
    }

    .navbar-menu li a {
        color: white;
        text-decoration: none;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .navbar-menu li a:hover {
        background: linear-gradient(to right, #5a8dee, #8e44ad);
        color: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* ===== GLOBAL ===== */
    body {
        padding-top: 100px; /* Memberi ruang untuk navbar */
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .header {
        padding-top: 100px;
    }
</style>

<nav class="navbar">
    <div class="navbar-container">
        <a class="navbar-brand" href="#"><span class="highlight">RENTAL</span> MOBIL KAK VELLL</a>
        <ul class="navbar-menu" id="navbarMenu">
            <li><a href="index.php">Home</a></li>
            <li><a href="tentang.php">About us</a></li>
            <li><a href="hubungi.php" target="_blank">Contac us</a></li>
        </ul>
    </div>
</nav>

</div>
    <div class="container">
        <?php if (empty($cars)): ?>
            <div class="alert alert-info">
                <strong>Info:</strong> Belum ada data mobil tersedia.
            </div>
        <?php else: ?>
            <div class="car-grid">
                <?php foreach ($cars as $car): ?>
                    <div class="car-card">
                        <div class="car-image">
                            <?php
                                $imageFile = $imageMap[$car['id_mobil']] ?? null;
                                if ($imageFile && file_exists("images/$imageFile")):
                            ?>
                                <img src="images/<?= htmlspecialchars($imageFile) ?>" alt="Gambar Mobil">

                            <?php else: ?>
                                <span style="font-size: 48px;">🚙</span>
                            <?php endif; ?>
                        </div>
                        <div class="car-info">
                            <div class="car-title"><?= htmlspecialchars($car['merek'] . ' ' . $car['tipe']) ?></div>
                            <div class="car-details">
                                Tahun: <?= htmlspecialchars($car['tahun']) ?><br>
                                Plat: <?= htmlspecialchars($car['plat_nomor']) ?><br>
                                Status: <span class="status-badge status-<?= $car['status'] ?? 'tidak-diketahui' ?>">
                                    <?= ucfirst($car['status'] ?? 'Tekan Lihat Detail untuk cek') ?>
                                </span>
                            </div>
                            <div class="car-price">
                                Rp <?= number_format($car['harga_per_hari'], 0, ',', '.') ?>/hari
                            </div>
                            <a href="detail.php?id=<?= $car['id_mobil'] ?>" class="btn">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Interaktif kartu mobil
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.car-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>
