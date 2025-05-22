<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Hubungi Kami - Rental Mobil Kak Velll</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: #fff;
      padding-top: 100px;
    }

    .navbar {
      background-color: #222;
      padding: 1rem 0;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
    }

    .navbar-container {
      max-width: 1200px;
      margin: auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
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


    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      color: #333;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      animation: fadeIn 1s ease;
    }

    h1 {
      text-align: center;
      color: #2c3e50;
    }

    .contact-info {
      margin-bottom: 30px;
    }

    .contact-info p {
      font-size: 1.1rem;
    }

    form input, form textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 1rem;
    }

    form button {
      background-color: #0d6efd;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-size: 1rem;
    }

    form button:hover {
      background-color: #084cdf;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

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
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="navbar-container">
      <a class="navbar-brand" href="index.php"><span class="highlight">RENTAL</span> MOBIL KAK VELLL</a>
      <ul class="navbar-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="tentang.php">About as</a></li>
        <li><a href="hubungi.php">Contact us</a></li>
      </ul>
    </div>
  </nav>

  <!-- Konten Hubungi Kami -->
  <div class="container">
    <h1>Contact us</h1>

    <div class="contact-info">
      <p><strong>Alamat:</strong> Jl. Merak No. 123, Jakarta, Indonesia</p>
      <p><strong>Telepon:</strong> +62 812-3456-7890</p>
      <p><strong>Email:</strong> kakvelllrental@gmail.com</p>
      <p><strong>Instagram:</strong> <a href="https://www.instagram.com/m_rbifrmnsyh_/" target="_blank">@Rental_MobilkakVell</a></p>
    </div>

    <form id="contactForm">
      <input type="text" name="nama" placeholder="Nama Anda" required>
      <input type="email" name="email" placeholder="Email Anda" required>
      <textarea name="pesan" rows="5" placeholder="Tulis pesan Anda..." required></textarea>
      <button type="submit">Kirim Pesan</button>
    </form>
  </div>

  <!-- JavaScript untuk notifikasi dan redirect -->
  <script>
    document.getElementById('contactForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Mencegah reload form
      
      // Simulasi pengiriman sukses
      alert("Pesan berhasil dikirim!");
      
      // Redirect ke index.php setelah 1 detik
      setTimeout(function() {
        window.location.href = "index.php";
      }, 1000);
    });
  </script>

</body>
</html>
