<?php
header("Access-Control-Allow-Origin: *"); // Mengizinkan semua origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Koneksi ke database
$connection = new mysqli("sql12.freesqldatabase.com", "sql12755847", "aNgHzbv98T", "sql12755847");

// Menangani jika gambar dikirimkan dalam format base64 (untuk Web)
if (isset($_POST['gambar']) && !empty($_POST['gambar'])) {
    // Mendapatkan data base64
    $gambar_base64 = $_POST['gambar'];
    $imageData = base64_decode($gambar_base64);
    $imageFileType = "png"; // Menggunakan format png untuk base64
    $gambar = uniqid() . '.' . $imageFileType;
    $target_dir = "images/";  // Pastikan folder 'images' ada di direktori ini
    $target_file = $target_dir . basename($gambar);

    // Menyimpan file gambar
    if (file_put_contents($target_file, $imageData)) {
        echo json_encode(['message' => 'Gambar berhasil di-upload.']);
    } else {
        echo json_encode(['message' => 'Gagal meng-upload gambar.']);
        exit;
    }
} else {
    echo json_encode(['message' => 'Tidak ada gambar yang dikirim atau gagal meng-upload gambar.']);
    exit;
}

// Mengambil data dari form
$kd_brg = $_POST['kd_brg'];
$nm_brg = $_POST['nm_brg'];
$satuan = $_POST['satuan'];
$harga = $_POST['harga'];
$harga_beli = $_POST['harga_beli'];
$stok = $_POST['stok'];
$min_stok = $_POST['stok_min'];

// Pastikan variabel $gambar terdefinisi
if (isset($gambar)) {
    // Menyimpan URL gambar di database
    $gambar_url = "http://192.168.18.19/Latihanpraktikum11/images/" . $gambar;

    // Menyimpan data barang ke database
    $result = mysqli_query($connection, "INSERT INTO barang (kd_brg, nm_brg, satuan, harga, harga_beli, stok, stok_min, gambar) 
                                        VALUES ('$kd_brg', '$nm_brg', '$satuan', '$harga', '$harga_beli', '$stok', '$min_stok', '$gambar')");
    if ($result) {
        echo json_encode([
            'message' => 'Data berhasil dimasukkan'
        ]);
    } else {
        echo json_encode([
            'message' => 'Gagal memasukkan data'
        ]);
    }
} else {
    echo json_encode([
        'message' => 'Gambar tidak valid atau tidak diupload'
    ]);
}
