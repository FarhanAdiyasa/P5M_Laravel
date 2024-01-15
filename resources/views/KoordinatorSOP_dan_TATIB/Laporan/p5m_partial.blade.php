<div class="row">
    <div class="col-lg-12">
        <table class="table datatable" id="tbl">
        <thead>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Jumlah Jam</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
        </thead>
<tbody>
   @foreach ($result as $rs)
   <tr>
    <td>{{$rs['nim']}}</td>
    <td>{{$rs['nama']}}</td>
    <td>{{$rs['jenis']}}</td>
    <td>{{$rs['jumlah_jam']}}</td>
    <td>{{$rs['keterangan']}}</td>
    <td>{{ \Carbon\Carbon::parse($rs['tanggal'])->toDateString() }}</td>
   </tr>
    @endforeach
</tbody>
</table>
</div>
</div>
<script>
    $(document).ready(function () {
        var table = $('#tbl').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    className: 'btn-excel' // Custom class for styling
                }
            ],
            initComplete: function () {
                // Add custom styles to the Excel export button
                $('.btn-excel').css({
                    'background-color': '#4caf50',
                    'color': '#fff',
                    'border': '1px solid #4caf50',
                    'border-radius': '3px',
                    'padding': '5px 10px',
                    'cursor': 'pointer'
                });

                // Hover effect for the Excel export button
                $('.btn-excel').hover(function () {
                    $(this).css({
                        'background-color': '#45a049',
                        'border': '1px solid #45a049'
                    });
                }, function () {
                    $(this).css({
                        'background-color': '#4caf50',
                        'border': '1px solid #4caf50'
                    });
                });
            }
        });
    });
</script>