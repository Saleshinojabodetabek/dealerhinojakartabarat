<?php
$host = "localhost";
$user = "u868657420_hinojktbarat";
$pass = "Userrm12345";
$db   = "u868657420_hinojkt";

// Buat koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
