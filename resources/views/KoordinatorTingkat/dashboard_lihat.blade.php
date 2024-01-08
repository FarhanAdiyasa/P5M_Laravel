@extends('KoordinatorTingkat.layout.header')

@section('konten')

<main id="main" class="main">

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>


<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "p5m";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$sql = "SELECT nim_mahasiswa, SUM(total_jam_minus) as JamMinusTertinggi FROM P5M GROUP BY nim_mahasiswa ORDER BY JamMinusTertinggi desc LIMIT 5;";
$result = $conn->query($sql);

// Store data in arrays
$categories = array();
$values = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row["nim_mahasiswa"];
        $values[] = $row["JamMinusTertinggi"];
    }
}
// Close connection
$conn->close();
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>  
<section class="section">
      <div class="row">

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Grafik 5 Jam Minus P5M Tertinggi</h5>

              <canvas id="myChart" style="max-height: 400px; display: block; box-sizing: border-box; height: 289px; width: 579px;" width="651" height="325"></canvas>
                <script>
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($categories); ?>,
                        datasets: [{
                        label: 'Jam Minus',
                        data: <?php echo json_encode($values); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                        yAxes: [{
                            ticks: {
                            beginAtZero: true
                            }
                        }]
                        }
                    }
                    });
                </script>
            </div>
          </div>
        </div>


        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Grafik 5 Jam Minus P5M Tertinggi</h5>

              <canvas id="myChart1" style="max-height: 400px; display: block; box-sizing: border-box; height: 289px; width: 579px;" width="651" height="325"></canvas>
                <script>
                    var ctx = document.getElementById('myChart1').getContext('2d');
                    var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: <?php echo json_encode($categories); ?>,
                        datasets: [{
                        label: 'Jam Minus',
                        data: <?php echo json_encode($values); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                        yAxes: [{
                            ticks: {
                            beginAtZero: true
                            }
                        }]
                        }
                    }
                    });
                </script>
            </div>
          </div>
        </div>


        </section>

</main><!-- End #main -->


@endsection