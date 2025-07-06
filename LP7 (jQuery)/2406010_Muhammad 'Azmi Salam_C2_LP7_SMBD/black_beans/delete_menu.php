<?php
    include('function.php'); 

    if (!isset($_GET['id'])) {
        echo "<script>
                alert('No menu selected to delete!');
                window.location.href = 'admin_page.php#menu-section';
            </script>";
        exit;
    }

    $id = $_GET['id'];

    // Panggil fungsi delete
    $isDeleteSucceed = deleteMenu($id);

    if ($isDeleteSucceed > 0) {
        echo "<script>
                alert('Menu berhasil dihapus!');
                window.location.href = 'admin_page.php#menu-section';
            </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus menu!');
                window.location.href = 'admin_page.php#menu-section';
            </script>";
    }
?>