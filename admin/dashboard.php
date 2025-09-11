<?php
include "cek_login.php";
include "config.php";

// Ambil data artikel beserta nama kategori-nya
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
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="mb-0">Halo Cang Romi 👋 - Daftar Artikel</h2>
      <a href="tambah_artikel.php" class="btn btn-success">+ Tambah Artikel</a>
    </div>

    <div class="card shadow-lg border-0">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Gambar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result->num_rows > 0): ?>
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
                        <img src="<?= $gambar_path ?>" width="100" class="rounded shadow-sm">
                      <?php else: ?>
                        <img src="https://via.placeholder.com/100x70?text=No+Image" class="rounded shadow-sm">
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="edit_artikel.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                      <a href="hapus_artikel.php?id=<?= $row['id'] ?>" 
                         class="btn btn-sm btn-danger"
                         onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                         🗑️ Hapus
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center text-muted">Belum ada artikel</td>
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
