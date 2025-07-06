<?php
    include ('config.php');

    function readMenu()
    {
        global $conn;
    
        $query = "SELECT m.item_id, m.name, m.price, m.description, m.image, c.category_name
                  FROM menu_items m
                  JOIN categories c ON m.category_id = c.category_id
                  ORDER BY m.item_id ASC";
        $result = mysqli_query($conn, $query);
    
        return $result;
    }    
    
    function readKategori()
    {
        global $conn;

        $query = "SELECT * FROM categories";
        $result = mysqli_query($conn, $query);

        return $result;
    }

    function addMenu($data, $file)
    {
        global $conn;
    
        $namaFoto = $file['image']['name'];
        $tempNamaFoto = $file['image']['tmp_name'];
        $direktori = 'images/' . $namaFoto;
    
        $isMoved = move_uploaded_file($tempNamaFoto, $direktori);
        if (!$isMoved) {
            $namaFoto = 'default.png';
        }
    
        $name = htmlspecialchars($data['name']);
        $description = htmlspecialchars($data['description']);
        $price = $data['price'];
        $category_id = $data['category_id'];
    
        $query = "INSERT INTO menu_items (name, price, description, category_id, image)
                  VALUES ('$name', '$price', '$description', '$category_id', '$namaFoto')";
    
        $result = mysqli_query($conn, $query);
    
        $isSucceed = mysqli_affected_rows($conn);
    
        return $isSucceed;
    }    
    
    function editMenu($data, $file)
    {
        global $conn;

        $id = $data['item_id'];
        $name = htmlspecialchars($data['name']);
        $description = htmlspecialchars($data['description']);
        $price = $data['price'];
        $category_id = $data['category_id'];

        // Cek apakah user upload gambar baru
        if ($file['image']['name'] != '') {
            // Ada gambar baru
            $namaFoto = $file['image']['name'];
            $tempNamaFoto = $file['image']['tmp_name'];
            $direktori = 'images/' . $namaFoto;

            $isMoved = move_uploaded_file($tempNamaFoto, $direktori);
            if (!$isMoved) {
                $namaFoto = 'default.png';
            }

            // Query update dengan gambar baru
            $query = "UPDATE menu_items 
                    SET name='$name', price='$price', description='$description', category_id='$category_id', image='$namaFoto' 
                    WHERE item_id='$id'";
        } else {
            // Tidak ada gambar baru
            $query = "UPDATE menu_items 
                    SET name='$name', price='$price', description='$description', category_id='$category_id' 
                    WHERE item_id='$id'";
        }

        $result = mysqli_query($conn, $query);
        $isSucceed = mysqli_affected_rows($conn);

        return $isSucceed;
    }

    function deleteMenu($id)
    {
        global $conn;

        // Cari dulu nama file gambarnya
        $querySelect = "SELECT image FROM menu_items WHERE item_id = '$id'";
        $resultSelect = mysqli_query($conn, $querySelect);
        $menu = mysqli_fetch_assoc($resultSelect);

        if ($menu) {
            $namaFoto = $menu['image'];

            // Hapus gambar di folder images/
            if (file_exists('images/' . $namaFoto) && $namaFoto != 'default.png') {
                unlink('images/' . $namaFoto);
            }

            // Baru hapus data dari database
            $queryDelete = "DELETE FROM menu_items WHERE item_id = '$id'";
            mysqli_query($conn, $queryDelete);

            return mysqli_affected_rows($conn);
        } else {
            return 0; // Kalau ID tidak ditemukan
        }
    }

    function addApplicant($data, $file)
    {
        global $conn;
    
        $namaFoto = $file['photo']['name'];
        $tempNamaFoto = $file['photo']['tmp_name'];
        $direktori = 'images/' . $namaFoto;
    
        $isMoved = move_uploaded_file($tempNamaFoto, $direktori);
        if (!$isMoved) {
            $namaFoto = 'default.png';
        }
    
        $name = htmlspecialchars($data['name']);
        $contact = htmlspecialchars($data['contact']);
        $street = htmlspecialchars($data['street']);
        $province = htmlspecialchars($data['province']);
        $city = htmlspecialchars($data['city']);
        $district = htmlspecialchars($data['district']);
        $subdistrict = htmlspecialchars($data['subdistrict']);
        $position = $data['position_applied'];
    
        $query = "INSERT INTO applicant 
                  VALUES ('', '$name', '$contact', '$street', '$province', '$city', '$district', '$subdistrict', '$position', '$namaFoto')";
    
        $result = mysqli_query($conn, $query);
    
        $isSucceed = mysqli_affected_rows($conn);
    
        return $isSucceed;
    }    

    function addCrew($data, $file)
    {
        global $conn;
    
        $namaFoto = $file['photo']['name'];
        $tempNamaFoto = $file['photo']['tmp_name'];
        $direktori = 'images/' . $namaFoto;
    
        $isMoved = move_uploaded_file($tempNamaFoto, $direktori);
        if (!$isMoved) {
            $namaFoto = 'default.png';
        }
    
        $id_crew = htmlspecialchars($data['employee_id']);
        $name = htmlspecialchars($data['name']);
        $position = htmlspecialchars($data['position']);
        $hire_date = $data['hire_date'];
        $shift_id = $data['shift_id'];
    
        $query = "INSERT INTO employees 
                  VALUES ('', '$name', '$position', '$hire_date', '$shift_id', '$namaFoto')";
    
        $result = mysqli_query($conn, $query);
    
        $isSucceed = mysqli_affected_rows($conn);
    
        return $isSucceed;
    }    
    
    function editCrew($data, $file)
    {
        global $conn;

        $id_crew = htmlspecialchars($data['employee_id']);
        $name = htmlspecialchars($data['name']);
        $position = htmlspecialchars($data['position']);
        $hire_date = $data['hire_date'];
        $shift_id = $data['shift_id'];

        // Cek apakah user upload gambar baru
        if ($file['photo']['name'] != '') {
            // Ada gambar baru
            $namaFoto = $file['photo']['name'];
            $tempNamaFoto = $file['photo']['tmp_name'];
            $direktori = 'images/' . $namaFoto;

            $isMoved = move_uploaded_file($tempNamaFoto, $direktori);
            if (!$isMoved) {
                $namaFoto = 'default.png';
            }

            // Query update dengan gambar baru
            $query = "UPDATE employees 
                    SET name='$name', position='$position', hire_date='$hire_date', shift_id='$shift_id', photo='$namaFoto' 
                    WHERE employee_id='$id_crew'";
        } else {
            // Tidak ada gambar baru
            $query = "UPDATE employees 
                    SET name='$name', position='$position', hire_date='$hire_date', shift_id='$shift_id' 
                    WHERE employee_id='$id_crew'";
        }

        $result = mysqli_query($conn, $query);
        $isSucceed = mysqli_affected_rows($conn);

        return $isSucceed;
    }

    function deleteCrew($id_crew)
    {
        global $conn;

        // Cari dulu nama file gambarnya
        $querySelect = "SELECT photo FROM employees WHERE employee_id = '$id_crew'";
        $resultSelect = mysqli_query($conn, $querySelect);
        $menu = mysqli_fetch_assoc($resultSelect);

        if ($menu) {
            $namaFoto = $menu['photo'];

            // Hapus gambar di folder images/
            if (file_exists('images/' . $namaFoto) && $namaFoto != 'default.png') {
                unlink('images/' . $namaFoto);
            }

            // Baru hapus data dari database
            $queryDelete = "DELETE FROM employees WHERE employee_id = '$id_crew'";
            mysqli_query($conn, $queryDelete);

            return mysqli_affected_rows($conn);
        } else {
            return 0; // Kalau ID tidak ditemukan
        }
    }

    function addPromo($data, $file)
    {
        global $conn;
    
        $namaFoto = $file['image']['name'];
        $tempNamaFoto = $file['image']['tmp_name'];
        $direktori = 'images/' . $namaFoto;
    
        $isMoved = move_uploaded_file($tempNamaFoto, $direktori);
        if (!$isMoved) {
            $namaFoto = 'default.png';
        }
    
        $id_crew = htmlspecialchars($data['promo_id']);
        $description = htmlspecialchars($data['description']);
        $discount = $data['discount_percent'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
    
        $query = "INSERT INTO promotions 
                  VALUES ('', '$description', '$discount', '$start_date', '$end_date', '$namaFoto')";
    
        $result = mysqli_query($conn, $query);
    
        $isSucceed = mysqli_affected_rows($conn);
    
        return $isSucceed;
    }    
    
    function editPromo($data, $file)
    {
        global $conn;

        $id_promo = htmlspecialchars($data['promo_id']);
        $description = htmlspecialchars($data['description']);
        $discount = $data['discount_percent'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        // Cek apakah user upload gambar baru
        if ($file['image']['name'] != '') {
            // Ada gambar baru
            $namaFoto = $file['image']['name'];
            $tempNamaFoto = $file['image']['tmp_name'];
            $direktori = 'images/' . $namaFoto;

            $isMoved = move_uploaded_file($tempNamaFoto, $direktori);
            if (!$isMoved) {
                $namaFoto = 'default.png';
            }

            // Query update dengan gambar baru
            $query = "UPDATE promotions 
                    SET description='$description', discount_percent='$discount', start_date='$start_date', end_date='$end_date', image='$namaFoto' 
                    WHERE promo_id='$id_promo'";
        } else {
            // Tidak ada gambar baru
            $query = "UPDATE promotions 
                    SET description='$description', discount_percent='$discount', start_date='$start_date', end_date='$end_date'
                    WHERE promo_id='$id_promo'";
        }

        $result = mysqli_query($conn, $query);
        $isSucceed = mysqli_affected_rows($conn);

        return $isSucceed;
    }

    function deletePromo($id_promo)
    {
        global $conn;

        // Cari dulu nama file gambarnya
        $querySelect = "SELECT image FROM promotions WHERE promo_id = '$id_promo'";
        $resultSelect = mysqli_query($conn, $querySelect);
        $promo = mysqli_fetch_assoc($resultSelect);

        if ($promo) {
            $namaFoto = $promo['image'];

            // Hapus gambar di folder images/
            if (file_exists('images/' . $namaFoto) && $namaFoto != 'default.png') {
                unlink('images/' . $namaFoto);
            }

            // Baru hapus data dari database
            $queryDelete = "DELETE FROM promotions WHERE promo_id = '$id_promo'";
            mysqli_query($conn, $queryDelete);

            return mysqli_affected_rows($conn);
        } else {
            return 0; // Kalau ID tidak ditemukan
        }
    }

    function readPromotion(): bool|mysqli_result
    {
        global $conn;

        $query = "SELECT * FROM promotions";
        $result = mysqli_query($conn, $query);

        return $result;
    }

    function readCrew(): bool|mysqli_result
    {
        global $conn;

        // $query = "SELECT e.name, e.position, e.hire_date, e.photo, s.shift_name
        //     FROM employees e
        //     JOIN shifts s ON e.shift_id = s.shift_id";
        $query = "SELECT * FROM employees ORDER BY employee_id ASC";
        // $query = "SELECT * FROM employees ORDER BY hire_date DESC";
        $result = mysqli_query($conn, $query);

        return $result;
    }

    function readShift(): bool|mysqli_result
    {
        global $conn;

        $query = "SELECT * FROM shifts";
        $result = mysqli_query($conn, $query);

        return $result;
    }

    function readOrder(): bool|mysqli_result
    {
        global $conn;

        $query = "SELECT o.order_id, o.order_date, e.name, p.description, o.total_amount
                FROM orders o
                LEFT JOIN employees e ON o.employee_id = e.employee_id LEFT JOIN promotions p ON o.promo_id = p.promo_id
                ORDER BY o.order_id ASC";
        $result = mysqli_query($conn, $query);

        return $result;
    }

    function getShiftName($shiftId, $shiftList) {
        foreach ($shiftList as $shift) {
            if ($shift['shift_id'] == $shiftId) {
                return $shift['shift_name'];
            }
        }
        return 'Unknown Shift';
    }

    function getOrderById($id_order){
        global $conn;
    
        $query = "SELECT o.*, p.discount_percent
                  FROM orders o
                  LEFT JOIN promotions p ON o.promo_id = p.promo_id
                  WHERE o.order_id = $id_order";
    
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }
  
    function getOrderItems($id_order) {
        global $conn;

        $query = "SELECT m.name AS menu_name, m.price, oi.quantity
                    FROM order_items oi
                    JOIN menu_items m ON oi.item_id = m.item_id
                    WHERE oi.order_id = $id_order";
                    
        $result = mysqli_query($conn, $query);

        $items = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }
        }

        return $items;
    }

    function readMenuwithProcedure(){
        global $conn;
        $query = "CALL getMenu()";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function readApplicants(){
        // $Applicants = [];
        // $result = mysqli_query($conn, "SELECT * FROM recruitment");

        // while($row = mysqli_fetch_assoc($result)){
        //     $full_address = $row['street'] . ", " . $row['subdistrict'] . ", " . $row['district'] . ", " . 
        //     $row['city'] . ", " . $row['province'];
        //     $Applicants[] = [
        //         'name' => $row['name'],
        //         'contact' => $row['contact'],
        //         'full_address' => $full_address,
        //         'phone' => $row['phone']
        //     ];
        // }
        // return $Applicants;
        global $conn;

        $query = "SELECT * FROM applicant";
        $result = mysqli_query($conn, $query);

        return $result;
    }

    function readApplicantWithLocation(): bool|mysqli_result
    {
        global $conn;

        $query = "SELECT 
            a.*, 
            sigma.provinces.name AS province_name, 
            sigma.cities.name AS city_name
            FROM applicant a
            LEFT JOIN sigma.provinces ON a.province = sigma.provinces.id
            LEFT JOIN sigma.cities ON a.city = sigma.cities.id
            ";


        return mysqli_query($conn, $query);
    }

?>