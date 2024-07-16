<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="icon.png" type="image/x-icon"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Cek Sensor</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <link rel="stylesheet" href="style.css">

</head>
<body class="mt-2 mb-5">
    <div class="container">
        <a href="index.php" class="btn btn-info btn-md"><b>GRAFIK</b></a>
        <a href="index_data.php" class="btn btn btn-warning btn-md"><b>TABEL</b></a>
        <hr>
        <table class=" dt-responsive nowrap" style="width:100%">
            <tbody>
                <div class="row mt-4">
                    <tr>
                        <td align="center"><p class="h1 font-weight-bold">Detak Jantung</p></td>
                        <td align="center"><p class="h1 font-weight-bold">Suhu Tubuh</p></td>
                    </tr>
                </div>
                <tr>
                    <td align="center"><div id="detak" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="--value: 0;" data-value="0"></div></td>
                    <td align="center"><div id="suhu" role="progressbar1" aria-valuemin="0" aria-valuemax="100" style="--value: 0;" data-value="0"></div></td>
                </tr>
            </tbody>
        </table>
        <!-- card -->
        <div class="row mt-4">
            <div class="col-6">
                <div class="card crd-brd">
                    <div class="card-body">
                        <h3 class="text-center" id="detak-status">Detak Normal</h3>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card crd-brd">
                    <div class="card-body">
                        <h3 class="text-center" id="suhu-status">Suhu Normal</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fetchData() {
            $.ajax({
                url: 'fetch_data.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#detak').css('--value', data.detak).attr('data-value', data.detak.toFixed(1));
                    $('#suhu').css('--value', data.suhu).attr('data-value', data.suhu.toFixed(1));

                    let suhuStatus = '';
                    if (data.suhu > 37.7) {
                        suhuStatus = 'Suhu Tinggi';
                    } else if (data.suhu >= 36 && data.suhu <= 37.6) {
                        suhuStatus = 'Suhu Normal';
                    } else {
                        suhuStatus = 'Suhu Rendah';
                    }
                    $('#suhu-status').text(suhuStatus);

                    let detakStatus = '';
                    if (data.detak > 100.1) {
                        detakStatus = "Detak Tinggi";
                    } else if (data.detak >= 60 && data.detak <= 100) {
                        detakStatus = "Detak Normal";
                    } else {
                        detakStatus = "Detak Rendah";
                    }
                    $('#detak-status').text(detakStatus);
                },
            });
        }

        $(document).ready(function() {
            fetchData(); // Initial fetch
            setInterval(fetchData, 3000); // Fetch every 3 seconds
        });
    </script>
</body>
</html>
