<?php
include 'config.php';

$sql = "CALL lihat_mobil_tersedia()";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo $row['merek'] . " - " . $row['tipe'] . " - " . $row['plat_nomor'] . "<br>";
}
?>
