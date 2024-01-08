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

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($libur as $m)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $m->tanggal }}</td>
                                    <td>{{ $m->deskripsi }}</td>
                                    <td>{{ $m->kategori }}</td>

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
