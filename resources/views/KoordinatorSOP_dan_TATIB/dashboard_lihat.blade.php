@php
    use Carbon\Carbon;
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
                            <li><a class="dropdown-item pl" href="#">Today</a></li>
                            <li><a class="dropdown-item pl" href="#">This Month</a></li>
                            <li><a class="dropdown-item pl" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title card-pl">Rekap Pelanggaran Yang Dilakukan <span>/Today</span></h5>
                        <div id="chart">
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
                            @foreach ($model->sortByDesc('tanggal')->take(5) as $item)
                                @php
                                $activityDate = Carbon::parse($item->log_tanggal)->format('Y-m-d');
                                $today = now()->format('Y-m-d');
                                $yesterday = now()->subDay()->format('Y-m-d');
                                $displayDate = ($activityDate == $today) ? 'Today' : (($activityDate == $yesterday) ? 'Yesterday' : $activityDate);
                                @endphp
                                <div class="activity-item d-flex">
                                    <div class="activite-label">{{ $displayDate }}</div>
                                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                    <div class="activity-content">{{ Auth::user()->nama_pengguna }} {{ $item->log_aktifitas }}</div>
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
                            <li><a class="dropdown-item nim" href="#">Today</a></li>
                            <li><a class="dropdown-item nim" href="#">This Month</a></li>
                            <li><a class="dropdown-item nim" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title card-nim">Pelanggaran Banyak Dilakukan Oleh<span>| This Month</span></h5>
                        <div id="nimChart">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        loadPartialView("Today");
        function loadPartialView(filter) {
        var startDate, endDate;
        var filterText;
        if (filter == "Today") {
            startDate = new Date();
            endDate = startDate;
            filterText = "/Today";
        } else if (filter == "This Month") {
            startDate = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
            endDate = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0);
            filterText = "/This Month";
        } else if (filter == "This Year") {
            startDate = new Date(new Date().getFullYear(), 0, 1);
            endDate = new Date(new Date().getFullYear(), 11, 31);
            filterText = "/This Year";
        }

        var url = '/LoadChart/' + startDate.toISOString().split('T')[0] + '/' + endDate.toISOString().split('T')[0];

        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                $('#chart').html(data);
                
                $('.card-pl span').text(filterText);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
    document.querySelectorAll('.pl').forEach(item => {
        item.addEventListener('click', function () {
            // Get the selected filter value
            const selectedFilter = this.innerHTML;

            // Call the loadPartialView function with the selected filter
            loadPartialView(selectedFilter);
        });
    });
    </script>
    <script>
        loadPartialViewNim("Today");
        function loadPartialViewNim(filter) {
        var startDate, endDate;
        var filterText;
        if (filter == "Today") {
            startDate = new Date();
            endDate = startDate;
            filterText = "/Today";
        } else if (filter == "This Month") {
            startDate = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
            endDate = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0);
            filterText = "/This Month";
        } else if (filter == "This Year") {
            startDate = new Date(new Date().getFullYear(), 0, 1);
            endDate = new Date(new Date().getFullYear(), 11, 31);
            filterText = "/This Year";
        }

        var url = '/LoadChartNim/' + startDate.toISOString().split('T')[0] + '/' + endDate.toISOString().split('T')[0];

        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                $('#nimChart').html(data);
                
                $('.card-nim span').text(filterText);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
    document.querySelectorAll('.nim').forEach(item => {
        item.addEventListener('click', function () {
            // Get the selected filter value
            const selectedFilter = this.innerHTML;

            // Call the loadPartialView function with the selected filter
            loadPartialViewNim(selectedFilter);
        });
    });
    </script>
    
<script>
    function formatJSON(data) {
    var replacer = function(key, value) {
        if (typeof value === 'string') {
            return value.replace(/\n/g, '\\n');
        }
        return value;
    };
    return JSON.stringify(data, replacer, 4);  // Use 4 spaces for indentation
}
function downloadAktifitas() {
    document.getElementById('downloadButton').addEventListener('click', function () {
        // Assuming you have the data available in your Blade view
        var jsonString = @json($response);

        // Parse the JSON string into a JavaScript object
        var data = JSON.parse(jsonString.original);

        // Iterate through the array and adjust the date format
        data.forEach(function(item) {
            item.tanggal = new Date(item.tanggal).toISOString();
        });

        // Create a Blob from the modified data
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