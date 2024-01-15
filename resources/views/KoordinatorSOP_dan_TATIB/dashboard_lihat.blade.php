@php
    $loggedInUsername = session('LoggedInUsername');
    $loggedInRole = session('LoggedInRole');
@endphp

@php
    use Carbon\Carbon;
@endphp

@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')
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
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="filter">
                        <i class="bi bi-download bi-4x mx-3" style="cursor:pointer" id="downloadButton"></i>
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
                                    <div class="activity-content">{{ $item->aktifitas }}</div>
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
                            <li><a class="dropdown-item filter-option" data-filter="Today" href="#">Today</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="This Month" href="#">This Month</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="This Year" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body pb-0">
                        <h5 class="card-title">Rekap Pelanggaran Yang Dilakukan <span>/Today</span></h5>
                        <div id="chart" style="min-height: 400px;"></div>
                          
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
