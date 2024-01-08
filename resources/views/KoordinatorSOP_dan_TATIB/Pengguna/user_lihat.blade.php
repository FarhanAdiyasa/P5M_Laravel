@extends('KoordinatorSOP_dan_TATIB.layout.header')  {{-- Assuming you have a layout file named 'app.blade.php' --}}

@section('konten')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Pengguna</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                    <li class="breadcrumb-item active">Data Pengguna</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">

                    <div class="card-body">
                        <br> 
                        <a href="{{ url('penggunainput') }}" class="btn btn-primary float-right">
                            <i style="font-style: inherit;" class="bi bi-plus">&nbsp;Tambah Pengguna</i>
                        </a>
                        <br><br>

                        @if (session('pesan_success'))
                            <div id="flash" data-flash="{{ session('pesan_success') }}"></div>
                        @endif

                        @if (session('pesan_error'))
                            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                {{ session('pesan_error') }}
                            </div>
                        @endif

                        <table class="table table-striped datatable datatable">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">No.</th>
                                    <th class="text-center" scope="col">Username</th>
                                    <th class="text-center" scope="col">Nama Pengguna</th>
                                    <th class="text-center" scope="col">Role</th>
                                    <th class="text-center" scope="col">Kelas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0; ?>
                                @foreach($pengguna as $u)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td>{{ $u->username }}</td>

                                        <td>{{ $u->nama_pengguna }}</td>
                                        <td>{{ $u->role }}</td>
                                        <td>{{ $u->kelas }}</td>
                                        <td class="text-center"> 
                                            <a href="{{ url('penggunaedit/'.$u->id) }}" class="btn" style="color: #0275d8">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ url('pengguna/delete/'.$u->id) }}" id="tombol-hapus" class="btn" style="color: #0275d8">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <br>
                        <br>
                    </div>
                </div>
            </div><!-- End Recent Sales -->
        </section>
    </main>
@endsection
