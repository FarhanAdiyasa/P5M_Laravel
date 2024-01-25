@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <br>
        <h1>Pertemuan 5 Menit</h1>
        <br>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('index.html') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pelanggaran</li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <br>
                    @php
                        $tanggal = request()->input('tanggalTransaksi');
                        $kelasHistory = request()->input('kelas');
                    @endphp
                    <table>
                        <tr>
                            <th style="text-align: end;">Tanggal :</th>
                            <td>{{ $tanggal }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: end;">Kelas :</th>
                            <td>{{ $kelasHistory }}</td>
                        </tr>
                    </table>
                    <form role="form" action="{{ url('P5M/tambah/') }}" method="post">
                        @csrf <!-- Add CSRF token -->
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NIM</th>
                                    <th class="text-center">Nama Mahasiswa</th>
                                    @foreach ($pelanggaran as $m)
                                        <th class="text-center">{{ $m->nama_pelanggaran }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($dataMahasiswa as $dm)
                                @if($dm['kelas'])
                                    <tr>
                                        <td class="text-center">@php $i++; echo $i; @endphp</td>
                                        <td class="text-center">{{ $dm['nim'] }}</td>
                                        <td>{{ $dm['nama'] }}</td>
                                        
                                        @foreach ($pelanggaran as $m)
                                            @php
                                                $ischecked = '';
                                                foreach ($get3tabel as $g) {
                                                    if ($g->id_pelanggaran == $m->id && $dm['nim'] == $g->nim_mahasiswa && $tanggal == $g->tgl_transaksi) {
                                                        $ischecked = 'checked';
                                                    }
                                                }
                                            @endphp
                                            
                                            <td class="text-center">
                                                <input type="checkbox" id="" name="" value="" {{ $ischecked }} disabled>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>

                        <br>
                        <a href="{{ url('history_lihat') }}" class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                    </form>
                    <br>
                </div>

            </div>
        </div><!-- End Recent Sales -->

    </section>

</main><!-- End #main -->
@endsection
