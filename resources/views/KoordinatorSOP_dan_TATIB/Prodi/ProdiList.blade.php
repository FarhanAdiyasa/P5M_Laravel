@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Daftar Mahasiswa</h1>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mahasiswa</li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Mahasiswa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                    <br> 

                    <!-- <h5 class="card-title">Recent Sales <span>| Today</span></h5> -->
                    <a href="{{ url('mahasiswainput') }}" class="btn btn-primary float-right">
                        <i style="font-style: inherit; " class="bi bi-plus">&nbsp;Tambah Mahasiswa</i>
                    </a>

                    <br><br>
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                            <!-- List group with Links and buttons -->
                            <div class="list-group">
                                <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
                                Program Studi
                                </button>
                                <a type="button" class="list-group-item list-group-item-action" href="p4" >Pembuatan Peralatan dan Perkakas Produksi</a>
                                <a type="button" class="list-group-item list-group-item-action" href="tpm" >Teknik Produksi Proses Manufaktur </a>
                                <a type="button" class="list-group-item list-group-item-action" href="mi" >Manajemen Informatika</a>
                                <a type="button" class="list-group-item list-group-item-action" href="mo" >Mesin Otomotif</a>
                                <a type="button" class="list-group-item list-group-item-action" href="mk" >Mekratonika</a>
                                <a type="button" class="list-group-item list-group-item-action" href="tkbg" >Teknologi Kontruksi Bangunan dan Gedung</a>

                            </div>
                            <!-- End List group with Links and buttons -->
                            </div>
                        </div>
                        </section>
                        <br>
                        <br>
                    </div>
                </div>
            </div><!-- End Recent Sales -->
        </section>

    </main><!-- End #main -->
@endsection
