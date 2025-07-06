<?php
    // Konfigurasi koneksi database
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "black_beans";

    // Membuat koneksi ke database
    $conn = mysqli_connect($host, $username, $password, $database);

    // if(!$conn){
    //     die("Koneksi dengan database gagal: " . mysqli_connect_error());
    //     } else {
    //     echo 'Sukses koneksi ke database';
    // }
?>