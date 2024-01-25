@php
    use Carbon\Carbon;
@endphp

@php
// Function to generate a random color
function getRandomColor() {
    $letters = '0123456789ABCDEF';
    $color = '#';
    for ($i = 0; $i < 6; $i++) {
        $color .= $letters[rand(0, 15)];
    }
    return $color;
}

// Convert the result array to a collection
$resultCollection = collect($result);

// Generate an array of random background colors for each data point
$backgroundColors = array_map(function () {
    return getRandomColor();
}, range(1, count($resultCollection)));
@endphp

@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Import Absensi Terakhir</h5>
                                <p>{{ $latestWaktu }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Rekap Pelanggaran Yang Dilakukan <span>/Today</span></h5>
                        <div id="chart">
                            <!-- Include your chart here -->
                            <canvas id="myChart" height="310"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side columns -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="filter">
                        <i class="bi bi-download bi-4x mx-3" style="cursor:pointer" id="downloadButton" onclick="downloadAktifitas()"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Recent Activity </h5>
                        <div class="activity">
                            @foreach ($model->sortByDesc('tanggal')->take(10) as $item)
                                @php
                                $activityDate = Carbon::parse($item->tanggal)->format('Y-m-d');
                                $today = now()->format('Y-m-d');
                                $yesterday = now()->subDay()->format('Y-m-d');
                                $displayDate = ($activityDate == $today) ? 'Today' : (($activityDate == $yesterday) ? 'Yesterday' : $activityDate);
                                @endphp
                                <div class="activity-item d-flex">
                                    <div class="activite-label">{{ $displayDate }}</div>
                                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                    <div class="activity-content">{{ Auth::user()->nama_pengguna }} {{ $item->aktifitas }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Rekap Jam Minus</h5>
                        <div id="nimChart">
                            <!-- Include your doughnut chart here -->
                            <canvas id="nimChartCanvas" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
     function downloadAktifitas() {
    document.getElementById('downloadButton').addEventListener('click', function () {
        // Assuming you have the data available in your Blade view
        var data = @json($response);

        // Create a Blob from the data
        var blob = new Blob([JSON.stringify(data, null, 2)], { type: 'text/plain' });

        // Create a link element to trigger the download
        var a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'sistemP5M_aktifitas.txt';

        // Append the link element to the body and trigger the download
        document.body.appendChild(a);
        a.click();

        // Remove the link element from the body
        document.body.removeChild(a);
    });
}
</script>

@endsection