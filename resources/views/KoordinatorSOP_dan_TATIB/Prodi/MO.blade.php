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
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                            <!-- List group with Links and buttons -->
                            <div class="list-group">
                                <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
                                Tahun Akademik
                                </button>
                                <a type="button" class="list-group-item list-group-item-action" href="mahasiswa" >Tahun Akademik 2014/2015</a>
                                <a type="button" class="list-group-item list-group-item-action" href="mahasiswa" >Tahun Akademik 2015/2016</a>
                                <a type="button" class="list-group-item list-group-item-action" href="mahasiswa" >Tahun Akademik 2016/2017</a>
                                <a type="button" class="list-group-item list-group-item-action" href="mahasiswa" >Tahun Akademik 2017/2018</a>
                                <a type="button" class="list-group-item list-group-item-action" href="mahasiswa" >Tahun Akademik 2018/2019</a>
                                <a type="button" class="list-group-item list-group-item-action" href="mahasiswa" >Tahun Akademik 2019/2020</a>

                            </div>
                            <!-- End List group with Links and buttons -->
                            </div>
                        </div>
                        </section>
                        
                    </div>
                </div>
            </div><!-- End Recent Sales -->
        </section>

    </main><!-- End #main -->
@endsection
