@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Laporan Jam Minus P5M</h1>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Absensi</li>
                <li class="breadcrumb-item active" aria-current="page">Laporan Jam Minus P5M</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <br>
                    <div class="row">
                        <div class="col-1">
                            <form method="get">
                                <select class="form-select" style="display:inline; padding: 0.375rem 1.25rem .375rem .75rem;" name="chooseFilter" id="chooseFilter">
                                    <option value="kelas" @if(request('chooseFilter') == 'kelas') selected @endif>Kelas</option>
                                    <option value="nim" @if(request('chooseFilter') == 'nim') selected @endif>Nim</option>
                                </select>
                            </form>
                        </div>

                        <script>
                            document.querySelector('#chooseFilter').addEventListener('change', function() {
                                document.querySelector('form').submit();
                            });
                        </script>

                        <div class="col-9">
                            <form action="" method="post" name="pilih" id="pilih">
                                @csrf
                                @if(request('chooseFilter'))
                                    @if(request('chooseFilter') == 'kelas')
                                        <select class="form-select" style="width:20%; display:inline;" name="dropdown">
                                        @php
    $kelas = [];
    $i = 0;
    foreach ($dataMahasiswa as $dm) {
        // $i should start from 0
        array_push($kelas, $dataMahasiswa[$i]['kelas']);
        $i++;
    }
    sort($kelas);
    $arrayLength = count($kelas);
@endphp
@for ($i = 0; $i < $arrayLength; $i++)
    @if($i == 0 || $kelas[$i] != $kelas[$i-1])
        <option value="{{ $kelas[$i] }}" @if(request('dropdown') == $kelas[$i]) selected @endif>{{ $kelas[$i] }}</option>
    @endif
@endfor
                                        </select>
                                    @elseif(request('chooseFilter') == 'nim')
                                        <input class="form-select" style="width:20%; display:inline;" type="text" id="nim" name="nim">
                                    @endif
                                @else
                                    <select class="form-select" style="width:20%; display:inline;" name="dropdown" >
                                    @php
    $kelas = [];
    $i = 0;
    foreach ($dataMahasiswa as $dm) {
        // $i should start from 0
        array_push($kelas, $dataMahasiswa[$i]['kelas']);
        $i++;
    }
    sort($kelas);
    $arrayLength = count($kelas);
@endphp
@for ($i = 0; $i < $arrayLength; $i++)
    @if($i == 0 || $kelas[$i] != $kelas[$i-1])
        <option value="{{ $kelas[$i] }}" @if(request('dropdown') == $kelas[$i]) selected @endif>{{ $kelas[$i] }}</option>
    @endif
