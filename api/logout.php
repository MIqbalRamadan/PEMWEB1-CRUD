<?php
header("Access-Control-Allow-Origin: *");
include 'koneksi.php';

$session_token = $_POST['session_token'];

if (isset($session_token)) {
    $session_token = $session_token;
    // Hapus token sesi dari database atau lakukan operasi logout sesuai kebutuhan
    $updateStatement = $database_connection->prepare("UPDATE user SET session_token = NULL WHERE session_token = ?");
    $updateStatement->execute([$session_token]);

    // Periksa apakah token sesi berhasil dihapus
    $affectedRows = $updateStatement->rowCount();
    if ($affectedRows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Logout berhasil']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Token sesi tidak valid']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>