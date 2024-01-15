<div class="row">
    <div class="col-lg-12">
        <table class="table datatable">
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
    <td>{{$rs['tanggal']}}</td>
   </tr>
    @endforeach
</tbody>
</table>
</div>
</div>

<script>
$(document).ready(function () {
// Initialize Datatables for the second table
var table = new simpleDatatables.DataTable('.datatable');
});
</script>