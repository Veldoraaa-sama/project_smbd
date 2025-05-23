<?php
include 'config.php';

$id_mobil = $_POST['id_mobil'];
$status = $_POST['status'];

$sql = "CALL update_status_mobil($id_mobil, '$status')";
if ($conn->query($sql) === TRUE) {
    echo "Status mobil berhasil diupdate.";
} else {
    echo "Error: " . $conn->error;
}
?>
