@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Laporan Absensi</h1>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Absensi</li>
                <li class="breadcrumb-item active" aria-current="page">Laporan Absensi</li>
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
                                                    array_push($kelas, $dm['kelas']);
                                                }
                                                sort($kelas);
                                                $arrayLength = count($kelas);
                                            @endphp
                                            @foreach ($kelas as $kelasItem)
                                                <option value="{{ $kelasItem }}" @if(request('dropdown') == $kelasItem) selected @endif>{{ $kelasItem }}</option>
                                            @endforeach
                                        </select>
                                    @elseif(request('chooseFilter') == 'nim')
                                        <input class="form-select" style="width:20%; display:inline;" type="text" id="nim" name="nim">
                                    @endif
                                @else
                                    <select class="form-select" style="width:20%; display:inline;" name="dropdown">
                                        @php
                                            $kelas = [];
                                            $i = 0;
                                            foreach ($dataMahasiswa as $dm) {
                                                array_push($kelas, $dm['kelas']);
                                            }
                                            sort($kelas);
                                            $arrayLength = count($kelas);
                                        @endphp
                                        @foreach ($kelas as $kelasItem)
                                            <option value="{{ $kelasItem }}" @if(request('dropdown') == $kelasItem) selected @endif>{{ $kelasItem }}</option>
                                        @endforeach
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
                                <form action="{{ url('cetakAbsensi') }}" method="post" name="cetak" id="cetak">
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
                                $tanggalFT2 = $tanggal2;

                                $date1 = new DateTime($tanggal1);
                                $date2 = new DateTime($tanggal2);
                                $diff = $date2->diff($date1);
                                $jumlahHari = $diff->days;
                            @endphp
                            <div class="container">
                                <table class="table table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center" colspan="{{ $jumlahHari * 2 + 3 }}" ></th>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="text-align: center" rowspan="3" >No</th>
                                            <th scope="col" style="text-align: center" rowspan="3" >Nim</th>
                                            <th scope="col" style="text-align: center" rowspan="3" >Nama</th>
                                        </tr>
                                        <tr>
                                            @php
                                                $currentDate = $tanggal1;
                                                while (strtotime($currentDate) < strtotime($tanggal2)) {
                                                    echo '<th scope="col" style="text-align: center" colspan="2">' . $currentDate . '</th>';
                                                    $currentDate = date("Y-m-d", strtotime("+1 days", strtotime($currentDate)));
                                                }
                                            @endphp
                                        </tr>
                                        <tr>
                                            @for ($i = 0; $i < $jumlahHari; $i++)
                                                <th scope="col" style="text-align: center">IN</th>
                                                <th scope="col" style="text-align: center">OUT</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 0; $no = 0; $bulan = 1; @endphp
                                        @foreach ($dataMahasiswa as $dm)
                                            @php
                                                $i++;
                                                if (request('dropdown')) {
                                                    if ($dm['kelas'] == request('dropdown')) {
                                                        $no++;
                                            @endphp
                                                        <tr>
                                                            <td style="text-align: center">{{ $no }}</td>
                                                            <td style="text-align: center">{{ $dm['nim'] }}</td>
                                                            <td>{{ $dm['nama'] }}</td>
                                                            @php
                                                                $tanggalFT1 = request('tanggal1');
                                                                while (strtotime($tanggalFT1) < strtotime($tanggal2)) {
                                                                    $waktuBerangkat = 0;
                                                                    $waktuPulang = 0;
                                                                    foreach ($absen as $m) {
                                                                        $waktu = $m->waktu;
                                                                        $compareAbsen = explode(' ', $waktu);
                                                                        if ($dm['nim'] == $m->nim && !strcmp($compareAbsen[0], $tanggalFT1)) {
                                                                            if ($waktuBerangkat == 0 || $waktuPulang == 0) {
                                                                                $waktuBerangkat = explode(' ', $waktu);
                                                                                $waktuPulang = explode(' ', $waktu);
                                                                            }
                                                                            if ($waktu < $waktuBerangkat) {
                                                                                $waktuBerangkat = explode(' ', $waktu);
                                                                            } elseif ($waktu > $waktuPulang) {
                                                                                $waktuPulang = explode(' ', $waktu);
                                                                            }
                                                                        }
                                                                    }
                                                            @endphp
                                                                    @if ($waktuBerangkat == 0)
                                                                        <td style="background-color: red;"></td>
                                                                    @else
                                                                        <td style="text-align: center">{{ $waktuBerangkat[1] }}</td>
                                                                    @endif
                                                                    @if ($waktuPulang == 0)
                                                                        <td style="background-color: red;"></td>
                                                                    @else
                                                                        @if ($waktuBerangkat[1] == $waktuPulang[1])
                                                                            <td style="background-color: red;"></td>
                                                                        @else
                                                                            <td style="text-align: center">{{ $waktuPulang[1] }}</td>
                                                                        @endif
                                                                    @endif
                                                            @php
                                                                    $tanggalFT1 = date("Y-m-d", strtotime("+1 days", strtotime($tanggalFT1)));
                                                                }
                                                            @endphp
                                                        </tr>
                                            @php
                                                    }
                                                } elseif (request('nim')) {
                                                    if ($dm['nim'] == request('nim')) {
                                                        $no++;
                                            @endphp
                                                        <tr>
                                                            <td style="text-align: center">{{ $no }}</td>
                                                            <td style="text-align: center">{{ $dm['nim'] }}</td>
                                                            <td>{{ $dm['nama'] }}</td>
                                                            @php
                                                                $tanggalFT1 = request('tanggal1');
                                                                while (strtotime($tanggalFT1) < strtotime($tanggal2)) {
                                                                    $waktuBerangkat = 0;
                                                                    $waktuPulang = 0;
                                                                    foreach ($absen as $m) {
                                                                        $waktu = $m->waktu;
                                                                        $compareAbsen = explode(' ', $waktu);
                                                                        if ($dm['nim'] == $m->nim && !strcmp($compareAbsen[0], $tanggalFT1)) {
                                                                            if ($waktuBerangkat == 0 || $waktuPulang == 0) {
                                                                                $waktuBerangkat = explode(' ', $waktu);
                                                                                $waktuPulang = explode(' ', $waktu);
                                                                            }
                                                                            if ($waktu < $waktuBerangkat) {
                                                                                $waktuBerangkat = explode(' ', $waktu);
                                                                            } elseif ($waktu > $waktuPulang) {
                                                                                $waktuPulang = explode(' ', $waktu);
                                                                            }
                                                                        }
                                                                    }
                                                            @endphp
                                                                    @if ($waktuBerangkat == 0)
                                                                        <td style="background-color: red;"></td>
                                                                    @else
                                                                        <td style="text-align: center">{{ $waktuBerangkat[1] }}</td>
                                                                    @endif
                                                                    @if ($waktuPulang == 0)
                                                                        <td style="background-color: red;"></td>
                                                                    @else
                                                                        @if ($waktuBerangkat[1] == $waktuPulang[1])
                                                                            <td style="background-color: red;"></td>
                                                                        @else
                                                                            <td style="text-align: center">{{ $waktuPulang[1] }}</td>
                                                                        @endif
                                                                    @endif
                                                            @php
                                                                    $tanggalFT1 = date("Y-m-d", strtotime("+1 days", strtotime($tanggalFT1)));
                                                                }
                                                            @endphp
                                                        </tr>
                                            @php
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <br>
                    <br>
                </div>
            </div>
        </div><!-- End Recent Sales -->
    </section>

</main><!-- End #main -->

<script>
    // Ambil elemen dropdown kelas dan elemen tanggal
    const dropdownKelas = document.getElementById("chooseFilter");
    const tanggal = document.getElementById("tanggal1");

    // Tambahkan event listener untuk menangkap event change pada dropdown kelas
    dropdownKelas.addEventListener("change", function(event) {
        // Cek apakah dropdown kelas telah dipilih
        if (dropdownKelas.value === "") {
            // Jika belum dipilih, kosongkan nilai tanggal dan nonaktifkan
            tanggal.value = "";
            tanggal.disabled = true;
        } else {
            // Jika sudah dipilih, aktifkan kembali nilai tanggal
            tanggal.disabled = false;
        }
    });
</script>

@endsection
