<?php
include "cek_login.php";
include "config.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
    .sidebar {
      height: 100vh; background: #0d6efd; color: white; padding-top: 20px;
      position: fixed; width: 220px; text-align: center;
    }
    .sidebar img { max-width: 180px; margin-bottom: 20px; }
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
      color: white; padding: 25px; border-radius: 12px; margin-bottom: 25px;
    }
    .card { border: none; border-radius: 12px; transition: 0.2s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
    .card h5 { color: #0d6efd; }
    .btn-primary { background: #0d6efd; border: none; }
    .btn-primary:hover { background: #0b5ed7; }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="text-center mb-4">
      <img src="../img/logo3.png" alt="Logo Hino">
    </div>
    <a href="index.php" class="active">Dashboard</a>
    <a href="artikel.php">Artikel</a>
    <a href="pesan.php">Pesan Customer</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="dashboard-header">
      <h2>Selamat Datang, Cang Romi 👋</h2>
      <p>Kelola artikel & pesan customer melalui dashboard ini.</p>
    </div>

    <div class="row g-4">
      <div class="col-md-6">
        <div class="card shadow-sm p-4 text-center">
          <h5>📰 Kelola Artikel</h5>
          <p>Tambah, edit, hapus artikel blog secara praktis.</p>
          <a href="artikel.php" class="btn btn-primary">Lihat Artikel</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm p-4 text-center">
          <h5>📩 Pesan Customer</h5>
          <p>Lihat pesan yang dikirim melalui form kontak website.</p>
          <a href="pesan.php" class="btn btn-primary">Lihat Pesan</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
