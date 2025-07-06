<?php
    include('function.php');

    // Kalau ada form submit edit
    if (isset($_POST['btn-edit'])) {
        $isEditSucceed = editMenu($_POST, $_FILES);

        if ($isEditSucceed > 0) {
            echo "
            <script>
                alert('Menu berhasil diupdate!');
                window.location.href = 'admin_page.php#menu-section';
            </script>";
        } else {
            echo "
            <script>
                alert('Gagal update menu!');
                window.location.href = 'admin_page.php#menu-section';
            </script>";
        }
        exit;
    }

    // Kalau baru buka halaman edit
    if (!isset($_GET['id'])) {
        echo "<script>alert('No menu selected!'); window.location.href='admin_page.php#menu-section';</script>";
        exit;
    }

    $id = $_GET['id'];

    // Ambil data menu berdasarkan ID
    $query = "SELECT * FROM menu_items WHERE item_id = '$id'";
    $result = mysqli_query($conn, $query);
    $menu = mysqli_fetch_assoc($result);

    // Kalau ID tidak ditemukan di database
    if (!$menu) {
        echo "<script>alert('Menu not found!'); window.location.href='admin_page.php#menu-section';</script>";
        exit;
    }

    // Ambil semua kategori buat dropdown
    $listKategori = [];
    $resultKategori = readKategori();
    while ($kategori = mysqli_fetch_assoc($resultKategori)) {
        $listKategori[] = $kategori;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Edit Menu | Admin Page</title>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="css/style.css" rel="stylesheet" />
</head>

<body>
  <!-- Admin Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">
      <img src="images/Logo.png" alt="Black Beans" style="height: 80px;">
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="admin_page.php">Dashboard Admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_page.php#menu-section">Managemen Menu</a>
        </li>
      </ul>
      <div class="user_option">
        <a href="index.php" class="order_online">Homepage</a>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <div class="container mt-5">
    <h2 class="text-center">Edit Menu</h2>

    <form action="edit_menu.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="item_id" value="<?= $menu['item_id'] ?>">

      <div class="form-group">
        <label for="edit-menu-name">Menu Name</label>
        <input type="text" class="form-control" id="edit-menu-name" name="name" value="<?= htmlspecialchars($menu['name']) ?>" required>
      </div>

      <div class="form-group">
        <label for="edit-menu-description">Description</label>
        <textarea class="form-control" id="edit-menu-description" name="description" required><?= htmlspecialchars($menu['description']) ?></textarea>
      </div>

      <div class="form-group">
        <label for="edit-menu-price">Price</label>
        <input type="number" class="form-control" id="edit-menu-price" name="price" value="<?= $menu['price'] ?>" required>
      </div>

      <div class="form-group">
        <label for="edit-menu-category">Category</label>
        <select class="form-control" id="edit-menu-category" name="category_id" required>
          <option value="">-- Select Category --</option>
          <?php foreach ($listKategori as $kategori): ?>
            <option value="<?= $kategori['category_id'] ?>" <?= ($menu['category_id'] == $kategori['category_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($kategori['category_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="edit-menu-image">Change Image (Optional)</label>
        <input type="file" class="form-control" id="edit-menu-image" name="image">
        <small>Current image: <?= htmlspecialchars($menu['image']) ?></small>
      </div>

      <button type="submit" name="btn-edit" class="btn btn-primary">Update Menu</button>
    </form>

    <div class="text-center mt-3">
      <a href="admin_page.php#menu-section" class="btn btn-secondary">Back to Admin Page</a>
    </div>
  </div>

  <!-- JS -->
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>