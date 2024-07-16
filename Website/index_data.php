<?php
include 'koneksi.php';
if (isset($_GET['json'])) {
    header('Content-Type: application/json');
    $datasensor = mysqli_query($koneksi, "SELECT * FROM sensor_ultrasonic order by id desc");

    $sensor_data = array();
    while ($d = mysqli_fetch_assoc($datasensor)) {
        $sensor_data[] = $d;
    }

    echo json_encode($sensor_data);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icon.png" type="image/x-icon"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <!--datepicker-->
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css">
    <script src="https://cdn.datatables.net/datetime/1.4.1/js/dataTables.dateTime.min.js"></script>

    <!--responsive-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
    <title>Cek Sensor</title>
</head>

<body class="mt-2 mb-5">
    <div class="container">
        <a href="index.php" class="btn btn-info btn-md"><b>GRAFIK</b></a>
        <a href="index_data.php" class="btn btn btn-warning btn-md"><b>TABEL</b></a>

        <hr>
        <h2 class="text-center"> Tabel Riwayat Sensor</h2>
        <table id="tabel" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead class="text-white bg-success">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Suhu</th>
                    <th>Detak</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data akan diisi melalui AJAX -->
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#tabel').DataTable({
                responsive: true,
                columns: [
                    { data: null },  // for the No column
                    { data: 'tgl' },
                    { data: 'jam' },
                    { data: 'suhu' },
                    { data: 'detak' }
                ],
                columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                }]
            });

            function fetchData() {
                $.ajax({
                    url: 'index_data.php?json=true', // URL to the PHP script
                    method: 'GET',
                    success: function(data) {
                        table.clear().rows.add(data).draw();
                    }
                });
            }

            fetchData(); // Fetch initial data

            setInterval(fetchData, 3000); // Fetch new data every 3 seconds
        });
    </script>
</body>

</html>
