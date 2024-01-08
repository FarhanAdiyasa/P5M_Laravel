@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

  <div class="pagetitle">
    <br>
    <h1>Tambah Mahasiswa</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Mahasiswa</li>
      <li class="breadcrumb-item active" aria-current="page">Daftar Mahasiswa</li>
      <li class="breadcrumb-item active">Tambah Mahasiswa</li>
    </ol>
  </div><!-- End Page Title -->

  <section class="section dashboard">

    <div class="col-12">
      <div class="card">

        <div class="container-fluid pt-4 px-4">
          <div class="row g-8">
            <br />
            <div id="flash" data-flash="{{ session('pesan_success') }}"></div>
            @if (session('pesan_error'))
              <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('pesan_error') }}
              </div>
            @endif

            <form role="form" action="{{ url('mahasiswa/insert') }}" method="post">
              @csrf
              <div class="form-group">
                <label for="nim">Nim<span style="color: red">*</span></label>
                <input type="text" class="form-control" name="nim" required>
                @error('nim')
                  <small class="text-danger pl-3">{{ $message }}</small>
                @enderror
              </div>
              <br>

              <div class="form-group">
                <label for="nama">Nama<span style="color: red">*</span></label>
                <input type="text" class="form-control" name="nama" required>
                @error('nama')
                  <small class="text-danger pl-3">{{ $message }}</small>
                @enderror
              </div>
              <br>

                    <div class="form-group">
              <label for="mhs_angkatan">Angkatan<span style="color: red">*</span></label>
              <input type="number" class="form-control" name="mhs_angkatan" required>
              @error('mhs_angkatan')
                  <small class="text-danger pl-3">{{ $message }}</small>
              @enderror
    </div>
              <br>

              <div class="form-group">
                <label for="kelas">Kelas<span style="color: red">*</span></label>
                <input type="text" class="form-control" name="kelas" required>
                @error('kelas')
                  <small class="text-danger pl-3">{{ $message }}</small>
                @enderror
              </div>
              <br>

              <div class="form-group">
                <label for="prodi">Prodi<span style="color: red">*</span></label>
                <input type="text" class="form-control" name="prodi" required>
                @error('prodi')
                  <small class="text-danger pl-3">{{ $message }}</small>
                @enderror
              </div>
              <br>

              <div class="form-group">
                <label for="email">Email<span style="color: red">*</span></label>
                <input type="text" class="form-control" name="email" required>
                @error('email')
                  <small class="text-danger pl-3">{{ $message }}</small>
                @enderror
              </div>
              <br>

              <div class="form-group">
                <label for="dosen_wali">Dosen Wali<span style="color: red">*</span></label>
                <input type="text" class="form-control" name="dosen_wali" required>
                @error('dosen_wali')
                  <small class="text-danger pl-3">{{ $message }}</small>
                @enderror
              </div>
              <br>


              <button type="reset" onclick="myFunction()" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
              <script>
                function myFunction() {
                  window.location.href = "{{ url('mahasiswa') }}";
                }
              </script>
              &nbsp; &nbsp;
              <button type="submit" class="btn btn-primary m-2">Simpan</button>

            </form>
          </div>
        </div>
      </div>
    </div>

  </section>

</main><!-- End #main -->

@endsection
