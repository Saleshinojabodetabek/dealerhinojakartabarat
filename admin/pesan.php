<?php
include "cek_login.php";
include "config.php";

// --- Pagination Setup ---
$limit = 10; // jumlah pesan per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Hitung total pesan
$total_query = $conn->query("SELECT COUNT(*) AS total FROM contact_messages");
$total_row = $total_query->fetch_assoc();
$total_pesan = $total_row['total'];
$total_pages = ceil($total_pesan / $limit);

// Ambil data pesan dengan limit
$query = "SELECT * FROM contact_messages ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesan Customer</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- penting untuk HP -->
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
    table td { vertical-align: top; }
    .table thead th {
      background: linear-gradient(90deg, #0d6efd, #0b5ed7);
      color: white; text-align: center;
    }
    .table tbody td { vertical-align: middle; }
    .pagination .page-link { color: #0d6efd; }
    .pagination .active .page-link {
      background-color: #0d6efd;
      border-color: #0d6efd;
    }

    /* --- Responsive --- */
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
      .content {
        margin-left: 0;
        margin-top: 10px;
      }
      .table-responsive { font-size: 14px; }
    }
    @media (max-width: 576px) {
      .sidebar a { font-size: 13px; padding: 6px 8px; }
      .dashboard-header { padding: 15px; }
      .dashboard-header h2 { font-size: 18px; }
      .dashboard-header p { font-size: 13px; }
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
    <a href="artikel.php">Artikel</a>
    <a href="pesan.php" class="active">Pesan Customer</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="dashboard-header">
      <h2>📩 Pesan Customer</h2>
      <p>Daftar pesan yang dikirim melalui form kontak website.</p>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
      <div class="alert alert-success">Pesan berhasil dihapus.</div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle text-center">
        <thead>
          <tr>
            <th>Nama</th>
            <th>No. HP</th>
            <th>Pesan</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td class="text-start"><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                <td><?= $row['created_at'] ?? '-' ?></td>
                <td>
                  <a href="hapus_pesan.php?id=<?= $row['id'] ?>"
                     class="btn btn-sm btn-danger"
                     onclick="return confirm('Yakin ingin menghapus pesan ini?')">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center text-muted">Belum ada pesan masuk.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
      <nav>
        <ul class="pagination justify-content-center">
          <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">« Prev</a></li>
          <?php endif; ?>
          
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>

          <?php if ($page < $total_pages): ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next »</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </div>
</body>
</html>
