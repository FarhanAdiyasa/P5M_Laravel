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
                    <h5 class="card-title">Laporan Absensi</h5>
                    <hr />
                    <div class="row">
                        <form method="get" class="row">
                            <div class="form-group col-2" id="filterAfterChoose">
                                <select class="form-select" name="filterValue" id="filterValue" required>
                                    @forelse ($KelasMahasiswa as $kelas)
                                    {
                                        <option value="{{$kelas}}">{{$kelas}}</option>
                                    }
                                    @empty
                                        
                                    @endforelse (var $kelas in $KelasMahasiswa)
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

    var url = "{{ url('/P5M/LoadPartialViewAbsen') }}/" + filterValue + '/' + startDate + '/' + endDate;
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
