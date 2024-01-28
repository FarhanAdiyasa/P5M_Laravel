@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Data Pelanggaran</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Pelanggaran</li>
      <li class="breadcrumb-item active">Data Pelanggaran</li>
    </ol> 
  </nav>
</div><!-- End Page Title -->

<section class="section">
<div class="col-12">
    <div class="card recent-sales overflow-auto">
        <div class="card-body">
            <br> 

            <!-- <h5 class="card-title">Recent Sales <span>| Today</span></h5> -->
            <a href="{{ url('pelanggaraninput') }}" class="btn btn-primary float-right">
                <i style="font-style: inherit; " class="bi bi-plus">&nbsp;Tambah Pelanggaran</i>
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
                        <th scope="col">Nama Pelanggaran</th>
                        <th scope="col">Jam Minus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    @foreach ($pelanggaran as $m)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $m->nama_pelanggaran }}</td>
                            <td>{{ $m->jam_minus }} jam</td>
                            <td> 
                                
                                <a href="{{ url('pelanggaranedit/'.$m->id) }}" class="btn" style="color: #0275d8">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" class="delete-btn" data-id="{{ $m->id }}" style="color: #0275d8">
                                                <i class="fa fa-trash"></i></button>
                                            </a>
                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if(session('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Data berhasil ditambahkan.',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                </script>
                                @endif

                                @if(session('update'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Data berhasil diubah.',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                </script>
                                @endif

            @if(session('delete'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Data berhasil dihapus.',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                </script>
                                @endif

            <br>
            <br>

        </div>
    </div>
</div><!-- End Recent Sales -->
</section>

<script>
    $(document).ready(function () {
    $('.delete-btn').on('click', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        Swal.fire({
            title: 'Yakin data ingin dihapus?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete route with the correct parameter
                window.location.href = "{{ url('pelanggaran/delete') }}/" + id;
            }
        });
    });
});
</script>


</main><!-- End #main -->


@endsection
