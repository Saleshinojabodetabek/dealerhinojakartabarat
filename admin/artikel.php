<?php
include "cek_login.php";
include "config.php";

$query = "
  SELECT a.*, k.nama_kategori 
  FROM artikel a
  LEFT JOIN kategori k ON a.kategori_id = k.id
  ORDER BY a.id DESC
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Artikel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
    .sidebar {
      height: 100vh; background: #0d6efd; color: white; padding-top: 20px;
      position: fixed; width: 220px; text-align: center;
    }
    .sidebar img { max-width: 160px; margin-bottom: 20px; }
    .sidebar a {
      display: block; padding: 12px 20px; color: white; text-decoration: none;
      margin: 4px 0; transition: background 0.2s; text-align: left;
    }
    .sidebar a:hover, .sidebar a.active {
      background: #0b5ed7; border-radius: 6px;
    }
    .content { margin-left: 220px; padding: 20px; background: #f8f9fa; min-height: 100vh; }
    .dashboard-header {
      background: linear-gradient(90deg, #0d6efd, #0b5ed7);
      color: white; padding: 20px; border-radius: 12px; margin-bottom: 25px;
    }
    table img { border-radius: 6px; }
    /* Header tabel selaras dengan dashboard */
    .table thead th {
      background: linear-gradient(90deg, #0d6efd, #0b5ed7);
      color: white;
      text-align: center;
      vertical-align: middle;
    }
    .table tbody td {
      vertical-align: middle;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="text-center mb-4">
      <img src="../img/logo3.png" alt="Logo Hino">
    </div>
    <a href="dashboard.php">Dashboard</a>
    <a href="artikel.php" class="active">Artikel</a>
    <a href="pesan.php">Pesan Customer</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="dashboard-header">
      <h2>📑 Kelola Artikel</h2>
      <p>Tambah, edit, dan hapus artikel blog.</p>
    </div>

    <a href="tambah_artikel.php" class="btn btn-success mb-3">+ Tambah Artikel</a>

    <table class="table table-bordered table-striped align-middle text-center">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Tanggal</th>
          <th>Gambar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['nama_kategori'] ?? 'Tidak ada') ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td>
              <?php 
                $gambar_path = "uploads/" . $row['gambar'];
                if (!empty($row['gambar']) && file_exists($gambar_path)):
              ?>
                <img src="<?= $gambar_path ?>" width="100">
              <?php else: ?>
                <em>Gambar tidak tersedia</em>
              <?php endif; ?>
            </td>
            <td>
              <a href="edit_artikel.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="hapus_artikel.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
