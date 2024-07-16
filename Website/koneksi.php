<?php
$servername = "localhost";
$username = "id22072102_ultrasonic_2";
$password = "Kura-kura02";
$dbname = "id22072102_ultrasonic";

$koneksi = mysqli_connect($servername, $username, $password, $dbname);
if (!$koneksi){
    die("Koneksi Gagal :".mysqli_connect_error());
}
?>