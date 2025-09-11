<?php
$host = 'localhost';
$user = 'u868657420_hinojktbarat';
$pass = 'Userrm12345';
$db = 'u868657420_hinojkt';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
?>
