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

// Mengambil data dari form
$nama = isset($_POST['nama']) ? $connection->real_escape_string($_POST['nama']) : null; // Sanitasi input
$email = isset($_POST['email']) ? $connection->real_escape_string($_POST['email']) : null; // Sanitasi input
$username = isset($_POST['username']) ? $connection->real_escape_string($_POST['username']) : null; // Sanitasi input
$password = isset($_POST['password']) ? $connection->real_escape_string($_POST['password']) : null; // Sanitasi input

// Pastikan semua data tersedia kecuali gambar
if (!empty($nama) && !empty($email) && !empty($username) && !empty($password)) {
    // Update data barang
    $query = "UPDATE user SET
    nama = '$nama',
    email = '$email',
    username = '$username',
    password = '$password'";

    $query .= " WHERE id = '$id'";

    // Eksekusi query
    if ($connection->query($query) === TRUE) {
        echo json_encode(['message' => 'Data berhasil diperbarui', 'username' => $user['username'],]);
    } else {
        echo json_encode(['message' => 'Gagal memperbarui data: ' . $connection->error]);
    }
} else {
    echo json_encode(['message' => 'Semua data harus diisi']);
}

// Tutup koneksi
$connection->close();
