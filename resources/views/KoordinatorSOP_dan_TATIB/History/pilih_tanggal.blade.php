@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

<div class="pagetitle">
        <h1>History P5M</h1>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a asp-controller="P5M" asp-action="HistoryP5M">Pilih Kelas History P5M</a></li>
                <li class="breadcrumb-item active" aria-current="page">History P5M</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="container">
    <div class="row mb-3">
            <div class="form-group col-auto">
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
            <div class="form-group col-auto">
                <button type="submit" class="btn btn-primary" id="pilihButton">Pilih</button>
            </div>
    </div>
    <div class="row">
    <div class="card container overflow-auto">
        <div class="card-body container">
            <h5 class="card-title">Laporan Jam Minus Absensi Kelas {{ $kelas }} - Tanggal: <span id="selectedDate" style="font-weight:900"></span></h5>
            <hr />
            @if (session('successMessage'))
                <div class="row">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        <strong>Sukses!</strong> {{ session('successMessage') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <input id="kelas" type="hidden" value="{{ $kelas }}" />
        </div>
    </div>
</div>


    <section class="section">

        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <br> 
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Hari dan Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; $tgl_sebelumnya = ""; @endphp

                            @foreach ($tanggalData as $tgl)
                                <tr>
                                    <td class="text-center">@php $i++; echo $i; @endphp</td>
                                    <td class="text-center">{{ $tgl->tanggal }}</td>
                                    <td class="text-center"> 
                                        <!-- Tambahkan tombol atau form aksi sesuai kebutuhan -->
                                        <form action="{{ url('P5M/HistoryP5M') }}" method="post" name="cetak" id="cetak">
                                            @csrf
                                            <button class="btn btn-info fa fa-list" type="submit">Lihat</button>
                                            <input type="hidden" name="tanggalTransaksi" value="{{ $tgl->tanggal }}"/>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                </div>

            </div>
        </div><!-- End Recent Sales -->

    </section>

</main><!-- End #main -->

@endsection
