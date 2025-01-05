<?php
header("Access-Control-Allow-Origin: *"); // Mengizinkan semua origin, atau ganti dengan localhost saja
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// Jika kredensial diperlukan



$connection = new mysqli("sql12.freesqldatabase.com", "sql12755847", "aNgHzbv98T", "sql12755847");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Mengambil data barang dari database
$data = mysqli_query($connection, "SELECT * FROM produk");

if ($data) {
    $dataArray = mysqli_fetch_all($data, MYSQLI_ASSOC);

    // Menambahkan URL gambar yang lengkap


    // Memodifikasi setiap data barang untuk menambahkan URL gambar yang lengkap
    foreach ($dataArray as &$produk) {
        // Pastikan kolom gambar mengandung nama gambar yang benar
        $produk['gambar'] = "http://192.168.18.19/uas/produk/images/" . urlencode($produk['gambar']);
    }

    // Mengirimkan data sebagai JSON
    echo json_encode($dataArray);
} else {
    echo json_encode([
        'message' => 'No data found'
    ]);
}

// Menutup koneksi ke database
$connection->close();
