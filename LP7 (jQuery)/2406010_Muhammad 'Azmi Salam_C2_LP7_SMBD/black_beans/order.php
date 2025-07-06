<?php
    include('function.php');
    $listMenu = readMenu();
    $listKategori = readKategori();
    $listPromotion = readPromotion();
    $listCrew = readCrew();

?>


<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="">

  <title> Order </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>

<body class="sub_page">

  <div class="hero_area">
    <div class="bg-box">
      <img src="images/hero-bg.jpg" alt="">
    </div>

    <!-- header section starts -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.php">
            <span>
              <img src="images/Logo.png" alt="Black Beans" style="height: 80px;">
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mx-auto ">
              <li class="nav-item active">
                <a class="nav-link" href="index.php#">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php#menu">Menu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php#about">About</a>
              </li>              
              <li class="nav-item">
                <a class="nav-link" href="order.php">Order</a>
              </li>
            </ul>
            <div class="user_option">
              <a href="admin_page.php" class="order_online">
                Laman Admin
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->

    <!-- slider section -->
    <section class="slider_section ">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          
          <div class="carousel-item active">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      Welcome to Black Beans Cafe
                    </h1>
                    <p>
                      Silahkan pilih menu yang anda inginkan, dan kami akan menyiapkan pesanan anda dengan cepat dan tepat.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>
    <!-- end slider section -->
  </div>

  <br>
  <!-- food section -->

  <section id="menu" class="food_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Black Beans Cafe's Menu
        </h2>
      </div>

      <ul class="filters_menu">
        <li class="active" data-filter="*">All</li>
        <?php
        while ($kategori = mysqli_fetch_assoc($listKategori)) {
            // Bikin nama class dari category_name
            $filterClass = strtolower(str_replace(' ', '', $kategori['category_name']));
        ?>
            <li data-filter=".<?php echo $filterClass; ?>"><?php echo htmlspecialchars($kategori['category_name']); ?></li>
        <?php
        }
        ?>
        </ul>


      <div class="filters-content">
        <div class="row grid">

          <?php
            while ($menu = mysqli_fetch_assoc($listMenu)) {
                // Buat class filter dari nama kategori
                $kategoriClass = strtolower(str_replace(' ', '', 
                                    $menu['category_name']));
                // Harga format
                $harga = number_format($menu['price'], 0, ',', '.');


                // Nama gambar dari database
                $gambar = 'images/' . $menu['image'];
                $id_unik = $menu['item_id'];

            ?>
            <div class="col-sm-6 col-lg-4 all <?php echo $kategoriClass;?>">
            <div class="box">
                <div>
                <div class="img-box">
                    <img src="<?php echo $gambar; ?>"
                        alt="<?php echo htmlspecialchars($menu['name']); ?>"
                    >
                </div>
                <div class="detail-box">
                    <h5><?php echo htmlspecialchars($menu['name']); ?></h5>
                    <p>
                    <?php echo htmlspecialchars($menu['description'] ?? '');?>
                    </p>
                    <div class="options">
                    <h6>Rp<?php echo $harga; ?></h6>
                    <div class="quantity-selector">
                      <button onclick = "updateQuantity('<?php echo $id_unik; ?>', -1)">-</button>
                      <input type = "number" id = "quantity_<?php echo $id_unik; ?>" value = "0" min = "0" max = "10" readonly />
                      <button onclick = "updateQuantity('<?php echo $id_unik; ?>', 1)">+</button>

                      <!-- <button class="quantity-btn" id="decrease_tea" onclick="updateQuantity('tea', -1)">-</button>
                      <input type="number" id="quantity_tea" value="1" min="1" max="10" readonly />
                      <button class="quantity-btn" id="increase_tea" onclick="updateQuantity('tea', 1)">+</button> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-sm-6 col-lg-4 all coffe">
            <div class="box">
              <div>
                <div class="img-box">
                  <img src="images/coffe.png" alt="">
                </div>
                <div class="detail-box">
                  <h5>Delicious coffee</h5>
                  <p>Veniam debitis quaerat officiis quasi cupiditate quo, quisquam velit, magnam voluptatem repellendus sed eaque</p>
                  <div class="options">
                    <h6>$15</h6>
                    <div class="quantity-selector">
                      <button class="quantity-btn" id="decrease_coffee" onclick="updateQuantity('coffee', -1)">-</button>
                      <input type="number" id="quantity_coffee" value="1" min="1" max="10" readonly />
                      <button class="quantity-btn" id="increase_coffee" onclick="updateQuantity('coffee', 1)">+</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 all pastry">
            <div class="box">
              <div>
                <div class="img-box">
                  <img src="images/pastry.png" alt="">
                </div>
                <div class="detail-box">
                  <h5>Delicious pastry</h5>
                  <p>Veniam debitis quaerat officiis quasi cupiditate quo, quisquam velit, magnam voluptatem repellendus sed eaque</p>
                  <div class="options">
                    <h6>$18</h6>
                    <div class="quantity-selector">
                      <button class="quantity-btn" id="decrease_pastry" onclick="updateQuantity('pastry', -1)">-</button>
                      <input type="number" id="quantity_pastry" value="1" min="1" max="10" readonly />
                      <button class="quantity-btn" id="increase_pastry" onclick="updateQuantity('pastry', 1)">+</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <?php } ?>
        </div>
      </div>
      <div class="btn-box">
        <a href="payment.php">
          Order & Pay Now
        </a>
      </div>
    </div>
  </section>

  <!-- end food section -->

  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <div class="row">
        
        <!-- Contact Us -->
        <div class="col-md-4 footer-col">
          <div class="footer_contact">
            <h4>Contact Us</h4>
            <div class="contact_link_box">
              <a href="https://maps.google.com" target="_blank">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>Jl. Kopi No. 45, Jakarta Selatan</span>
              </a>
              <a href="tel:+621234567890">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>+62 123-4567-890</span>
              </a>
              <a href="mailto:contact@blackbeans.com">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>contact@blackbeans.com</span>
              </a>
            </div>
          </div>
        </div>
        
        <!-- About -->
        <div class="col-md-4 footer-col">
          <div class="footer_detail">
            <a href="#" class="footer-logo">
              Black Beans
            </a>
            <p>
              Serving the finest coffee since 2020. Freshly brewed, passionately served, and loved by coffee enthusiasts across the city.
            </p>
            <div class="footer_social">
              <a href="https://facebook.com/blackbeans" target="_blank">
                <i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
              <a href="https://twitter.com/blackbeans" target="_blank">
                <i class="fa fa-twitter" aria-hidden="true"></i>
              </a>
              <a href="https://linkedin.com/company/blackbeans" target="_blank">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
              </a>
              <a href="https://instagram.com/blackbeans" target="_blank">
                <i class="fa fa-instagram" aria-hidden="true"></i>
              </a>
              <a href="https://youtube.com/c/blackbeans" target="_blank">
                <i class="fa fa-youtube" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Opening Hours -->
        <div class="col-md-4 footer-col">
          <div class="footer_contact">
            <h4>Opening Hours</h4>
            <p>Monday to Friday: 8 AM - 8 PM</p>
            <p>Saturday: 9 AM - 9 PM</p>
            <p>Sunday: Closed</p>
          </div>
        </div>
        
      </div>
    </div>
  </footer>

  <!-- end footer section -->
  
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Owl Carousel JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- Nice Select JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
  <!-- Custom JS -->
  <script src="js/script.js"></script>

  !-- isotope js -->
<script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
  <script>
    // Update quantity dynamically
    function updateQuantity(item, change) {
      const quantityInput = document.getElementById(`quantity_${item}`);
      let quantity = parseInt(quantityInput.value);
      quantity += change;
      if (quantity >= 0 && quantity <= 10) {
        quantityInput.value = quantity;
      }
    }
  </script>
  <script>
  $(document).ready(function () {
    var $grid = $('.grid').isotope({
      itemSelector: '.all',
      layoutMode: 'fitRows'
    });

    $('.filters_menu li').click(function () {
      $('.filters_menu li').removeClass('active');
      $(this).addClass('active');

      var selector = $(this).attr('data-filter');
      $grid.isotope({ filter: selector });
      return false;
    });
  });
  </script>

</body>

</html>