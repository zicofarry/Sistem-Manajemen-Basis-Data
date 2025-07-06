<?php
    include('function.php'); // pastikan ini sudah include file function & koneksi database

    $listMenu = [];
    $result = readMenu(); // ambil semua menu

    while ($menu = mysqli_fetch_assoc($result)) {
        $listMenu[] = $menu;
    }

    $listShiftResult = readShift();
    $listShift = [];

    while ($row = mysqli_fetch_assoc($listShiftResult)) {
        $listShift[] = $row;
    }

    $listPromotion = readPromotion();
    $listCrew = readCrew();
    $listOrder = readOrder();
    $listApplicant = readApplicantWithLocation();
    $orderData = [];
    $query = mysqli_query($conn, "
        SELECT DATE(order_date) as order_date, SUM(total_amount) as total_harga
        FROM orders
        GROUP BY DATE(order_date)
        ORDER BY order_date ASC
    ");
    
    while ($row = mysqli_fetch_assoc($query)) {
        $orderData[] = $row;
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
        <li class="nav-item">
          <a class="nav-link" href="admin_page.php#applicant-section">Managemen Applicant</a>
        </li>
      </ul>
      <div class="user_option">
        <a href="index.php" class="order_online">Homepage</a>
      </div>
    </div>
  </nav>

  <!-- Dashboard Content -->
  <div class="container mt-5">
    <!-- Menu -->
    <section id="menu-section" class="mt-5">
    <h3 class="text-center">Managemen Menu</h3>
    <hr>
    <button onclick="window.location.href='add_menu.php'"
         class="btn btn-success d-block mx-auto"
        >Add Menu</button>

        <table class="table table-bordered mt-3">
          <thead>
            <tr>
              <th>Item ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Category</th>
              <th>Image</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
        <?php foreach ($listMenu as $menu): ?>
            <tr>
            <td><?= $menu['item_id'] ?></td>
            <td><?= htmlspecialchars($menu['name']) ?></td>
            <td><?= htmlspecialchars($menu['description']) ?></td>
            <td>Rp. <?= number_format($menu['price'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($menu['category_name']) ?></td>
            <td><img src="images/<?= $menu['image'] ?>" alt="<?= htmlspecialchars($menu['name']) ?>" style="height: 50px;"></td>
            <td>
            <a href="edit_menu.php?id=<?= $menu['item_id'] ?>"class="btn btn-warning btn-sm">Edit</a>
            <a href="delete_menu.php?id=<?= $menu['item_id'] ?>"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Are you sure you want to delete this menu?');"
            >Delete</a>

            </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
    </section>

    <!-- Promotions Section -->
    <section id="promosi-section" class="mt-5">
        <h3 class="text-center">Managemen Promosi</h3>
        <hr>
        <button onclick="window.location.href='add_promo.php'" class="btn btn-success d-block mx-auto">Add Promo</button>
  
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Promo ID</th>
                    <th>Description</th>
                    <th>Discount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Image</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($promo = mysqli_fetch_assoc($listPromotion)) {
                    $promoList[] = $promo;
                }
  
                foreach ($promoList as $promo): ?>
                    <tr>
                        <td><?= $promo['promo_id'] ?></td>
                        <td><?= htmlspecialchars($promo['description']) ?></td>
                        <td><?= (int)$promo['discount_percent'] ?>%</td>
                        <td><?= htmlspecialchars($promo['start_date']) ?></td>
                        <td><?= htmlspecialchars($promo['end_date']) ?></td>
                        <td><img src="images/<?= $promo['image'] ?>" alt="<?= htmlspecialchars($promo['promo_id']) ?>" style="height: 50px;"></td>
                        <td>
                            <a href="edit_promo.php?id=<?= $promo['promo_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_promo.php?id=<?= $promo['promo_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this promotion?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
      
    <!-- Orders Section -->
    <section id="order-section" class="mt-5">
        <h3 class="text-center">Managemen Orders</h3>
        
        <hr>
        <table class="table table-bordered mt-3">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Order Date</th>
              <th>Employee Name</th>
              <th>Promo Name</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach ($listOrder as $order): ?>
            <tr>
              <td><?= $order['order_id'] ?></td>
              <td><?= date(format: 'Y-m-d', timestamp: strtotime(datetime: $order['order_date'])) ?></td>
              <td><?= htmlspecialchars($order['name']) ?></td>
              <td><?= htmlspecialchars($order['description']) ?></td>
              <td>Rp. <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
              <td>
                <!-- <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailOrderModal">Lihat Detail</button> -->
                <a href="order_detail.php?id=<?= $order['order_id'] ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                <a href="edit_promo.php?id=<?= $order['order_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_promo.php?id=<?= $order['order_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this promotion?');">Delete</a>
              </td>
              <!-- <td>001</td>
              <td>2025-04-01</td>
              <td>Bayu</td>
              <td>Buy 1 Get 1 Free</td>
              <td>Rp. 50.000</td>
              <td>
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailOrderModal">Lihat Detail</button>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editOrderModal">Edit</button>
                <button class="btn btn-danger btn-sm">Delete</button>
              </td> -->
            </tr>
            <?php endforeach ?>
            <!-- <tr>
              <td>002</td>
              <td>2025-04-02</td>
              <td>Citra</td>
              <td>Free Coffee with Every Meal</td>
              <td>Rp. 75.000</td>
              <td>
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailOrderModal">Lihat Detail</button>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editOrderModal">Edit</button>
                <button class="btn btn-danger btn-sm">Delete</button>
              </td>
            </tr> -->
          </tbody>
        </table>
        <h3>Grafik Penjualan</h3>

        <canvas id="orderChart" width="400" height="200"></canvas>
      </section>
      
      

      
      
      
      <!-- Crew Section -->
      <section id="crew-section" class="mt-5">
        <h3 class="text-center">Managemen Pegawai</h3>
        <hr>
        <button onclick="window.location.href='add_crew.php'" class="btn btn-success d-block mx-auto">Add Crew</button>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Crew ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Hire Date</th>
                    <th>Shift</th>
                    <th>Image</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($crew = mysqli_fetch_assoc($listCrew)) {
                    $crewList[] = $crew;
                }

                foreach ($crewList as $crew): ?>
                    <tr>
                        <td><?= $crew['employee_id'] ?></td>
                        <td><?= htmlspecialchars($crew['name']) ?></td>
                        <td><?= htmlspecialchars($crew['position']) ?></td>
                        <td><?= htmlspecialchars($crew['hire_date']) ?></td>
                        <td><?= htmlspecialchars(getShiftName($crew['shift_id'], $listShift)) ?></td>
                        <td><img src="images/<?= $crew['photo'] ?>" alt="<?= htmlspecialchars($crew['name']) ?>" style="height: 50px;"></td>
                        <td>
                          <a href="edit_crew.php?id=<?= $crew['employee_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_crew.php?id=<?= $crew['employee_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
      
      <!-- Applicant Section -->
      <section id="applicant-section" class="mt-5">
        <h3 class="text-center">Managemen Applicant</h3>
        <hr>
        <button onclick="window.location.href='recruitment.php'" class="btn btn-success d-block mx-auto">Add Applicant</button>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Applicant ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Position Applied</th>
                    <th>Applicant Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($applicant = mysqli_fetch_assoc($listApplicant)) {
                    $applicantList[] = $applicant;
                }

                foreach ($applicantList as $applicant): ?>
                    <tr>
                        <td><?= $applicant['id'] ?></td>
                        <td><?= htmlspecialchars($applicant['name']) ?></td>
                        <td><?= htmlspecialchars($applicant['contact']) ?></td>
                        <td>
                          <?= htmlspecialchars($applicant['province_name']) ?>,
                          <?= htmlspecialchars($applicant['city_name']) ?>,
                          <?= htmlspecialchars($applicant['district']) ?>,
                          <?= htmlspecialchars($applicant['subdistrict']) ?>,
                          <?= htmlspecialchars($applicant['street']) ?>
                        </td>
                        <td><?= htmlspecialchars($applicant['position_applied']) ?></td>
                        <td><img src="images/<?= $applicant['photo'] ?>" alt="<?= htmlspecialchars($crew['name']) ?>" style="height: 50px;"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
  </div>



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
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('orderChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?= json_encode(array_column($orderData, 'order_date')) ?>,
      datasets: [{
        label: 'Total Harga Order per Hari',
        data: <?= json_encode(array_column($orderData, 'total_harga')) ?>,
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      scales: {
        x: {
          title: {
            display: true,
            text: 'Tanggal'
          }
        },
        y: {
          title: {
            display: true,
            text: 'Total Harga (Rp)'
          },
          beginAtZero: true
        }
      }
    }
  });
</script>



</body>

</html>