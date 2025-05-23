<?php
include 'config.php';

$id_pelanggan = $_GET['id'];
$sql = "CALL total_transaksi_pelanggan($id_pelanggan)";
$result = $conn->query($sql);

$row = $result->fetch_assoc();
echo "Total Belanja: Rp. " . $row['total_belanja'];
?>
