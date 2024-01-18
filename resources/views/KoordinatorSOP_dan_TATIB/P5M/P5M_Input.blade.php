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

                    @php
                        $sql = "SELECT kelas FROM pengguna WHERE nama_pengguna = ? and status = 1";
                        $where = Cookie::get('nama');
                        $machine = DB::table('pengguna')->select('kelas')->where('nama_pengguna', $where)->where('status', 1)->get();
                        $DdlKelas = '';
                        foreach ($machine as $m) {
                            $DdlKelas = $m->kelas;
                        }
                    @endphp

                    <table>
                        <th>
                            <p> Kelas : {{ $DdlKelas }}</p>
                        </th>
                    </table>

                    <form action="{{ url('p5msop') }}" method="post" name="pilih" id="pilih">
                        @csrf
                        <label for="birthday">Kelas &nbsp:</label>
                        <select class="form-select" style="width:20%; display:inline;" name="dropdown">
                            <?php
                                $kelas = array();
                                $i = 0;
                                foreach ($dataMahasiswa as $dm){
                                    $i++;
                                    array_push($kelas, $dm['kelas']);
                                }
                                sort($kelas);
                                $arrayLength = count($kelas);
                            ?>
                               @if (session('role') != "KOORDINATOR TINGKAT")
                                    @for ($i = 0; $i < $arrayLength; $i++)
                                        @if ($i === 0 || $kelas[$i] != $kelas[$i-1])
                                            <option value="{{ $kelas[$i] }}">{{ $kelas[$i] }}</option>
                                        @endif
                                    @endfor
                                @else
                                <option value="{{ Auth::user()->kelas }}">{{ Auth::user()->kelas }}</option>
                                @endif
                           
                        </select>

                        <input type="submit" id="cetak" name="cetak" class="btn btn-primary" value="Pilih"/>
                    </form>

                    <form role="form" action="{{ url('p5msop/tambah') }}" id="formP5M" method="post">
                        @csrf
                        <table class="table table-bordered border datatable">
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
                                                        <input type="checkbox" id="{{ 'CB_'.$dm['nim'].'_'.$m->id }}"
                                                            name="{{ 'CB_'.$dm['nim'].'_'.$m->id }}"
                                                            value="{{ $m->jam_minus }}">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endif
                                    @else
                                        @php $no++; @endphp

                                        <tr>
                                            <td class="text-center">
                                                @php $i++; echo $i; @endphp
                                            </td>
                                            <td class="text-center">{{ $dm['nim'] }}</td>
                                            <td>{{ $dm['nama'] }}</td>

                                            @foreach ($pelanggaran as $m)
                                                <td class="text-center">
                                                    <input type="checkbox" id="{{ 'CB_'.$dm['nim'].'_'.$m->id }}"
                                                        name="{{ 'CB_'.$dm['nim'].'_'.$m->id }}"
                                                        value="{{ $m->jam_minus }}">
                                                </td>
                                            @endforeach
                                        </tr>
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

