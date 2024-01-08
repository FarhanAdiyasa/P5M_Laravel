@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Ubah Data Mahasiswa</h1>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dashboard/index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('mahasiswa') }}">Data Mahasiswa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ubah Data Mahasiswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <!-- Reports -->
        <div class="col-12">
            <div class="card">

                <!-- Widgets Start -->
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-8">
                        <div class="row">
                            <div class="row">
                                <h4 class="card-title">Edit Mahasiswa</h4>
                                <br/>
                                <form role="form" action="{{ url('/mahasiswa/update') }}" method="post">
                                    @csrf <!-- Add CSRF token for security -->
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="nim" value="{{ $mahasiswa->nim }}" hidden>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" name="nama" value="{{ $mahasiswa->nama }}" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="mhs_angkatan">Angkatan</label>
                                        <input type="text" class="form-control" name="mhs_angkatan" value="{{ $mahasiswa->mhs_angkatan }}" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="kelas">Kelas</label>
                                        <input type="text" class="form-control" name="kelas" value="{{ $mahasiswa->kelas }}" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="prodi">Prodi</label>
                                        <input type="text" class="form-control" name="prodi" value="{{ $mahasiswa->prodi }}" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" name="email" value="{{ $mahasiswa->email }}" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="dosen_wali">Dosen Wali</label>
                                        <input type="text" class="form-control" name="dosen_wali" value="{{ $mahasiswa->dosen_wali }}" required>
                                    </div>
                                    <br>
                                    <button type="reset" onclick="myFunction()" class="btn btn-secondary m-2" data-dismiss="modal">Close</button>
                                    <script>
                                        function myFunction() {
                                        window.location.href = "{{ url('mahasiswa') }}";
                                        }
                                    </script>
                                    &nbsp; &nbsp;
                                    <button type="submit" class="btn btn-primary m-2">Save</button>
                                </form>
                            </div>
                        </div>
                        <!-- Widgets End -->
                    </div>
                    <!-- Content End -->
                </div>

            </div>
            <!-- Widgets End -->
        </div><!-- End Reports -->

    </section>

</main><!-- End #main -->

@endsection
