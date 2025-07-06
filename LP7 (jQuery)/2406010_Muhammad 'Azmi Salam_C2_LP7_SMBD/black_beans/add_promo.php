<?php
    include ('function.php');
    if (isset($_POST['btn-add'])) {
        $isAddSucceed = addPromo($_POST, $_FILES);
     
     
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
    <h2 class="text-center">Add New Promotion</h2>

    <!-- Form Add Promo -->
    <form action="add_promo.php"
      method="POST" enctype="multipart/form-data"> 

      <div class="form-group">
        <label for="promo-name">Description</label>
        <input type="text" class="form-control" id="promo-description" name="description" placeholder="Enter Promo Description" required>
      </div>
      <div class="form-group">
        <label for="promo-position">Discount Persent</label>
        <input type="number" class="form-control" id="promo-discount_percent" name="discount_percent" placeholder="Enter Discount Percent" required>
      </div>
      <div class="form-group">
        <label for="promo-price">Start Date</label>
        <input type="date" class="form-control" id="promo-start_date" name="start_date" placeholder="Enter Start Date" required>
      </div>
      <div class="form-group">
        <label for="promo-price">End Date</label>
        <input type="date" class="form-control" id="promo-end_date" name="end_date" placeholder="Enter End Date" required>
      </div>
    

      <div class="form-group">
        <label for="menu-image">Image</label>
        <input type="file" class="form-control" id="promo-image" name="image" required>
      </div>
      <button type="submit" name="btn-add"class="btn btn-primary">Add promo</button>
    </form>

    <div class="text-center mt-3">
      <a href="admin_page.html" class="btn btn-secondary">Back to Admin Page</a>
    </div>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>