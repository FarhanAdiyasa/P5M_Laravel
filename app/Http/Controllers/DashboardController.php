<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login_User; // Assuming LoginUser is your model
use App\Models\Absen; // Assuming LoginUser is your model

use App\Models\P5M; // Assuming LoginUser is your model
use App\Models\log; 
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{


    public function sop()
    {
        $latestAbsen = Absen::orderBy('waktu', 'desc')->first();
        $latestWaktu = $latestAbsen ? date('d-m-Y', strtotime($latestAbsen->waktu)) : null;


        $model = collect(DB::select('EXEC sp_get_log'));

        $today = now()->format('Y-m-d');



        return view('KoordinatorSOP_dan_TATIB/dashboard_lihat', compact('latestWaktu', 'model'));
        

    }

    public function loadChart(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Truncate time part from startDate and endDate
        $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
        $endDate = date('Y-m-d 23:59:59', strtotime($endDate));

        $result = $this->getTotalPelanggaranData($startDate, $endDate);

        return view('KoordinatorSOP_dan_TATIB/dashboard_lihat.chart_pelanggaran', ['result' => $result]);
    }

    private function getTotalPelanggaranData($startDate, $endDate)
    {
        $result = DB::select("SELECT * FROM dbo.GetTotalPelanggaran(?, ?)", [$startDate, $endDate]);

        // Process the results if needed

        return $result;
    }

    
    public function tingkat()
    {
        return view('KoordinatorTingkat/dashboard_lihat');    
    }

}
