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
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- penting untuk mobile -->
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
    .table thead th {
      background: linear-gradient(90deg, #0d6efd, #0b5ed7);
      color: white;
      text-align: center;
      vertical-align: middle;
    }
    .table tbody td { vertical-align: middle; }

    /* --- Responsive, disamakan dengan pesan.php --- */
    @media (max-width: 992px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        padding: 10px;
      }
      .sidebar img { max-width: 100px; margin: 0; }
      .sidebar a {
        display: inline-block;
        margin: 0 6px;
        padding: 8px 12px;
      }
      .content { margin-left: 0; margin-top: 10px; }
      .table-responsive { font-size: 14px; } /* sama dengan pesan.php */
    }
    @media (max-width: 576px) {
      .sidebar a { font-size: 13px; padding: 6px 8px; }
      .dashboard-header { padding: 15px; }
      .dashboard-header h2 { font-size: 18px; }
      .dashboard-header p { font-size: 13px; }
      table img { width: 70px; }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="text-center mb-4 d-none d-lg-block">
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

    <!-- Notifikasi -->
    <?php if (isset($_GET['status'])): ?>
      <?php if ($_GET['status'] === 'added'): ?>
        <div class="alert alert-success">Artikel berhasil ditambahkan.</div>
      <?php elseif ($_GET['status'] === 'edited'): ?>
        <div class="alert alert-info">Artikel berhasil diperbarui.</div>
      <?php elseif ($_GET['status'] === 'deleted'): ?>
        <div class="alert alert-success">Artikel berhasil dihapus.</div>
      <?php endif; ?>
    <?php endif; ?>

    <a href="tambah_artikel.php" class="btn btn-success mb-3">+ Tambah Artikel</a>

    <div class="table-responsive">
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
                <a href="edit_artikel.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning mb-1">Edit</a>
                <a href="hapus_artikel.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
