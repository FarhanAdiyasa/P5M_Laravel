@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <br>
        <h1>History P5M</h1>
        <br> 
        <!-- <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('index.html') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav> -->
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

                            @foreach ($p5m as $h)
                                @if($h->tgl_transaksi != $tgl_sebelumnya)
                                    <tr>
                                        <td class="text-center">@php $i++; echo $i; @endphp</td>
                                        <td class="text-center">{{ $h->tgl_transaksi }}</td>
                                        <td class="text-center"> 
                                            <form action="{{ url('p5mlihat') }}" method="post" name="cetak" id="cetak">
                                                @csrf
                                                <button class="btn btn-info fa fa-list" type="submit"></button>
                                                <input type="hidden" id="tanggalTransaksi" name="tanggalTransaksi" value="{{ $h->tgl_transaksi }}"/>
                                            </form><br>
                                        </td>
                                    </tr>
                                    @php $tgl_sebelumnya = $h->tgl_transaksi; @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <!-- <button type="submit" class="btn btn-primary m-2">Simpan</button>   -->
                    <br>
                    <!-- </form> -->
                </div>

            </div>
        </div><!-- End Recent Sales -->

    </section>

</main><!-- End #main -->

@endsection
