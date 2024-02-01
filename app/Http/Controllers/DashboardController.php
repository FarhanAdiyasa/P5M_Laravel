<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login_User; // Assuming LoginUser is your model
use App\Models\Absen; // Assuming LoginUser is your model

use App\Models\P5M; // Assuming LoginUser is your model
use App\Models\log; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class DashboardController extends Controller
{


    public function index()
    {
        $latestAbsen = Absen::orderBy('waktu', 'desc')->first();
        $latestWaktu = $latestAbsen ? date('d-m-Y', strtotime($latestAbsen->waktu)) : null;


        $model = collect(DB::select('EXEC sp_get_log'));
        $today = now()->format('Y-m-d');

        $response = $this->downloadAktifitas();

        return view('KoordinatorSOP_dan_TATIB/dashboard_lihat', compact('latestWaktu', 'model', 'response'));
        

    }

    public function downloadAktifitas()
    {
        $data = DB::select('EXEC sp_get_log'); // Corrected stored procedure call
        

        // Extracting the 'tanggal' and 'aktifitas' columns from the result
        $formattedData = array_map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'aktifitas' => $item->aktifitas,
            ];
        }, $data);
    
        $jsonData = json_encode($formattedData, JSON_PRETTY_PRINT);
    
        $response = response($jsonData)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename=sistemP5M_aktifitas.txt');
    
        return $response;
    }
    public function getTotalPelanggaranData($startDate, $endDate)
    {
        // Set the end time to 23:59:59
        $endDate = Carbon::parse($endDate)->endOfDay();

        // Using raw query to call the SQL function
        $result = DB::select('SELECT * FROM dbo.GetTotalPelanggaran(?, ?)', [$startDate, $endDate->addDay()]);

        // Create a new array to store the calculated results
        $calculatedResults = [];

        // Calculate total pelanggaran
        foreach ($result as $item) {
            $calculatedResults[] = [
                'nama_pelanggaran' => $item->nama_pelanggaran,
                'total_pelanggaran_dilakukan' => $item->total_pelanggaran_dilakukan,
            ];
        }
        return view("KoordinatorSOP_dan_TATIB/partial_chart/_chartPelanggaran", compact(['calculatedResults']));
    }

    public function GetNimPelanggaranData($startDate, $endDate)
    {
        // Set the end time to 23:59:59
        $endDate = Carbon::parse($endDate)->endOfDay();

        // Using raw query to call the SQL function
        $result = DB::select('SELECT TOP 5 * FROM dbo.GetNimPelanggaran(?, ?)', [$startDate, $endDate->addDay()]);

        // Create a new array to store the calculated results
        $calculatedResults = [];

        // Calculate total pelanggaran
        foreach ($result as $item) {
            $calculatedResults[] = [
                'nama_pelanggaran' => $item->nama_pelanggaran,
                'total_pelanggaran_dilakukan' => $item->total_pelanggaran_dilakukan
            ];
        }
        return view("KoordinatorSOP_dan_TATIB/partial_chart/_chartNimPelanggaran", compact(['calculatedResults']));
    }

    
    public function tingkat()
    {
        return view('KoordinatorTingkat/dashboard_lihat');    
    }

}
