<?php
header("Access-Control-Allow-Origin: *"); // Mengizinkan semua origin, atau ganti dengan localhost saja
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Koneksi ke database
$connection = new mysqli("sql12.freesqldatabase.com", "sql12755847", "aNgHzbv98T", "sql12755847");

// Periksa apakah ada parameter kd_brg
if (isset($_GET['kd_brg'])) {
    $kd_brg = $connection->real_escape_string($_GET['kd_brg']); // Menghindari SQL injection

    // Query untuk mendapatkan data berdasarkan kd_brg
    $data = mysqli_query($connection, "SELECT * FROM barang WHERE kd_brg = '$kd_brg'");

    // Jika data ditemukan
    if ($data) {
        $data = mysqli_fetch_array($data, MYSQLI_ASSOC);
        echo json_encode($data);
    } else {
        echo json_encode(["message" => "Data tidak ditemukan"]);
    }
} else {
    echo json_encode(["message" => "kd_brg parameter tidak ditemukan"]);
}
