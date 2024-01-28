@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

  <div class="pagetitle">
    <br>
    <h1>Tambah Pelanggaran</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ url('pelanggaran') }}">Data Pelanggaran</a></li>
      <li class="breadcrumb-item active">Tambah Pelanggaran</li>
    </ol>
  </div><!-- End Page Title -->

  <section class="section dashboard">

    <!-- Reports -->
    <div class="col-12">
      <div class="card">

        <!-- Widgets Start -->
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
            <form role="form" action="{{ url('pelanggaran/insert') }}" method="post">
              @csrf
              <div class="form-group">
                <label for="nama_pelanggaran">Nama Pelanggaran<span style="color: red">*</span></label>
                <input type="text" class="form-control" name="nama_pelanggaran" pattern="[A-Za-z\s]+" title="Hanya huruf yang diperbolehkan"required>
                @error('nama_pelanggaran')
                  <small class="text-danger pl-3">{{ $message }}</small>
                @enderror
              </div>
              <br>

              <div class="form-group">
                <label for="jam_minus">Jam Minus<span style="color: red">*</span></label>
                <input type="number" class="form-control" name="jam_minus" required>
                @error('jam_minus')
                  <small class="text-danger pl-3">{{ $message }}</small>
                @enderror
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
      <!-- Widgets End -->

    </div>
  </div><!-- End Reports -->

  </section>

</main><!-- End #main -->

@endsection
