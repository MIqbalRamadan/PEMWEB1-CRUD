<?php
$database_hostname = 'localhost';
$database_username = 'id21695373_user_kakasualanstore123';
$database_password = 'Kakasualanstore`123';
$database_name = 'id21695373_db_kaksualanstore123';
$database_port = 3306;

try {
    $database_connection = new PDO("mysql:host=$database_hostname;port=$database_port;dbname=$database_name",
    $database_username, $database_password);
    // $cek = "Koneksi Berhasil";
    // echo $cek;
} catch (PDOException $x) {
    die($x->getMessage());
}
?>