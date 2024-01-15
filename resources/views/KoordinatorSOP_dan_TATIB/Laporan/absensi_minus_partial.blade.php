@php
$selisih = (int)($tanggalSelesai->diff($tanggalMulai)->days);
$inc = 1;
$tanggalasliM = $tanggalMulai;
$tanggalasliS = $tanggalSelesai;
$sub = 0;
@endphp
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
@foreach ($dataMahasiswa as $dm)
    @php  
    $tanggalMulai->subDays($sub);
    $sub = 0;
    $sub1 = 1;
    $jam = 0;
    @endphp
    <tr>
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
                                @if ($selisihInTime > 1800)
                                    @php $totalHours = ceil($selisihInTime / 3600); $jam += $totalHours * 2; @endphp
                                @else
                                    @php  $jam+=1; @endphp
                                @endif  
                            @else
                                {{-- <td>{{ $mahasiswa['inTime']}}</td> --}}
                            @endif
                        @else
                                @php  $jam+=4; @endphp
                        @endif

                        @if ($outTimeDateTime->gt(\Carbon\Carbon::parse('12:00:00')))
                            @if ($selisihOutTime > 0)
                                @if ($selisihOutTime > 1800)
                                    @php $totalHours = ceil($selisihOutTime / 3600); $jam += $totalHours * 2; @endphp
                                @else
                                    @php  $jam+=1; @endphp
                                @endif  
                            @else
                                {{-- <td>{{ $mahasiswa['outTime']}}</td> --}}
                            @endif  
                        @else
                            @php  $jam+=4; @endphp
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
                                    $cekTrue = false;
                                @endphp

                                @foreach ($libur as $lbr)
                                @if ($tanggalMulai->format('Y-m-d') == \Carbon\Carbon::parse($lbr['tanggal'])->format('Y-m-d'))
                                    @php
                                        $cekTrue = true;
                                    @endphp
                                    {{-- <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td>
                                    <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td> --}}
                                @endif
                                @endforeach

                                @if (!$cekTrue)
                                    @if ($inTimeDateTime->lt(\Carbon\Carbon::parse('12:00:00')))
                                        @if ($selisihInTime > 0)
                                            {{-- <td style="color: tomato">{{ $mahasiswa['inTime'] }}</td> --}}
                                            @if ($selisihInTime > 1800)
                                                @php $totalHours = ceil($selisihInTime / 3600); $jam += $totalHours * 2; @endphp
                                            @else
                                                @php  $jam+=1; @endphp
                                            @endif  
                                        @else
                                            {{-- <td>{{ $mahasiswa['inTime'] }}</td> --}}
                                        @endif
                                    @else
                                        {{-- <td style="background-color: tomato;"></td> --}}
                                        @php  $jam+=4; @endphp
                                    @endif

                                    @if ($outTimeDateTime->gt(\Carbon\Carbon::parse('12:00:00')))
                                        @if ($selisihOutTime > 0)
                                        {{-- <td style="color: tomato">{{$mahasiswa['outTime'] }}</td> --}}
                                            @if ($selisihOutTime > 1800)
                                                @php $totalHours = ceil($selisihOutTime / 3600); $jam += $totalHours * 2; @endphp
                                            @else
                                                @php  $jam+=1; @endphp
                                            @endif      
                                        @else
                                            {{-- <td>{{ $mahasiswa['outTime']}}</td> --}}
                                        @endif  
                                    @else
                                        {{-- <td style="background-color: tomato;"></td> --}}
                                        @php  $jam+=4; @endphp
                                    @endif
                                @endif

                            @else
                                @if ($tanggalMulai->lte($tanggalSelesai))
                                    @if (!($tanggalMulai->isWeekend()))
                                        @php  $jam+=8; @endphp
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
                    {{-- <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td>
                    <td style="background-color: green; color:white">{{ $lbr['deskripsi'] }}</td> --}}
                @endif
                @endforeach

                @if (!$cekTrue)
                    @if (!($tanggalMulai->isWeekend()))
                        @php  $jam+=8; @endphp
                    @endif
                    {{-- <td style="background-color: tomato;">{{ $selisih3}}</td>
                    <td style="background-color: tomato;">{{ $tanggalSelesai}}</td> --}}
                @endif

                @php
                    $tanggalMulai->addDay();
                    $sub++;
                @endphp
            @endfor
        @endif
        <td>Murni</td>
        <td>{{$jam}}</td>
        <td>Rekap Absensi {{\Carbon\Carbon::parse($tanggalasliM)->toDateString()}} - {{\Carbon\Carbon::parse($tanggalasliS)->toDateString()}}</td>

<td>&nbsp;{{ now()->format('Y-m-d') }}&nbsp;</td>

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