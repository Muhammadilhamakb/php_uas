<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Koneksi ke database
$connection = new mysqli("sql12.freesqldatabase.com", "sql12755847", "aNgHzbv98T", "sql12755847");

// Mengambil data dari form
$email = $_POST['email'];
$password = $_POST['password'];

// Query untuk mencari user berdasarkan username
$query = "SELECT * FROM user WHERE email = '$email'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        echo json_encode([
            'message' => 'Login berhasil',
            'username' => $user['username'], // Kirimkan username secara eksplisit
            'user' => $user,

        ]);
    } else {
        echo json_encode([
            'message' => 'Password salah'
        ]);
    }
} else {
    echo json_encode([
        'message' => 'email anda salah!'
    ]);
}