@endfor
                                    </select>
                                @endif

                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="tanggal1">Mulai Tanggal &nbsp;:</label>
                                &nbsp;
                                <input class="form-control" style="width:20%; display:inline;" class="text-left" type="date" id="tanggalmulai" name="tanggal1" value="{{ request('tanggal1') }}">
                                @error('tanggal1')<small class="text-danger pl-3">{{ $message }}</small>@enderror
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="birthday">Sampai Tanggal &nbsp;:</label>
                                &nbsp;
                                <input class="form-control" style="width:20%; display:inline; float: right;" type="date" id="tanggalselesai" name="tanggal2" value="{{ request('tanggal2') }}">
                                @error('tanggal2')<small class="text-danger pl-3">{{ $message }}</small>@enderror
                                &nbsp;
                                <input type="submit" id="cetak" name="cetak" class="btn btn-primary" value="Pilih"/>
                            </form>
                        </div>


                        @if (request()->isMethod('post'))
                            <div class="col-2">
                                <form action="{{ url('p5m/cetak_laporan_jam_minus') }}" method="post" name="cetak" id="cetak">
                                    @csrf
                                    <input type="submit" id="cetak" name="cetak" class="btn btn-primary" value="Cetak"/>
                                    <input type="hidden" id="tanggal1" name="tanggal1" value="{{ request('tanggal1') }}"/>
                                    <input type="hidden" id="tanggal2" name="tanggal2" value="{{ request('tanggal2') }}"/>
                                    @php $DDL = (request('dropdown')) ? request('dropdown') : ""; @endphp
                                    <input type="hidden" id="dropdown" name="dropdown" value="{{ $DDL }}"/>
                                </form><br>
                            </div>
                        @endif
                    </div>

                    @if (request()->isMethod('post'))
                        <div class="col-12">
                            @php
                                $tanggal1 = request('tanggal1');
                                $tanggal2 = date('Y-m-d', strtotime('+1 days', strtotime(request('tanggal2'))));
                                $tanggalFT1 = date('Y-M-d', strtotime('+0 days', strtotime(request('tanggal1'))));
                                $tanggalFT2 = date('Y-M-d', strtotime('+0 days', strtotime(request('tanggal2'))));

                                $date1 = new DateTime($tanggal1);
                                $date2 = new DateTime($tanggal2);
                                $diff = $date2->diff($date1);
                                $jumlahHari = $diff->days;
                            @endphp
                            <table class="table table-striped datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">No.</th>
                                        <th class="text-center" scope="col">Nim</th>
                                        <th class="text-center" scope="col">Nama</th>
                                        <th class="text-center" scope="col">Jenis</th>
                                        <th class="text-center" scope="col">Jumlah Jam</th>
                                        <th class="text-center" scope="col">Keterangan</th>
                                        <th class="text-center" scope="col">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; $no = 0; @endphp
                                    @foreach ($dataMahasiswa as $dm)
                                        @php
                                            $i++;
                                            $no++;
                                        @endphp
                                        @if(request('chooseFilter') == 'kelas')
                                            @if($dm['kelas'] == request('dropdown'))
                                                @php
                                                    $totalJamMinus = 0;
                                                    foreach ($p5m as $pm) {
                                                        if ($pm->nim_mahasiswa == $dm['nim'] && $pm->tgl_transaksi > $tanggal1 && $pm->tgl_transaksi < $tanggal2) {
                                                            $totalJamMinus = $pm->total_jam_minus;
                                                        }
                                                    }
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $no }}</td>
                                                    <td class="text-center">{{ $dm['nim'] }}</td>
                                                    <td>{{ $dm['nama'] }}</td>
                                                    <td class="text-center">Murni</td>
                                                    <td class="text-center">{{ $totalJamMinus }}</td>
                                                    <td class="text-center">Jam Minus P5M Prodi MI Periode {{ $tanggalFT1 }} - {{ $tanggalFT2 }}</td>
                                                    <td class="text-center">{{ date("Y-m-d") }}</td>
                                                </tr>
                                            @endif
                                        @elseif(request('chooseFilter') == 'nim')
                                            @if($dm['nim'] == request('nim'))
                                                @php
                                                    $totalJamMinus = 0;
                                                    foreach ($p5m as $pm) {
                                                        if ($pm->nim_mahasiswa == $dm['nim'] && $pm->tgl_transaksi > $tanggal1 && $pm->tgl_transaksi < $tanggal2) {
                                                            $totalJamMinus = $pm->total_jam_minus;
                                                        }
                                                    }
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $no }}</td>
                                                    <td class="text-center">{{ $dm['nim'] }}</td>
                                                    <td>{{ $dm['nama'] }}</td>
                                                    <td class="text-center">Murni</td>
                                                    <td class="text-center">{{ $totalJamMinus }}</td>
                                                    <td class="text-center">Jam Minus P5M Prodi MI Periode {{ $tanggalFT1 }} - {{ $tanggalFT2 }}</td>
                                                    <td class="text-center">{{ date("y-M-d") }}</td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            <br>
                        </div>
                    @endif
                </div>
            </div>
        </div><!-- End Recent Sales -->
    </section>

</main><!-- End #main -->
@endsection
