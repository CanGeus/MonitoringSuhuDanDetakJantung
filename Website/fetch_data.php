<?php
include 'koneksi.php';
$datasensor = mysqli_query($koneksi, "SELECT * FROM `sensor_ultrasonic` ORDER BY id DESC LIMIT 1;");
$data = mysqli_fetch_array($datasensor);

// cek nilai array numerik
$detak = is_numeric($data['detak']) ? (float)$data['detak'] : 0;
$suhu = is_numeric($data['suhu']) ? (float)$data['suhu'] : 0;

$response = array(
    'detak' => $detak,
    'suhu' => $suhu
);

echo json_encode($response);
?>
