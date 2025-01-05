<?php
header("Access-Control-Allow-Origin: *"); // Mengizinkan semua origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Koneksi ke database
$connection = new mysqli("sql12.freesqldatabase.com", "sql12755847", "aNgHzbv98T", "sql12755847");


// Mengambil data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];


// Pastikan variabel $gambar terdefinisi
// Hash password sebelum disimpan ke database
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Menyimpan data user ke database
$result = mysqli_query($connection, "INSERT INTO user (nama, email, username, password) 
                                    VALUES ('$nama', '$email', '$username', '$hashed_password')");

if ($result) {
    echo json_encode([
        'message' => 'User berhasil ditambahkan',
    ]);
} else {
    echo json_encode([
        'message' => 'Gagal menambahkan user'
    ]);
}
