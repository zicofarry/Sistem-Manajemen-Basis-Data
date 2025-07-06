<?php
    include('function.php'); 

    $id_order = mysqli_real_escape_string($conn, $_GET['id']);
    $order = getOrderById($id_order);
    $order_items = getOrderItems($id_order);

    $query = "SELECT o.order_id, m.name, m.price, oi.quantity, (m.price * oi.quantity) AS total_price
          FROM orders o
          JOIN order_items oi ON o.order_id = oi.order_id
          JOIN menu_items m ON oi.item_id = m.item_id
          WHERE o.order_id = $id_order";

    $result = mysqli_query($conn, $query);

    $orderDetails = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orderDetails[] = $row;
    }

    $totalPembayaran = 0;
    foreach ($orderDetails as $detail) {
        $totalPembayaran += $detail['total_price'];
    }

    $diskon = 0;
    if ($order && isset($order['discount_percent'])) {
        $diskon = ($order['discount_percent'] / 100) * $totalPembayaran;
    }

    $totalSetelahDiskon = $totalPembayaran - $diskon;
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
  <title>Admin Page</title>

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
    <a class="navbar-brand" href="index.php">
      <img src="images/Logo.png" alt="Black Beans" style="height: 80px;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="admin_page.php">Dashboard Admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_page.php#menu-section">Managemen Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_page.php#promosi-section">Managemen Promosi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_page.php#order-section">Managemen Order</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_page.php#crew-section">Managemen Pegawai</a>
        </li>
      </ul>
      <div class="user_option">
        <a href="index.php" class="order_online">Homepage</a>
      </div>
    </div>
  </nav>

  <!-- Dashboard Content -->
  <div class="container mt-5">
      
    <!-- Orders Section -->
    <section id="order-section" class="mt-5">
        <h3 class="text-center">Detail Order</h3>
        <hr>
        <table class="table table-bordered mt-3">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Item Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total Harga</th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach ($orderDetails as $detail): ?>
            <tr>
              <td><?= $detail['order_id'] ?></td>
              <td><?= htmlspecialchars($detail['name']) ?></td>
              <td>Rp.<?= number_format($detail['price'], 0, ',', '.')?> </td>
              <td><?= $detail['quantity'] ?></td>
              <td>Rp.<?= number_format($detail['total_price'], 0, ',', '.')?> </td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
        <hr>
            <div>
                <h6 ><b>Total Sebelum Diskon:</b> Rp<?= number_format($totalPembayaran, 0, ',', '.') ?></h6>
                <?php if ($diskon > 0): ?>
                    <h6 ><b>Diskon (<?= $order['discount_percent'] ?>%):</b> -Rp<?= number_format($diskon, 0, ',', '.') ?></h6>
                <?php endif; ?>
                <h6><b>Total Pembayaran Akhir:</b> Rp<?= number_format($totalSetelahDiskon, 0, ',', '.') ?></h6>
            </div>

            <div class="text-center mt-3">
                <a href="admin_page.php#menu-section" class="btn btn-secondary">Back to Admin Page</a>
            </div>
      </section>
      
      



  <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Black Beans. All rights reserved.</p>
    </footer>
  

  <!-- JavaScript and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>