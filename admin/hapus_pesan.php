<?php
include "cek_login.php";
include "config.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: pesan.php?status=deleted");
        exit();
    } else {
        echo "Gagal menghapus pesan: " . $conn->error;
    }
} else {
    header("Location: pesan.php");
    exit();
}
?>
