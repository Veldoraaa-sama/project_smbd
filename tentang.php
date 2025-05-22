<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Rental Mobil Kak Velll</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* ====== GLOBAL ====== */
        body {
            margin: 0;
            padding-top: 100px; /* agar tidak tertimpa navbar */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #6a89cc, #8e44ad);
            color: #333;
        }

        /* ====== NAVBAR ====== */
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
            padding: 0 40px;
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

        /* ====== TENTANG KAMI SECTION ====== */
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1.2s ease-in-out;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .form-container p {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 768px) {
            .navbar-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar-menu {
                flex-direction: column;
                gap: 10px;
                margin-top: 10px;
            }

            .container {
                margin: 100px 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- ====== NAVBAR ====== -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="index.php">
                <span class="highlight">RENTAL</span> MOBIL KAK VELLL
            </a>
            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="index.php">Home</a></li>
                <li><a href="tentang.php">About us</a></li>
                <li><a href="hubungi.php" target="_blank">Contact us</a></li>
            </ul>
        </div>
    </nav>
    <!-- ====== TENTANG KAMI ====== -->
<section class="container">
    <h1 class="header-title">About Us</h1>
    <div class="form-container">
        <p><strong>RENTAL MOBIL KAK VELLL</strong> adalah layanan rental mobil terpercaya yang berbasis di Indonesia dan hadir untuk memenuhi berbagai kebutuhan transportasi Anda. Dengan pengalaman dalam industri persewaan kendaraan, kami menyediakan beragam jenis mobil berkualitas dan dalam kondisi prima, mulai dari city car yang hemat bahan bakar, mobil keluarga yang luas dan nyaman, hingga kendaraan premium untuk keperluan bisnis atau acara khusus.</p>
        <p>Kami melayani pelanggan dari berbagai latar belakang — baik individu, keluarga, wisatawan, maupun perusahaan yang membutuhkan kendaraan sewaan harian, mingguan, bahkan bulanan. Proses sewa kami dirancang agar cepat, mudah, dan transparan tanpa biaya tersembunyi, sehingga Anda dapat fokus pada perjalanan tanpa khawatir soal logistik.</p>
        <p>Didukung oleh tim profesional dan layanan pelanggan yang ramah, kami selalu siap membantu Anda memilih mobil yang tepat sesuai kebutuhan. Kami juga menawarkan opsi pengantaran dan penjemputan kendaraan di lokasi Anda untuk memberikan kemudahan dan fleksibilitas ekstra. Komitmen kami adalah memberikan pelayanan yang aman, nyaman, dan memuaskan — karena kami percaya bahwa pengalaman perjalanan yang baik dimulai dari kendaraan yang dapat diandalkan dan pelayanan yang tulus.</p>
        <p>Keamanan dan kenyamanan Anda adalah prioritas utama kami. Oleh karena itu, semua unit kendaraan kami selalu menjalani perawatan rutin dan inspeksi menyeluruh untuk memastikan performa optimal di setiap perjalanan.</p>
        <p>Terima kasih telah mempercayakan kebutuhan transportasi Anda kepada <strong>RENTAL MOBIL KAK VELLL</strong>. Kami senang menjadi bagian dari setiap langkah perjalanan Anda.</p>
    </div>
</section>
</body>
</html>
