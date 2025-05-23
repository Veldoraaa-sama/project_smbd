<?php
include 'config.php';

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];

$sql = "CALL tambah_pelanggan('$nama', '$alamat', '$telepon')";
if ($conn->query($sql) === TRUE) {
    echo "Pelanggan berhasil ditambahkan.";
} else {
    echo "Error: " . $conn->error;
}
?>
