<?php
// Aktifkan error reporting saat development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cek login dan koneksi
include "cek_login.php";
include "koneksi.php";

// Proses ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $judul       = trim($_POST['judul'] ?? '');
  $isi         = trim($_POST['isi'] ?? '');
  $kategori_id = intval($_POST['kategori_id'] ?? 0);

  if (empty($judul) || empty($isi) || $kategori_id <= 0) {
    $error = "Semua field wajib diisi.";
  } elseif (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    $error = "Gambar wajib diupload.";
  } else {
    // Proses upload gambar
    $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    $nama_file_bersih = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($_FILES['gambar']['name'], PATHINFO_FILENAME));
    $nama_file = time() . "_" . $nama_file_bersih . "." . $ext;

    $target_dir = __DIR__ . "/uploads/";
    $target_file = $target_dir . $nama_file;

    if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
      $stmt = mysqli_prepare($koneksi, "INSERT INTO artikel (judul, isi, gambar, kategori_id) VALUES (?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, "sssi", $judul, $isi, $nama_file, $kategori_id);

      if (mysqli_stmt_execute($stmt)) {
        header("Location: artikel.php?success=1");
        exit;
      } else {
        $error = "Gagal menyimpan artikel. Error DB: " . mysqli_error($koneksi);
      }
      mysqli_stmt_close($stmt);
    } else {
      $error = "Gagal upload gambar. Pastikan folder 'uploads/' bisa ditulis.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Artikel</title>
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
    .form-card {
      background: white; padding: 25px; border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="text-center mb-4">
      <img src="../img/logo3.png" alt="Logo Hino">
    </div>
    <a href="index.php">Dashboard</a>
    <a href="artikel.php" class="active">Artikel</a>
    <a href="pesan.php">Pesan Customer</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="dashboard-header">
      <h2>📝 Tambah Artikel Baru</h2>
      <p>Isi form di bawah untuk menambahkan artikel ke website.</p>
    </div>

    <div class="form-card">
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="judul" class="form-label">Judul Artikel</label>
          <input type="text" name="judul" id="judul" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="isi" class="form-label">Isi Artikel</label>
          <textarea name="isi" id="isi" rows="8" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
          <label for="kategori_id" class="form-label">Kategori</label>
          <select name="kategori_id" id="kategori_id" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
              $kategori = mysqli_query($koneksi, "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
              while ($row = mysqli_fetch_assoc($kategori)) {
                echo "<option value='{$row['id']}'>{$row['nama_kategori']}</option>";
              }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="gambar" class="form-label">Upload Gambar</label>
          <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan Artikel</button>
        <a href="artikel.php" class="btn btn-secondary">⬅ Kembali</a>
      </form>
    </div>
  </div>
</body>
</html>
