<?php
    include ('function.php');
    $listShift = readShift();
    if (isset($_POST['btn-add'])) {
        $isAddSucceed = addCrew($_POST, $_FILES);
     
        if ($isAddSucceed > 0) {
          echo "<script>
               alert('Pegawai Berhasil Ditambahkan');
               document.location.href = 'admin_page.php#crew-section';
               </script>";
        } else {
          echo "<script>
               alert('Gagal Menambahkan Pegawai!');
               document.location.href = 'admin_page.php#crew-section';
               </script>";
        }
    }
    $listApplicant = readApplicantWithLocation();
    
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
  <title>Add Crew</title>

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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">
      <img src="images/Logo.png" alt="Black Beans" style="height: 80px;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="admin_page.php">Dashboard Admin</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_page.php#menu-section">Managemen Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_page.php#promosi-section">Managemen Promosi</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_page.php#order-section">Managemen Order</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_page.php#crew-section">Managemen Pegawai</a></li>
      </ul>
      <div class="user_option">
        <a href="index.php" class="order_online">Homepage</a>
      </div>
    </div>
  </nav>
  
  <div class="container mt-5">
    <h2 class="text-center">Add New Crew</h2>

    <!-- Form Add Crew -->
    <form action="add_crew.php" method="POST" enctype="multipart/form-data"> 
      <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="useApplicant" onclick="toggleFormSource()">
        <label class="form-check-label" for="useApplicant">Gunakan data dari recruitment</label>
      </div>

      <div id="manualForm">
        <div class="form-group">
          <label for="crew-name">Crew Name</label>
          <input type="text" class="form-control" id="crew-name" name="name" placeholder="Enter Crew Name" required>
        </div>
        <div class="form-group">
          <label for="crew-position">Position</label>
          <input type="text" class="form-control" id="crew-position" name="position" placeholder="Enter Position" required>
        </div>
        <div class="form-group">
          <label for="crew-price">Hire Date</label>
          <input type="date" class="form-control" id="crew-hire_date" name="hire_date" placeholder="Enter Hire Date" required>
        </div>
      </div>

      <div id="applicantSelect" style="display: none;">
        <div class="form-group">
          <label for="applicant-dropdown">Pilih Applicant</label>
          <select class="form-control" id="applicant-dropdown" onchange="fillApplicantData(this)">
            <option value="">-- Pilih Applicant --</option>
            <?php
              $applicantList = [];
              while ($applicant = mysqli_fetch_assoc($listApplicant)) {
                  $applicantList[] = $applicant;
              }

              foreach ($applicantList as $applicant):
                  $fullAddress = $applicant['province_name'] . ', ' . 
                                $applicant['city_name'] . ', ' . 
                                $applicant['district'] . ', ' . 
                                $applicant['subdistrict'] . ', ' . 
                                $applicant['street'];
            ?>
                <option
                    value="<?= htmlspecialchars($applicant['id']) ?>"
                    data-name="<?= htmlspecialchars($applicant['name']) ?>"
                    data-contact="<?= htmlspecialchars($applicant['contact']) ?>"
                    data-address="<?= htmlspecialchars($fullAddress) ?>"
                    data-position="<?= htmlspecialchars($applicant['position_applied']) ?>"
                    data-photo="<?= htmlspecialchars($applicant['photo']) ?>"
                >
                    <?= htmlspecialchars($applicant['name'] . ' - ' . $applicant['position_applied']) ?>
                </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div id="applicant-details" style="display: none;">
          <input type="hidden" name="name" id="hidden-name">
          <input type="hidden" name="position" id="hidden-position">
          <input type="hidden" name="photo_filename" id="hidden-photo">

          <p><strong>Nama:</strong> <span id="detail-name"></span></p>
          <p><strong>Contact:</strong> <span id="detail-contact"></span></p>
          <p><strong>Address:</strong> <span id="detail-address"></span></p>
          <p><strong>Posisi:</strong> <span id="detail-position"></span></p>
          <img id="detail-photo" src="" alt="Foto Pelamar" style="max-width:150px; border-radius:8px; margin-bottom: 15px;">

          <div class="form-group">
            <label>Tanggal Dipekerjakan</label>
            <input type="date" class="form-control" name="hire_date" id="applicant-hire_date" required>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="crew-shift_id">Shift Id</label>
        <select class="form-control" id="crew-shift_id" name="shift_id" required>
          <option value="">-- Select Shift Id --</option>
          <?php foreach ($listShift as $shift): ?>
          <option value="<?= $shift['shift_id'] ?>">
            <?= htmlspecialchars($shift['shift_name']) ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="crew-image">Photo</label>
        <input type="file" class="form-control" id="crew-photo" name="photo">
      </div>

      <button type="submit" name="btn-add" class="btn btn-primary">Add Crew</button>
    </form>

    <div class="text-center mt-3">
      <a href="admin_page.php" class="btn btn-secondary">Back to Admin Page</a>
    </div>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/readApplicant.js"></script>
  <script>
    function toggleFormSource() {
      var useApplicant = document.getElementById("useApplicant");
      var manualForm = document.getElementById("manualForm");
      var applicantSelect = document.getElementById("applicantSelect");
      var crewName = document.getElementById("crew-name");
      var crewPosition = document.getElementById("crew-position");
      var crewHireDate = document.getElementById("crew-hire_date");

      if (useApplicant.checked) {
        manualForm.style.display = "none";
        applicantSelect.style.display = "block";
        crewName.removeAttribute("required");
        crewPosition.removeAttribute("required");
        crewHireDate.removeAttribute("required");
      } else {
        manualForm.style.display = "block";
        applicantSelect.style.display = "none";
        crewName.setAttribute("required", "true");
        crewPosition.setAttribute("required", "true");
        crewHireDate.setAttribute("required", "true");
      }
    }

    function fillApplicantData(selectElement) {
      var selectedOption = selectElement.options[selectElement.selectedIndex];
      document.getElementById("hidden-name").value = selectedOption.getAttribute("data-name");
      document.getElementById("hidden-position").value = selectedOption.getAttribute("data-position");
      document.getElementById("hidden-photo").value = selectedOption.getAttribute("data-photo");

      document.getElementById("detail-name").innerText = selectedOption.getAttribute("data-name");
      document.getElementById("detail-contact").innerText = selectedOption.getAttribute("data-contact");
      document.getElementById("detail-address").innerText = selectedOption.getAttribute("data-address");
      document.getElementById("detail-position").innerText = selectedOption.getAttribute("data-position");
      document.getElementById("detail-photo").src = 'images/' + selectedOption.getAttribute("data-photo");

      document.getElementById("applicant-details").style.display = "block";
    }
  </script>

</body>

</html>
