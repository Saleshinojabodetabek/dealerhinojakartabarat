<?php
include "cek_login.php";
include "config.php";

// Ambil semua pesan dari database
$query = "SELECT * FROM contact_messages ORDER BY id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesan Pengunjung</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
      <div class="d-flex">
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <div class="container mt-4">
    <h2 class="mb-4">Halo Cang Romi 👋 - Pesan Pengunjung</h2>

    <div class="card shadow-lg border-0">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Pesan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                    <td>
                      <a href="hapus_pesan.php?id=<?= $row['id'] ?>" 
                         class="btn btn-sm btn-danger"
                         onclick="return confirm('Yakin ingin menghapus pesan ini?')">
                         🗑️ Hapus
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center text-muted">Belum ada pesan masuk</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
