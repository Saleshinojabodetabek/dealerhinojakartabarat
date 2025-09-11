<?php
include "cek_login.php";
include "config.php";

$query = "SELECT * FROM contact_messages ORDER BY id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Pesan Customer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-4">
    <h2>Pesan Customer</h2>
    <a href="logout.php" class="btn btn-danger mb-3 float-end">Logout</a>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Nama</th>
          <th>No. HP</th>
          <th>Pesan</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td><?= $row['created_at'] ?? '-' ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
