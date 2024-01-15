 @php
    $selisih = (int)($tanggalSelesai->diff($tanggalMulai)->days);
    $inc = 1;
    $tanggalasliM = $tanggalMulai;
    $tanggalasliS = $tanggalSelesai;
@endphp
<div class="row">
    <div class="col-lg-12">
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col" style="text-align: center" colspan="{{ $selisih }}"></th>
                </tr>

                <tr>
                    <th scope="col" style="text-align: center" rowspan="3">No</th>
                    <th scope="col" style="text-align: center" rowspan="3">Nim</th>
                    <th scope="col" style="text-align: center" rowspan="5">Nama</th>
                </tr>
                <tr>
                    @for ($i = 0; $i <= $selisih; $i++)
                        <th scope="col" style="text-align: center" colspan="2">{{ $tanggalMulai->format('d-m-Y') }}</th>
                        @php $tanggalMulai->addDay(); @endphp
                    @endfor
                </tr>
                <tr>
                    @for ($i = 0; $i <= $selisih; $i++)
                        <th scope="col" style="text-align: center">IN</th>
                        <th scope="col" style="text-align: center">OUT</th>
                    @endfor
                </tr>
            </thead>
            @php
                 $sub = $selisih+1;
            @endphp

<tbody>
   @foreach ($dataMahasiswa as $dm)
        @php  
        $tanggalMulai->subDays($sub);
        $sub = 0;
        $sub1 = 1;
        @endphp
        <tr>
            <td>{{$inc}}</td>
            <td>{{$dm['nim']}}</td>
            <td>{{$dm['nama']}}</td>

            @foreach ($result as $mahasiswa)

                @if ($dm['nim'] == $mahasiswa['nim'])
                    @php
                        $cekTrue = false;
                        $cbix = 0;
                    @endphp

                    @foreach ($libur as $lbr)
                        @if ($tanggalMulai->format('Y-m-d') == \Carbon\Carbon::parse($lbr['tanggal'])->format('Y-m-d'))
                            @php
                                $cekTrue = true;
                            @endphp
                            <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td>
                            <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td>
                        @endif
                    @endforeach

                    @if (!$cekTrue)
                    @php $newtanggal =  \Carbon\Carbon::createFromFormat('d/m/Y', $mahasiswa['tanggal'])->format('Y-m-d') @endphp
                        @if ($tanggalMulai->format('Y-m-d') ==$newtanggal)
                            @php
                                $inTimeDateTime = \Carbon\Carbon::parse($mahasiswa['inTime']);
                                $outTimeDateTime = \Carbon\Carbon::parse($mahasiswa['outTime']);
                                $batasInTime = \Carbon\Carbon::parse('07:30:59');
                                $batasOutTime = \Carbon\Carbon::parse('16:30:00');
                                if ($inTimeDateTime > $batasInTime) {
                                    $selisihInTime = $inTimeDateTime->diffInSeconds($batasInTime);
                                } else {
                                    $selisihInTime = 0;
                                }
                                if ($outTimeDateTime < $batasOutTime) {
                                    $selisihOutTime = $outTimeDateTime->diffInSeconds($batasOutTime);
                                } else {
                                    $selisihOutTime = 0;
                                }
                            @endphp
                            @if ($inTimeDateTime->lt(\Carbon\Carbon::parse('12:00:00')))
                                @if ($selisihInTime > 0)
                                    <td style="color: tomato">{{$mahasiswa['inTime'] }}</td>
                                @else
                                    <td>{{ $mahasiswa['inTime']}}</td>
                                @endif
                            @else
                                <td style="background-color: tomato;"></td>
                            @endif

                            @if ($outTimeDateTime->gt(\Carbon\Carbon::parse('12:00:00')))
                                @if ($selisihOutTime > 0)
                                <td style="color: tomato">{{$mahasiswa['outTime'] }}</td>
                                @else
                                    <td>{{ $mahasiswa['outTime']}}</td>
                                @endif  
                            @else
                                <td style="background-color: tomato;"></td>
                            @endif
                        @else
                            @php
                                $tanggalMahasiswa =\Carbon\Carbon::createFromFormat('d/m/Y', $mahasiswa['tanggal']);
                                $selisih2 = $tanggalMahasiswa->diffInDays($tanggalMulai);
                            @endphp

                            @for ($j = 0; $j <= $selisih2; $j++)
                                @if ($tanggalMulai->format('Y-m-d') == $newtanggal)
                                    @php
                                    $inTimeDateTime = \Carbon\Carbon::parse($mahasiswa['inTime']);
                                    $outTimeDateTime = \Carbon\Carbon::parse($mahasiswa['outTime']);
                                    $batasInTime = \Carbon\Carbon::parse('07:30:00');
                                    $batasOutTime = \Carbon\Carbon::parse('16:30:00');
                                    if ($inTimeDateTime > $batasInTime) {
                                        $selisihInTime = $inTimeDateTime->diffInSeconds($batasInTime);
                                    } else {
                                        $selisihInTime = 0;
                                    }
                                    if ($outTimeDateTime < $batasOutTime) {
                                    $selisihOutTime = $outTimeDateTime->diffInSeconds($batasOutTime);
                                    } else {
                                        $selisihOutTime = 0;
                                    }
                                    $cekTrue = false;
                                    @endphp

                                    @foreach ($libur as $lbr)
                                    @if ($tanggalMulai->format('Y-m-d') == \Carbon\Carbon::parse($lbr['tanggal'])->format('Y-m-d'))
                                        @php
                                            $cekTrue = true;
                                        @endphp
                                        <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td>
                                        <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td>
                                    @endif
                                    @endforeach

                                    @if (!$cekTrue)
                                        @if ($inTimeDateTime->lt(\Carbon\Carbon::parse('12:00:00')))
                                            @if ($selisihInTime > 0)
                                                <td style="color: tomato">{{ $mahasiswa['inTime'] }}</td>
                                            @else
                                                <td>{{ $mahasiswa['inTime'] }}</td>
                                            @endif
                                        @else
                                            <td style="background-color: tomato;"></td>
                                        @endif

                                        @if ($outTimeDateTime->gt(\Carbon\Carbon::parse('12:00:00')))
                                            @if ($selisihOutTime > 0)
                                            <td style="color: tomato">{{$mahasiswa['outTime'] }}</td>
                                            @else
                                                <td>{{ $mahasiswa['outTime']}}</td>
                                            @endif  
                                        @else
                                            <td style="background-color: tomato;"></td>
                                        @endif
                                    @endif

                                @else
                                    @if ($tanggalMulai->lte($tanggalSelesai))
                                        @php
                                            $cekTrue = false;
                                            $cbix = 0;
                                        @endphp

                                        @foreach ($libur as $lbr)
                                        @if ($tanggalMulai->format('Y-m-d') == \Carbon\Carbon::parse($lbr['tanggal'])->format('Y-m-d'))
                                            @php
                                                $cekTrue = true;
                                            @endphp
                                            <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td>
                                            <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td>
                                        @endif
                                        @endforeach

                                        @if (!$cekTrue)
                                            <td style="background-color: tomato;"></td>
                                            <td style="background-color: tomato;"></td>
                                        @endif
                                    @endif
                                @endif

                                @if ($j < $selisih2)
                                    @php
                                        $tanggalMulai->addDay();
                                        $sub++;
                                    @endphp
                                @endif
                            @endfor
                        @endif 
                    @endif

                    @php
                        $tanggalMulai->addDay();
                        $sub++;
                    @endphp
                @endif
            @endforeach

            @php
                if ($tanggalSelesai >= $tanggalMulai) {
                    $selisih3 = $tanggalSelesai->diffInDays($tanggalMulai);
                } else {
                    $selisih3 = -1;
                }
               
            @endphp

            @if ($selisih3 >= 0)
                @for ($i = 0; $i <= $selisih3; $i++)
                    @php
                        $cekTrue = false;
                        $cbix = 0;
                    @endphp

                    @foreach ($libur as $lbr)
                    @if ($tanggalMulai->format('Y-m-d') == \Carbon\Carbon::parse($lbr['tanggal'])->format('Y-m-d'))
                        @php
                            $cekTrue = true;
                        @endphp
                        <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td>
                        <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td>
                    @endif
                    @endforeach

                    @if (!$cekTrue)
                        <td style="background-color: tomato;">{{ $selisih3}}</td>
                        <td style="background-color: tomato;">{{ $tanggalSelesai}}</td>
                    @endif

                    @php
                        $tanggalMulai->addDay();
                        $sub++;
                    @endphp
                @endfor
            @endif
        </tr>

        @php
            $inc++;
        @endphp
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