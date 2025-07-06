<?php
    include ('function.php');
    if (isset($_POST['btn-add'])) {
        $isAddSucceed = addApplicant($_POST, $_FILES);
     
     
        if ($isAddSucceed > 0) {
          echo "<script>
               alert('Applicant Berhasil Ditambahkan');
               document.location.href = 'admin_page.php#applicant-section';
               </script>";
        } else {
          echo "<script>
               alert('Gagal Menambahkan Applicant!');
               document.location.href = 'admin_page.php#applicant-section';
               </script>";
        }
    }
    // $listApplicant = readApplicant();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="">

  <title> Join Black Beans </title>

  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
  
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  

</head>
<body>
  <header class="header_section bg-dark">
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
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php#">Home</a>
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
            <li class="nav-item active">
              <a class="nav-link" href="recruitment.php">Join Us <span class="sr-only">(current)</span></a>
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

  <section>
    <div class="container mt-5 mb-5">
      <h1 class="text-center">Join Our Team</h1>
      <p class="text-center">We are always looking for passionate individuals to join our team. If you love coffee and have a passion for customer service, we want to hear from you!</p>
      <div class="row my-4">
        <form action="recruitment.php"
        method="POST" enctype="multipart/form-data" class="w-100">

          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" required>
          </div>
          <div class="form-group">
            <label for="street">Street</label>
            <input type="text" class="form-control" id="street" name="street" required>
          </div>
          <div class="form-group">
            <label for="province">Province</label>
            <select class="form-control" id="province" name="province" required></select>
          </div>
          <div class="form-group">
            <label for="city">Region</label>
            <select class="form-control" id="city" name="city" required></select>
          </div>
          <div class="form-group">
            <label for="district">District</label>
            <input type="text" class="form-control" id="district" name="district" required>
          </div>
          <div class="form-group">
            <label for="subdistrict">Subdistrict</label>
            <input type="text" class="form-control" id="subdistrict" name="subdistrict" required>
          </div>
          <div class="form-group">
            <label for="phone">Position applied</label>
            <input type="text" class="form-control" id="position_applied" name="position_applied" required>
          </div>
          <div class="form-group">
            <label for="photo">Applicant Photo</label>
            <input type="file" class="form-control-file" id="photo" name="photo" required>
          </div>
          <button type="submit" name="btn-add"class="btn btn-primary">Submit Application</button>
        </form>
      </div>
    </div>
  </section>

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
              <a href="https://pinterest.com/blackbeans" target="_blank">
                <i class="fa fa-pinterest" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Opening Hours -->
        <div class="col-md-4 footer-col">
          <h4>Opening Hours</h4>
          <p>Monday - Sunday</p>
          <p>08:00 AM - 11:00 PM</p>
        </div>

      </div>

      <!-- Footer bottom info -->
      <div class="footer-info">
        <p>
          &copy; <span id="displayYear"></span> Black Beans Coffee House. All Rights Reserved.
        </p>
      </div>

    </div>
  </footer>
  <script src="js/form.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>