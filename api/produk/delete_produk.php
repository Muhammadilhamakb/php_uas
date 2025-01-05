<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$connection = new mysqli("sql12.freesqldatabase.com", "sql12755847", "aNgHzbv98T", "sql12755847");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$kd_brg = $_POST['kd_brg'];

// Periksa apakah kd_brg ada
if (isset($kd_brg) && !empty($kd_brg)) {
    // Menggunakan prepared statements untuk menghindari SQL Injection
    $stmt = $connection->prepare("DELETE FROM barang WHERE kd_brg = ?");
    $stmt->bind_param("s", $kd_brg); // 's' berarti string (untuk kd_brg)

    if ($stmt->execute()) {
        echo json_encode([
            'message' => 'Data deleted successfully'
        ]);
    } else {
        echo json_encode([
            'message' => 'Failed to delete data'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'message' => 'Kode barang tidak valid'
    ]);
}

$connection->close();
