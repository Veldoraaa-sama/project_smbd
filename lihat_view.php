<?php
include 'config.php';

$views = ['view_mobil_tersedia', 'view_mobil_populer', 'view_transaksi_per_karyawan', 'view_pelanggan_aktif'];

foreach ($views as $view) {
    echo "<h3>Data dari $view</h3>";
    $result = $conn->query("SELECT * FROM $view");

    while ($row = $result->fetch_assoc()) {
        print_r($row);
        echo "<br>";
    }
    echo "<hr>";
}
?>
