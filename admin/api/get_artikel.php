<?php
header('Content-Type: application/json');
include '../config.php';
$result = $conn->query('SELECT * FROM artikel ORDER BY id DESC');
$data = [];
while ($row = $result->fetch_assoc()) $data[] = $row;
echo json_encode($data);
?>