<?php
include 'koneksi.php';

date_default_timezone_set('Asia/Jakarta');
$d = date("Y-m-d");
$t = date("H:i:s");

if ( !empty($_POST['suhu']) && !empty($_POST['detak']) ) {
    $suhu = $_POST['suhu'];
    $detak = $_POST['detak'];
    
    $sql = "INSERT INTO sensor_ultrasonic (tgl, jam, suhu, detak) VALUES ('" . $d . "','" . $t . "','" . $suhu . "','" . $detak . "')";    
    if ($koneksi->query($sql) === TRUE) {
        echo "Data tersimpan";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }

} else {
    echo "Data gagal tersimpan";
}

$koneksi->close();
