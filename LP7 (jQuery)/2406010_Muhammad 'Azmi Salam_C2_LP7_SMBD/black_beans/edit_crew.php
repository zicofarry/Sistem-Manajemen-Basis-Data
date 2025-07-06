<?php
    include('function.php');

    // Kalau ada form submit edit
    if (isset($_POST['btn-edit'])) {
        $isEditSucceed = editCrew($_POST, $_FILES);

        if ($isEditSucceed > 0) {
            echo "
            <script>
                alert('Pegawai berhasil diupdate!');
                window.location.href = 'admin_page.php#crew-section';
            </script>";
        } else {
            echo "
            <script>
                alert('Gagal update Pegawai!');
                window.location.href = 'admin_page.php#crew-section';
            </script>";
        }
        exit;
    }

    // Kalau baru buka halaman edit
    if (!isset($_GET['id'])) {
        echo "<script>alert('No crew selected!'); window.location.href='admin_page.php#crew-section';</script>";
        exit;
    }

    $id = $_GET['id'];

    // Ambil data crew berdasarkan ID
    $query = "SELECT * FROM employees WHERE employee_id = '$id'";
    $result = mysqli_query($conn, $query);
    $crew = mysqli_fetch_assoc($result);

    // Kalau ID tidak ditemukan di database
    if (!$crew) {
        echo "<script>alert('Crew not found!'); window.location.href='admin_page.php#crew-section';</script>";
        exit;
    }

    // Ambil semua kategori buat dropdown
    // $listCrew = [];
    // $resultCrew = readCrew();
    // while ($crew = mysqli_fetch_assoc($resultCrew)) {
    //     $listCrew[] = $crew;
    // }

    $listShift = [];
    $resultShift = readShift();
    while ($shift = mysqli_fetch_assoc($resultShift)) {
        $listShift[] = $shift;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Edit Crew | Admin Page</title>

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
          <a class="nav-link" href="admin_page.php#crew-section">Managemen Crew</a>
        </li>
      </ul>
      <div class="user_option">
        <a href="index.php" class="order_online">Homepage</a>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <div class="container mt-5">
    <h2 class="text-center">Edit Crew</h2>

    <form action="edit_crew.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="employee_id" value="<?= $crew['employee_id'] ?>">

      <div class="form-group">
        <label for="edit-crew-name">Crew Name</label>
        <input type="text" class="form-control" id="edit-crew-name" name="name" value="<?= htmlspecialchars($crew['name']) ?>" required>
      </div>

      <div class="form-group">
        <label for="edit-crew-position">Position</label>
        <input type="text" class="form-control" id="edit-crew-position" name="position" value="<?= htmlspecialchars($crew['position']) ?>" required>
      </div>

      <div class="form-group">
        <label for="edit-crew-hire_date">Hire Date</label>
        <input type="date" class="form-control" id="edit-crew-hire_date" name="hire_date" value="<?= $crew['hire_date'] ?>" required>
      </div>

      <div class="form-group">
      <label for="edit-crew-shift_id">Shift Id</label>
            <select class="form-control" id="edit-crew-shift_id"
                name="shift_id" required>
            <option value="">-- Select Shift Id --</option>
            <?php foreach ($listShift as $shift): ?>
            <option value="<?= $shift['shift_id'] ?>">
            <?= htmlspecialchars($shift['shift_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="edit-crew-image">Change Photo (Optional)</label>
        <input type="file" class="form-control" id="edit-crew-photo" name="photo">
        <small>Current photo: <?= htmlspecialchars($crew['photo']) ?></small>
      </div>

      <button type="submit" name="btn-edit" class="btn btn-primary">Update Crew</button>
    </form>

    <div class="text-center mt-3">
      <a href="admin_page.php#crew-section" class="btn btn-secondary">Back to Admin Page</a>
    </div>
  </div>

  <!-- JS -->
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>