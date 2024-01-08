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
                        <br>
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center">No.</th>
                                    <th scope="col" style="text-align: center">Nim</th>
                                    <th scope="col" style="text-align: center;">Nama</th>
                                    <th scope="col" style="text-align: center;">Angkatan</th>
                                    <th scope="col" style="text-align: center">Kelas</th>
                                    <th scope="col" style="text-align: center">Prodi</th>
                                    <th scope="col" style="text-align: center">Email</th>
                                    <th scope="col" style="text-align: center">Dosen Wali</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; $no = 0; @endphp
                                @foreach ($mahasiswa as $dm)
                                    @if (request()->isMethod('post') && $dm['kelas'] == request()->input('dropdown'))
                                        @php $no++; @endphp
                                        <tr>
                                            <td style="text-align: center">{{ $no }}</td>
                                            <td style="text-align: center">{{ $dm['nim'] }}</td>
                                            <td>{{ $dm['nama'] }}</td>
                                            <td class="text-center" style="text-align: center">{{ $dm['mhs_angkatan'] }}</td>
                                            <td style="text-align: center">{{ $dm['kelas'] }}</td>
                                            <td style="text-align: center">{{ $dm['prodi'] }}</td>
                                            <td style="text-align: center">{{ $dm['email'] }}</td>
                                            <td>{{ $dm['dosen_wali'] }}</td>
                                        </tr>
                                    @elseif (!request()->isMethod('post'))
                                        @php $no++; @endphp
                                        <tr>
                                            <td style="text-align: center">{{ $no }}</td>
                                            <td style="text-align: center">{{ $dm['nim'] }}</td>
                                            <td>{{ $dm['nama'] }}</td>
                                            <td style="text-align: center">{{ $dm['mhs_angkatan'] }}</td>
                                            <td style="text-align: center">{{ $dm['kelas'] }}</td>
                                            <td style="text-align: center">{{ $dm['prodi'] }}</td>
                                            <td style="text-align: center">{{ $dm['email'] }}</td>
                                            <td>{{ $dm['dosen_wali'] }}</td>
                                            <td> 
                                                <a href="{{ url('mahasiswaedit/'.$dm->nim) }}" class="btn" style="color: #0275d8">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                
                                                <a href="{{ url('mahasiswa/delete/'.$dm->nim) }}" class="btn" style="color: #0275d8">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                        <br>
                        <br>
                    </div>
                </div>
            </div><!-- End Recent Sales -->
        </section>

    </main><!-- End #main -->
@endsection
