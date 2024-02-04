@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Ubah Data Pelanggaran</h1>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dashboard/index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('masterpelanggaran') }}">Data Pelanggaran</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ubah Data Pelanggaran</li>
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
                                <h4 class="card-title">Edit Pelanggaran</h4>
                                <br/>
                                <form role="form" action="{{ url('/pelanggaran/update') }}" method="post">
                                    @csrf <!-- Add CSRF token for security -->
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="plg_id" value="{{ $pelanggaran->plg_id }}" hidden>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="plg_nama">Nama Pelanggaran<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="plg_nama" value="{{ $pelanggaran->plg_nama }}" pattern="[A-Za-z\s]+" title="Hanya huruf yang diperbolehkan" required>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="plg_jamMinus">Jam Minus<span style="color: red">*</span></label>
                                        <input type="number" class="form-control" name="plg_jamMinus" value="{{ $pelanggaran->plg_jamMinus }}" required>
                                    </div>
                                    <br>

                                    <button type="reset" onclick="myFunction()" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                    <script>
                                      function myFunction() {
                                        window.location.href = "{{ url('pelanggaran') }}";
                                      }
                                    </script>                                    
                                    &nbsp; &nbsp;
                                    <button type="submit" class="btn btn-primary m-2">Simpan</button>
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
