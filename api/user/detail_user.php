<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

// Koneksi ke database
$connection = new mysqli("sql12.freesqldatabase.com", "sql12755847", "aNgHzbv98T", "sql12755847");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$username = isset($_GET['username']) ? $connection->real_escape_string($_GET['username']) : null;

if ($username) {
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode([
            'message' => 'User found',
            'username' => $user['username'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'password' => $user['password']
        ]);
    } else {
        echo json_encode(['message' => 'User not found']);
    }
} else {
    echo json_encode(['message' => 'Username is required']);
}

$connection->close();
