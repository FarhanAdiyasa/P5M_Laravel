<?php
    $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
    $dataMahasiswa = json_decode($url, true);
?>

@extends('KoordinatorTingkat.layout.header')

@section('konten')
<section class="section">
    <div class="container">
        <div class="row">
            <div class="card container overflow-auto">
                <div class="card-body container">
                    <h5 class="card-title">Laporan Jam Minus Absensi</h5>
                    <hr />
                    @if (TempData["SuccessMessage"] != null)
                    {
                        <div class="row">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                <strong>Sukses!</strong> @TempData["SuccessMessage"]
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    }
                    <div class="row">
                        <form method="get" class="row">
                            <div class="form-group col-2" id="filterAfterChoose">
                                <select class="form-select" name="filterValue" id="filterValue" onchange="dtMhs()" required>
                                    @foreach (var $kelas in $KelasMahasiswa)
                                    {
                                        <option value="{{$kelas}}">{{$kelas}}</option>
                                    }
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
        </div>
    </div>
    
</section>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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

            var url = '/P5M/LoadPartialViewAbsen?filterValue=' + filterValue + '&startDate=' + startDate + '&endDate=' + endDate;

            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('#dataHistory').html(data);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        $('form').submit(function (event) {
            event.preventDefault(); // Mencegah form untuk melakukan submit normal
            loadPartialView(); // Memuat partial view
        });
    });
</script>


@endsection