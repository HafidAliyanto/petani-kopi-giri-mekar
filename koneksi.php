<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_kopi_girimekar";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . mysqli_connect_error()]));
}
?>
