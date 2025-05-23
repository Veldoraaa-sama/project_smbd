<?php
// Koneksi MySQLi (untuk query biasa)
$koneksi = mysqli_connect("localhost", "root", "", "tugasakhir");

// Cek koneksi MySQLi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Nama database (penting untuk fungsi pengecekan objek)
$database = "tugasakhir";

// Koneksi PDO (untuk pengecekan view, procedure, trigger)
try {
    $pdo = new PDO("mysql:host=localhost;dbname=$database", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("PDO Koneksi gagal: " . $e->getMessage());
}

// Fungsi untuk mengecek apakah objek-objek database tersedia
function checkDatabaseObjects($pdo, $database) {
    try {
        $columnName = "Tables_in_$database";

        // Cek apakah view 'view_transaksi_detail' ada
        $sql = "SHOW FULL TABLES WHERE TABLE_TYPE LIKE 'VIEW'";
        $result = $pdo->query($sql);

        $viewExists = false;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if (isset($row[$columnName]) && $row[$columnName] === 'view_transaksi_detail') {
                $viewExists = true;
                break;
            }
        }

        // Cek apakah stored procedure 'HitungTotalSewa' ada
        $procCheck = $pdo->query("SHOW PROCEDURE STATUS WHERE Name = 'HitungTotalSewa'");

        // Cek apakah trigger 'after_insert_transaksi' ada
        $triggerCheck = $pdo->query("SHOW TRIGGERS LIKE 'after_insert_transaksi'");

        // // Jika salah satu tidak ditemukan, tampilkan peringatan
        // if (!$viewExists || $procCheck->rowCount() == 0 || $triggerCheck->rowCount() == 0) {
        //     echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border-radius: 5px;'>";
        //     echo "<strong>Warning:</strong> Beberapa objek database (view, procedure, trigger) belum tersedia.<br>";
        //     echo "Silakan jalankan script SQL `tugasakhir.sql` terlebih dahulu di phpMyAdmin atau MySQL.";
        //     echo "</div>";
        // }
    } catch(Exception $e) {
        // Untuk debug: tampilkan jika perlu
        // echo "<div style='color: red;'>Pengecekan gagal: " . $e->getMessage() . "</div>";
    }
}

// Jika URL mengandung ?check_db, jalankan pengecekan
if (isset($_GET['check_db'])) {
    checkDatabaseObjects($pdo, $database);
}
?>
