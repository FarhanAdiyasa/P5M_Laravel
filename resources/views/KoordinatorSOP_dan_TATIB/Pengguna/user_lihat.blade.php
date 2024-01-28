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
                                            
                                            <a href="#" class="delete-btn" data-id="{{ $u->id }}" style="color: #0275d8">
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
                window.location.href = "{{ url('pengguna/delete') }}/" + id;
            }
        });
    });
});
</script>

    </main>
@endsection
