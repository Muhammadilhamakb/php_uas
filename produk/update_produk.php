<?php
header("Access-Control-Allow-Origin: *"); // Mengizinkan semua origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json'); // Pastikan ini adalah format JSON

// Koneksi ke database
$connection = new mysqli("sql12.freesqldatabase.com", "sql12755847", "aNgHzbv98T", "sql12755847");

// Periksa koneksi database
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Menginisialisasi variabel upload gambar
$uploadOk = 1;
$gambar_url = null; // Default null jika tidak ada gambar

// Periksa apakah gambar dikirim sebagai base64
if (isset($_POST['gambar']) && !empty($_POST['gambar'])) {
    $base64Image = $_POST['gambar'];

    // Memeriksa apakah input base64 valid
    if (preg_match('/^data:image\/(png|jpg|jpeg);base64,/', $base64Image)) {
        $image = explode(',', $base64Image)[1]; // Ambil bagian setelah 'data:image/png;base64,'

        $gambar = uniqid() . '.png'; // Atur ekstensi sesuai kebutuhan
        $target_dir = "images/"; // Folder lokal untuk menyimpan gambar
        $target_file = $target_dir . basename($gambar);

        // Decode base64 dan simpan ke file
        if (file_put_contents($target_file, base64_decode($image))) {
            $gambar_url = $gambar; // Simpan hanya nama file gambar
        } else {
            echo json_encode(['message' => 'Gagal mengupload file']);
            $uploadOk = 0;
        }
    } else {
        echo json_encode(['message' => 'Format gambar tidak valid']);
        $uploadOk = 0;
    }
}

// Mengambil data dari form
$kd_brg = isset($_POST['kd_brg']) ? $connection->real_escape_string($_POST['kd_brg']) : null; // Sanitasi input
$nm_brg = isset($_POST['nm_brg']) ? $connection->real_escape_string($_POST['nm_brg']) : null; // Sanitasi input
$satuan = isset($_POST['satuan']) ? $connection->real_escape_string($_POST['satuan']) : null; // Sanitasi input
$harga = isset($_POST['harga']) ? $connection->real_escape_string($_POST['harga']) : null; // Sanitasi input
$harga_beli = isset($_POST['harga_beli']) ? $connection->real_escape_string($_POST['harga_beli']) : null; // Sanitasi input
$stok = isset($_POST['stok']) ? $connection->real_escape_string($_POST['stok']) : null; // Sanitasi input
$min_stok = isset($_POST['stok_min']) ? $connection->real_escape_string($_POST['stok_min']) : null; // Sanitasi input

// Pastikan semua data tersedia kecuali gambar
if (!empty($kd_brg) && !empty($nm_brg) && !empty($satuan) && !empty($harga) && !empty($harga_beli) && !empty($stok) && !empty($min_stok)) {
    // Update data barang
    $query = "UPDATE barang SET
    nm_brg = '$nm_brg',
    satuan = '$satuan',
    harga = '$harga',
    harga_beli = '$harga_beli',
    stok = '$stok',
    stok_min = '$min_stok'";

    // Tambahkan gambar jika berhasil diupload
    if ($gambar_url !== null) {
        $query .= ", gambar = '$gambar_url'";
    }

    // Menambahkan kondisi WHERE berdasarkan kd_brg
    // Menambahkan kondisi WHERE berdasarkan kd_brg
    $query .= " WHERE kd_brg = '$kd_brg'";

    // Eksekusi query
    if ($connection->query($query) === TRUE) {
        echo json_encode(['message' => 'Data berhasil diperbarui']);
    } else {
        echo json_encode(['message' => 'Gagal memperbarui data: ' . $connection->error]);
    }
} else {
    echo json_encode(['message' => 'Semua data harus diisi']);
}

// Tutup koneksi
$connection->close();
