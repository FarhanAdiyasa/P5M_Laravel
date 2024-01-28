@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>History P5M</h1>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pilih Kelas History P5M</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Pilih Kelas History P5M</h5>

            <div class="mx-5">
                <table class="table datatable text-center">
                    <thead>
                        <tr>
                            <th scope="col">Kelas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $uniqueClasses = [];
                        @endphp

                        @foreach ($dataMahasiswa as $dm)
                            @if (!in_array($dm['kelas'], $uniqueClasses))
                                <tr>
                                    <td>{{ $dm['kelas'] }}</td>
                                    <td>
                                        <a href="{{ url('pilihkls/' . $dm['kelas']) }}" class="list-group-item list-group-item-action mb-3">
                                            <button type="button" class="btn btn-primary"> Pilih Kelas</button>
                                        </a>
                                    </td>
                                </tr>
                                @php
                                    $uniqueClasses[] = $dm['kelas'];
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main><!-- End #main -->

@endsection
