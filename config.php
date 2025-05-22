<?php
// config.php - Database Configuration (Simplified Version)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tugasakhir';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Optional: Check if database objects exist, if not show instruction
function checkDatabaseObjects($pdo, $database) {
    try {
        // Bangun nama kolom untuk view check
        $columnName = "Tables_in_$database";
        $sql = "SHOW FULL TABLES WHERE TABLE_TYPE LIKE 'VIEW'";
        $result = $pdo->query($sql);

        $viewExists = false;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if (isset($row[$columnName]) && $row[$columnName] === 'view_transaksi_detail') {
                $viewExists = true;
                break;
            }
        }

        // Check if stored procedure exists
        $procCheck = $pdo->query("SHOW PROCEDURE STATUS WHERE Name = 'HitungTotalSewa'");

        // Check if trigger exists
        $triggerCheck = $pdo->query("SHOW TRIGGERS LIKE 'after_insert_transaksi'");

        // Tampilkan peringatan jika salah satu tidak ditemukan
        if (!$viewExists || $procCheck->rowCount() == 0 || $triggerCheck->rowCount() == 0) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border-radius: 5px;'>";
            echo "<strong>Warning:</strong> Database objects (stored procedures, views, triggers) belum dibuat. ";
            echo "Silakan jalankan script SQL terlebih dahulu di MySQL.";
            echo "</div>";
        }
    } catch(Exception $e) {
        // Abaikan error (atau tampilkan untuk debug)
        // echo $e->getMessage();
    }
}

// Panggil dengan parameter database
if (isset($_GET['check_db'])) {
    checkDatabaseObjects($pdo, $database);
}
