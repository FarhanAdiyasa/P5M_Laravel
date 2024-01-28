@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <br>
        <h1>Pilih Tanggal</h1>
        <br> 
    </div><!-- End Page Title -->

    <section class="section">

        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <br> 
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Hari dan Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; $tgl_sebelumnya = ""; @endphp

                            @foreach ($tanggalData as $tgl)
                                <tr>
                                    <td class="text-center">@php $i++; echo $i; @endphp</td>
                                    <td class="text-center">{{ $tgl->tanggal }}</td>
                                    <td class="text-center"> 
                                        <!-- Tambahkan tombol atau form aksi sesuai kebutuhan -->
                                        <form action="{{ url('P5M/HistoryP5M') }}" method="post" name="cetak" id="cetak">
                                            @csrf
                                            <button class="btn btn-info fa fa-list" type="submit">Lihat</button>
                                            <input type="hidden" name="tanggalTransaksi" value="{{ $tgl->tanggal }}"/>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                </div>

            </div>
        </div><!-- End Recent Sales -->

    </section>

</main><!-- End #main -->

@endsection
