<?php
    include('function.php'); 

    if (!isset($_GET['id'])) {
        echo "<script>
                alert('No crew selected to delete!');
                window.location.href = 'admin_page.php#crew-section';
            </script>";
        exit;
    }

    $id = $_GET['id'];

    // Panggil fungsi delete
    $isDeleteSucceed = deleteCrew($id);

    if ($isDeleteSucceed > 0) {
        echo "<script>
                alert('Pegawai berhasil dihapus!');
                window.location.href = 'admin_page.php#crew-section';
            </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus Pegawai!');
                window.location.href = 'admin_page.php#crew-section';
            </script>";
    }
?>