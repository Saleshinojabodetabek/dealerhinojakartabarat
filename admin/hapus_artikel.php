<?php
include "cek_login.php";
include "config.php";

$id = $_GET['id'];

// hapus gambar dulu
$cek = $conn->query("SELECT gambar FROM artikel WHERE id=$id");
$data = $cek->fetch_assoc();
if (!empty($data['gambar']) && file_exists("uploads/" . $data['gambar'])) {
  unlink("uploads/" . $data['gambar']);
}

// hapus dari database
$conn->query("DELETE FROM artikel WHERE id=$id");

// redirect dengan notifikasi sukses
header("Location: artikel.php?status=deleted");
exit();
?>
