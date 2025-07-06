<?php
    include ('function.php');
    $listKategori = readKategori();
    if (isset($_POST['btn-add'])) {
        $isAddSucceed = addMenu($_POST, $_FILES);
     
     
        if ($isAddSucceed > 0) {
          echo "<script>
               alert('Menu Berhasil Ditambahkan');
               document.location.href = 'admin_page.php#menu-section';
               </script>";
        } else {
          echo "<script>
               alert('Gagal Menambahkan Menu!');
               document.location.href = 'admin_page.php#menu-section';
               </script>";
        }
    }
     
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic Meta Tags -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <title>Add Menu</title>

  <!-- CSS Files -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
  <!-- Admin Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <a class="navbar-brand" href="index.html">
      <img src="images/Logo.png" alt="Black Beans" style="height: 80px;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="admin_page.html">Dashboard Admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_page.html#menu-section">Managemen Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_page.html#promosi-section">Managemen Promosi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_page.html#order-section">Managemen Order</a>
        </li>
      </ul>
      <div class="user_option">
        <a href="index.html" class="order_online">Homepage</a>
      </div>
    </div>
  </nav>
  
  <div class="container mt-5">
    <h2 class="text-center">Add New Menu</h2>

    <!-- Form Add Menu -->
    <form action="add_menu.php"
      method="POST" enctype="multipart/form-data"> 

      <div class="form-group">
        <label for="menu-name">Menu Name</label>
        <input type="text" class="form-control" id="menu-name" name="name" placeholder="Enter Menu Name" required>
      </div>
      <div class="form-group">
        <label for="menu-description">Description</label>
        <textarea class="form-control" id="menu-description" name="description" placeholder="Enter Description" required></textarea>
      </div>
      <div class="form-group">
        <label for="menu-price">Price</label>
        <input type="number" class="form-control" id="menu-price" name="price" placeholder="Enter Price" required>
      </div>
      <!-- <div class="form-group">
        <label for="menu-category">Category</label>
        <input type="text" class="form-control" id="menu-category" name="category" placeholder="Enter Category" required>
      </div> -->
      <div class="form-group">
            <label for="menu-category">Category</label>
            <select class="form-control" id="menu-category"
                name="category_id" required>
            <option value="">-- Select Category --</option>
            <?php foreach ($listKategori as $kategori): ?>
            <option value="<?= $kategori['category_id'] ?>">
            <?= htmlspecialchars($kategori['category_name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
        </div>

      <div class="form-group">
        <label for="menu-image">Image</label>
        <input type="file" class="form-control" id="menu-image" name="image" required>
      </div>
      <button type="submit" name="btn-add"class="btn btn-primary">Add Menu</button>
    </form>

    <div class="text-center mt-3">
      <a href="admin_page.html" class="btn btn-secondary">Back to Admin Page</a>
    </div>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>