
@php
    $loggedInUsername = session('LoggedInUsername');
    $loggedInRole = session('LoggedInRole');
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
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Reminder P5M</h5>
                                @if ($sudahP5M)
                                    <p>
                                        Sudah P5M Hari Ini
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="#00FF00" class="bi bi-check2-all" viewBox="0 0 16 16">
                                        <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0" />
                                        <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708" />

                                        </svg>
                                    </p>
                                @else
                                    <p>
                                        Belum P5M Hari Ini
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="#FF0000" class="bi bi-x-circle" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />

                                        </svg>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
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
                                    $activityDate = $item->tanggal->format('Y-m-d');
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

            </div>
        </div>
    </section>

 
@endsection

