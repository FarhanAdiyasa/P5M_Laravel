@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Pertemuan 5 Menit</h1>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dashboard/index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Absensi</li>
                <li class="breadcrumb-item active" aria-current="page">P5M</li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <br>

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                

                    @php
                        $kelasDipilih = session('kelas_dipilih');
                    @endphp

                    <form action="{{ route('p5m') }}" method="post" name="pilih" id="pilih">
                    @csrf
                    <label for="birthday">Kelas &nbsp:</label>
                    <select class="form-select" style="width:20%; display:inline;" name="dropdown">
                        @if (session('role') != "KOORDINATOR TINGKAT")
                            <option value="" disabled selected>Pilih Kelas</option>
                            @forelse ($KelasMahasiswa as $kelas)
                                <option value="{{ $kelas }}" {{ isset($_POST['dropdown']) && $_POST['dropdown'] == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @empty
                                <!-- Handle empty case -->
                            @endforelse
                        @else
                            <option value="{{ Auth::user()->kelas }}">{{ Auth::user()->kelas }}</option>
                        @endif
                    </select>

                    <input type="submit" id="cetak" name="cetak" class="btn btn-primary" value="Pilih"/>
                </form>


                    <form role="form" action="{{ route('p5m.create') }}" id="formP5M" method="post">
                        @csrf
                        <table class="table table-bordered border datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NIM</th>
                                    <th class="text-center">Nama Mahasiswa</th>

                                    @foreach ($pelanggaran as $m)
                                        <th class="text-center">{{ $m->plg_nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; $no = 0; @endphp<br>
                                @foreach ($dataMahasiswa as $dm)
                                    @if ($_SERVER['REQUEST_METHOD'] == 'POST')
                                        @if ($dm['kelas'] == $_POST['dropdown'])
                                            @php $no++; @endphp

                                            <tr>
                                                <td class="text-center">
                                                    @php $i++; echo $i; @endphp
                                                </td>
                                                <td class="text-center">{{ $dm['nim'] }}</td>
                                                <td>{{ $dm['nama'] }}</td>

                                                @foreach ($pelanggaran as $m)
                                                    <td class="text-center">
                                                        <input type="checkbox" id="{{ 'CB_'.$dm['nim'].'_'.$m->plg_id }}"
                                                            name="{{ 'CB_'.$dm['nim'].'_'.$m->plg_id }}"
                                                            value="{{ $m->plg_jamMinus }}">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endif
                                    @else
                                        @if ($dm['kelas'] == Auth::user()->kelas)
                                        @php $no++; @endphp

                                        <tr>
                                            <td class="text-center">
                                                @php $i++; echo $i; @endphp
                                            </td>
                                            <td class="text-center">{{ $dm['nim'] }}</td>
                                            <td>{{ $dm['nama'] }}</td>

                                            @foreach ($pelanggaran as $m)
                                                <td class="text-center">
                                                    <input type="checkbox" id="{{ 'CB_'.$dm['nim'].'_'.$m->plg_id }}"
                                                        name="{{ 'CB_'.$dm['nim'].'_'.$m->plg_id }}"
                                                        value="{{ $m->plg_jamMinus }}">
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                        <br>
                        <button type="submit" id="tombol-simpan" class="btn btn-primary m-2">Simpan</button>
                        <br>
                    </form>
                    <br>
                </div>
            </div>
        </div><!-- End Recent Sales -->

    </section>

    

</main><!-- End #main -->

@endsection

