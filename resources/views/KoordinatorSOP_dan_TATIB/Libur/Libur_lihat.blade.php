@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Data Libur</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Libur</li>
      <li class="breadcrumb-item active">Data Libur</li>
    </ol> 
  </nav>
</div><!-- End Page Title -->

<section class="section">
<div class="col-12">
    <div class="card recent-sales overflow-auto">
        <div class="card-body">
            <br> 

            <!-- <h5 class="card-title">Recent Sales <span>| Today</span></h5> -->
            <a href="{{ url('Liburinput') }}" class="btn btn-primary float-right">
                <i style="font-style: inherit; " class="bi bi-plus">&nbsp;Tambah Libur</i>
            </a>

            <br><br>
            <div id="flash" data-flash="{{ session('pesan_success') }}"></div>
            @if (session('pesan_error'))
                <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('pesan_error') }}
                </div>
            @endif

            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama Libur</th>
                        <th scope="col">Jam Minus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    @foreach ($Libur as $m)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $m->nama_Libur }}</td>
                            <td>{{ $m->jam_minus }} jam</td>
                            <td> 
                                <a href="{{ url('Liburedit/'.$m->id) }}" class="btn" style="color: #0275d8">
                                    <i class="fa fa-edit"></i>
                                </a>
                                
                                <a href="{{ url('Libur/delete/'.$m->id) }}" class="btn" style="color: #0275d8">
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

</main><!-- End #main -->

@endsection
