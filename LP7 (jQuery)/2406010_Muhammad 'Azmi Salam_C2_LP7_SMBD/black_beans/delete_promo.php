<?php
    include('function.php'); 

    if (!isset($_GET['id'])) {
        echo "<script>
                alert('No promotions selected to delete!');
                window.location.href = 'admin_page.php#promosi-section';
            </script>";
        exit;
    }

    $id = $_GET['id'];

    // Panggil fungsi delete
    $isDeleteSucceed = deletePromo($id);

    if ($isDeleteSucceed > 0) {
        echo "<script>
                alert('Promo berhasil dihapus!');
                window.location.href = 'admin_page.php#promosi-section';
            </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus promo!');
                window.location.href = 'admin_page.php#promosi-section';
            </script>";
    }
?>