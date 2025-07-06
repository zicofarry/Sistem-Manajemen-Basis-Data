<?php
    include('function.php');

    // Kalau ada form submit edit
    if (isset($_POST['btn-edit'])) {
        $isEditSucceed = editPromo($_POST, $_FILES);

        if ($isEditSucceed > 0) {
            echo "
            <script>
                alert('Promosi berhasil diupdate!');
                window.location.href = 'admin_page.php#promosi-section';
            </script>";
        } else {
            echo "
            <script>
                alert('Gagal update promosi!');
                window.location.href = 'admin_page.php#promosi-section';
            </script>";
        }
        exit;
    }

    // Kalau baru buka halaman edit
    if (!isset($_GET['id'])) {
        echo "<script>alert('No promo selected!'); window.location.href='admin_page.php#promosi-section';</script>";
        exit;
    }

    $id = $_GET['id'];

    // Ambil data promosi berdasarkan ID
    $query = "SELECT * FROM promotions WHERE promo_id = '$id'";
    $result = mysqli_query($conn, $query);
    $promo = mysqli_fetch_assoc($result);

    // Kalau ID tidak ditemukan di database
    if (!$promo) {
        echo "<script>alert('Promo not found!'); window.location.href='admin_page.php#promosi-section';</script>";
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Edit Promosi | Admin Page</title>

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
          <a class="nav-link" href="admin_page.php#promosi-section">Managemen Promosi</a>
        </li>
      </ul>
      <div class="user_option">
        <a href="index.php" class="order_online">Homepage</a>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <div class="container mt-5">
    <h2 class="text-center">Edit Promosi</h2>

    <form action="edit_promo.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="promo_id" value="<?= $promo['promo_id'] ?>">

      <div class="form-group">
        <label for="edit-promo-name">Description</label>
        <input type="text" class="form-control" id="edit-promo-description" name="description" value="<?= htmlspecialchars($promo['description']) ?>" required>
      </div>

      <div class="form-group">
        <label for="edit-promo-discount_percent">Discount Percent</label>
        <input type="text" class="form-control" id="edit-discount_percent" name="discount_percent" value="<?= htmlspecialchars($promo['discount_percent']) ?>" required>
      </div>

      <div class="form-group">
        <label for="edit-promo-start_date">Start Date</label>
        <input type="date" class="form-control" id="edit-promo-start_date" name="start_date" value="<?= $promo['start_date'] ?>" required>
      </div>

      <div class="form-group">
        <label for="edit-promo-end_date">End Date</label>
        <input type="date" class="form-control" id="edit-promo-end_date" name="end_date" value="<?= $promo['end_date'] ?>" required>
      </div>

      <div class="form-group">
        <label for="edit-promo-image">Change Image (Optional)</label>
        <input type="file" class="form-control" id="edit-promo-image" name="image">
        <small>Current Image: <?= htmlspecialchars($promo['image']) ?></small>
      </div>

      <button type="submit" name="btn-edit" class="btn btn-primary">Update promo</button>
    </form>

    <div class="text-center mt-3">
      <a href="admin_page.php#promosi-section" class="btn btn-secondary">Back to Admin Page</a>
    </div>
  </div>

  <!-- JS -->
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>