@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Laporan Absensi</h1>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Absensi</li>
                <li class="breadcrumb-item active" aria-current="page">Laporan Absensi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="col-12">
            <div class="card container overflow-auto">
                <div class="card-body container">
                    <h5 class="card-title">Laporan Jam Minus Absensi</h5>
                    <hr />
                    <div class="row">
                        <form method="get" class="row">
                            <div class="form-group col-2" id="filterAfterChoose">
                                <select class="form-select" name="filterValue" id="filterValue" required>
                                    @if (session('role') != "KOORDINATOR TINGKAT")
                                        @forelse ($KelasMahasiswa as $kelas)
                                        {
                                            <option value="{{$kelas}}">{{$kelas}}</option>
                                        }
                                        @empty
                                            
                                        @endforelse (var $kelas in $KelasMahasiswa)
                                    @else
                                    <option value="{{ Auth::user()->kelas }}">{{ Auth::user()->kelas }}</option>
                                    @endif
                                  
                                </select>
                            </div>
                            <div class="form-group col-1">
                                <label for="startDate" class="control-label py-2">Dari : </label>
                            </div>
                            <div class="form-group col-3">
                                <input type="date" class="form-control" id="startDate" name="startDate" required>
                            </div>
                            <div class="form-group col-2">
                                <label for="endDate" class="control-label py-2">Sampai : </label>
                            </div>
                            <div class="form-group col-3" style="margin-left:-4rem">
                                <input type="date" class="form-control" id="endDate" required>
                            </div>
                            <div class="col-1" style="margin-right:-1rem">
                                  <button type="submit" class="btn btn-primary">Pilih</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body" id="dataHistory">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Recent Sales -->
    </section>

</main><!-- End #main -->

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!--Export-->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<!--End Export-->
<!-- DataTables JS -->


<script>
    $(document).ready(function () {
        $("#startDate, #endDate").change(function () {
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();

            var startDateObj = new Date(startDate);
            var endDateObj = new Date(endDate);
            if (endDateObj < startDateObj) {
                swal("Peringatan!", "Tanggal Awal harus lebih besar dari Tanggal Akhir", "warning");
                $("#endDate").val('');
            }
        });
        // Fungsi untuk memuat partial view
        function loadPartialView() {
    var filterValue = $('#filterValue').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();

    var url = "{{ url('/P5M/LoadPartialViewAbsenMinus') }}/" + filterValue + '/' + startDate + '/' + endDate;
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            $('#dataHistory').html(data);
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error status: ' + textStatus);
            console.log('Error details: ' + errorThrown);
            console.log('Server response: ' + xhr.responseText);

            // You can display the error message on your page if needed
            $('#errorMessage').text('An error occurred: ' + errorThrown);
        }
    });
}


        $('form').submit(function (event) {
            event.preventDefault(); 
            loadPartialView(); 
        });
    });
</script>

@endsection
