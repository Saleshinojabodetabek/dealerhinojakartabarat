<?php
// Ambil ID artikel dari URL
$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("https://dealerhinojakartabarat.com/admin/api/get_artikel.php"), true);
$artikel = null;

// Cari artikel berdasarkan ID
if ($id && is_array($data)) {
  foreach ($data as $item) {
    if ($item['id'] == $id) {
      $artikel = $item;
      break;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="<?= htmlspecialchars($artikel['judul']) ?>, Hino, Truk, Dealer Hino, Jabodetabek, Hino Indonesia" />
    <meta property="og:title" content="<?= htmlspecialchars($artikel['judul']) ?>" />
    <meta property="og:description" content="<?= substr(strip_tags($artikel['isi']), 0, 150) ?>..." />
    <meta property="og:image" content="<?= htmlspecialchars($artikel['gambar']) ?>" />
    <meta property="og:url" content="https://dealerhinojakartabarat.com/detail_artikel.php?id=<?= $artikel['id'] ?>" />
    <title>Dealer Hino Indonesia | Sales Truck Hino Terbaik di Jabodetabek</title>
    <meta name="description" content="Dealer Resmi Hino Jakarta. Hubungi : 0822 2628 6007 Untuk mendapatkan informasi produk Hino. Layanan Terbaik dan Jaminan Mutu.">
    <link rel="icon" type="image/png" href="/img/favicon.png">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/navbar.css" />
    <link rel="stylesheet" href="css/home_css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/artikel.css">

    <!-- JS -->
    <script src="js/script.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Tambahan Perbaikan Ukuran Navbar & Footer -->
  </head>
  <body>

    <!-- Header -->
    <header>
      <div class="container header-content navbar">
    <!-- Logo -->
    <div class="header-title">
      <a href="https://dealerhinojakartabarat.com/">
        <img src="img/logo3.png" alt="Logo Hino" style="height: 60px" />
      </a>
    </div>
        <div class="hamburger-menu">&#9776;</div>
        <nav class="nav links">
          <a href="index.php">Home</a>
          <a href="hino300.html">Hino 300 Series</a>
          <a href="hino500.html">Hino 500 Series</a>
          <a href="hinobus.html">Hino Bus Series</a>
          <a href="artikel.php">Blog & Artikel</a>
          <a href="contact.html">Contact</a>
        </nav>
      </div>
    </header>

    <!-- Konten Artikel -->
    <section class="detail-artikel">
      <div class="container">
        <div class="artikel-wrapper" style="display: flex; flex-wrap: wrap; gap: 30px;">
          <div class="artikel-main" style="flex: 1 1 65%;">
            <?php if($artikel): ?>
              <h1><?= htmlspecialchars($artikel['judul']) ?></h1>
              <p style="color: #888; font-size: 14px; margin-bottom: 15px;">
                Diposting oleh <strong><?= htmlspecialchars($artikel['author'] ?? 'Romi Hino') ?></strong> pada <?= date('d M Y', strtotime($artikel['created_at'] ?? 'now')) ?>
              </p>
              <img src="<?= htmlspecialchars($artikel['gambar']) ?>" alt="<?= htmlspecialchars($artikel['judul']) ?>" class="featured-image" style="width: 100%; height: auto; margin-bottom: 20px;">
              <div class="isi-artikel">
                <?= nl2br($artikel['isi']) ?>
              </div>
              <a href="artikel.php" class="btn-kembali" style="display:inline-block; margin-top:20px;">Kembali ke Daftar Artikel</a>
            <?php else: ?>
              <p>Artikel tidak ditemukan.</p>
            <?php endif; ?>
          </div>

          <!-- Sidebar -->
          <aside class="artikel-sidebar" style="flex: 1 1 30%;">
            <div class="sidebar-section">
              <h3>Recent Posts</h3>
              <div class="recent-posts-list">
                <?php
                foreach (array_slice($data, 0, 5) as $recent) {
                  if ($recent['id'] != $id) {
                    echo '<div class="recent-post-item" style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">';
                    echo '<a href="detail_artikel.php?id=' . $recent['id'] . '" style="flex-shrink: 0;">';
                    echo '<img src="' . htmlspecialchars($recent['gambar']) . '" alt="' . htmlspecialchars($recent['judul']) . '" style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px;">';
                    echo '</a>';
                    echo '<div style="flex: 1;">';
                    echo '<a href="detail_artikel.php?id=' . $recent['id'] . '" style="font-weight: 600; text-decoration: none; color: #333; line-height: 1.3; display: block;">' . htmlspecialchars($recent['judul']) . '</a>';
                    echo '</div>';
                    echo '</div>';
                  }
                }
                ?>
              </div>
            </div>

            <div class="sidebar-section">
              <h3>Kategori</h3>
              <ul style="list-style: none; padding-left: 0;">
                <?php
                $kategori = array_unique(array_column($data, 'kategori'));
                foreach ($kategori as $kat) {
                  if (!empty($kat)) {
                    echo '<li style="margin-bottom: 8px;">';
                    echo '<a href="artikel.php?kategori=' . urlencode($kat) . '" style="text-decoration: none; color: #333; font-weight: 500;">• ' . htmlspecialchars($kat) . '</a>';
                    echo '</li>';
                  }
                }
                ?>
              </ul>
            </div>
          </aside>
        </div>

        <!-- Related Posts -->
        <?php if ($artikel): ?>
        <div class="related-posts" style="margin-top: 60px;">
          <h2 style="margin-bottom: 25px; font-size: 26px; font-weight: 700;">Related Posts</h2>
          <div class="related-list" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
            <?php
            $related_count = 0;
            foreach ($data as $rel) {
              if ($rel['id'] != $id && isset($rel['kategori'], $artikel['kategori']) && $rel['kategori'] === $artikel['kategori']) {
                echo '<div class="related-item" style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">';
                echo '<a href="detail_artikel.php?id=' . $rel['id'] . '" style="text-decoration: none; color: #333;">';
                echo '<img src="' . htmlspecialchars($rel['gambar']) . '" alt="' . htmlspecialchars($rel['judul']) . '" style="width: 100%; height: 160px; object-fit: cover;">';
                echo '<div style="padding: 15px;">';
                echo '<h4 style="font-size: 16px; font-weight: 600; margin: 0 0 10px 0;">' . htmlspecialchars($rel['judul']) . '</h4>';
                echo '<p style="font-size: 14px; color: #666;">' . substr(strip_tags($rel['isi']), 0, 100) . '...</p>';
                echo '</div></a></div>';
                $related_count++;
                if ($related_count >= 3) break;
              }
            }
            if ($related_count === 0) {
              echo "<p>Tidak ada artikel terkait.</p>";
            }
            ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
      <div class="footer-container">
        <div class="footer-section">
          <img src="img/logo3.png" alt="Logo" class="footer-logo" />
          <p>Romi, Sales Hino Jakarta yang berpengalaman dan profesional, siap menjadi mitra terbaik Anda dalam memenuhi kebutuhan kendaraan niaga.</p>
        </div>
        <div class="footer-section">
          <h4>HUBUNGI KAMI</h4>
          <p>📞 0822 2628 6007</p>
          <p>📧 septihadromy861@gmail.com</p>
          <p>📍 Golf Lake Ruko Venice, Jl. Lkr. Luar Barat No.78 Blok B, RT.9/RW.14, Cengkareng Tim., Kecamatan Cengkareng, Jakarta</p>
          <div class="footer-social">
            <h4>SOSIAL MEDIA</h4>
          <div class="social-icons">
            <a href="https://www.instagram.com/romydumm" target="_blank" aria-label="Instagram Sales Hino Jabodetabek">
              <i data-feather="instagram"></i>
            </a>
            <a href="https://wa.me/+6282226286007?text=Halo%20Saya%20Dapat%20Nomor%20Anda%20Dari%20Google" target="_blank" aria-label="WhatsApp Sales Hino Jabodetabek">
              <i data-feather="phone"></i>
            </a>
            <a href="https://www.facebook.com/share/1A8eoMcNJP/" target="_blank" aria-label="Facebook Sales Hino Jabodetabek">
              <i data-feather="facebook"></i>
            </a>
          </div>
          </div>
        </div>
        <div class="footer-section">
          <div class="google-map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.001117199873!2d106.72798237355298!3d-6.130550360104524!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f70ab03b3611%3A0x2e6e345ac4d4fd04!2sHINO%20CENGKARENG%20(DGMI)!5e0!3m2!1sid!2sid!4v1752934707067!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 Dealer Hino Jakarta Barat. All Rights Reserved.</p>
      </div>
    </footer>

    <script>
      feather.replace();
    </script>
  </body>
</html>
