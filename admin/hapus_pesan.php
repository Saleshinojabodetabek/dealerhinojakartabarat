<?php
include "cek_login.php";
include "config.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM contact_messages WHERE id=$id");
}

header("Location: pesan.php");
exit();
