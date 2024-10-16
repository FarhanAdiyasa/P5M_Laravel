<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use App\Models\Absen;
use App\Models\Libur;
use App\Models\Pelanggaran;
use App\Imports\AbsenImport;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AbsensiController extends Controller
{
    public function index()
    {
        $absen = DB::select('EXEC sp_get_all_absen');  

        return view('KoordinatorSOP_dan_TATIB/Daftar/daftarAbsensi', compact('absen'));    

    }
    public function downloadTemplate()
    {
        $templatePath = 'tesabsensi.xlsx';
    
        if (Storage::disk('public')->exists($templatePath)) {
            return response()->download(storage_path('app/public/' . $templatePath), 'tesabsensi.xlsx');
        } else {
            return response()->json(['error' => 'Template not found.'], 404);
        }
    }
    public function CetakAbsensiMinus($filterValue, $startDate, $endDate)
    {
        ini_set('max_execution_time', 10000); 
        try {
            $result = [];

            // Get data from the API
            $dataMahasiswa2 = $this->getMahasiswaFromApi();
            $dataMahasiswa = [];
            
            foreach ($dataMahasiswa2 as $mahasiswa) {
                if (isset($mahasiswa['kelas']) && $mahasiswa['kelas'] == $filterValue) {
                    $dataMahasiswa[] = $mahasiswa;
                }
            }
           
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate);
            // Get absensi data from the database

           
            $modifiedEndDate = $endDate->addDay()->startOfDay();
          //   dd( $startDate);
          $absensiResult = DB::select("SELECT * FROM GetAbsenViewByDateRange(?, ?) ORDER BY [nim], [tanggal]", [$startDate, $endDate]);
                $endDate->subDay();
              foreach ($dataMahasiswa as $mahasiswa) {
                  foreach ($absensiResult as $absen) {
              
                      if ( $mahasiswa['nim'] == $absen->nim) {
                      
                          $absensiData = [
                              'nim' => $absen->nim,
                              'nama' => $mahasiswa['nama'],
                              'tanggal' => $absen->tanggal,
                              'inTime' => $absen->in,
                              'outTime' => $absen->out,
                          ];
      
                          $result[] = $absensiData;
                      
                      }
                  }
                      
              }
              // dd($result);
            $libur = "";
            $modifiedEndDate2 = $endDate->addDay();
                  $libur = Libur::whereBetween('lbr_tanggal', [$startDate, $modifiedEndDate2])
                  ->get();
                  $endDate->subDay();
            $kelas = $filterValue;
            $tanggalMulai = $startDate;
            $tanggalSelesai = $endDate;
          //   dd($result);
            return view('KoordinatorSOP_dan_TATIB/Cetak/CetakLaporanJamMinusAbsensi', compact(
                'result',
                'dataMahasiswa',
                'kelas',
                'libur',
                'tanggalMulai',
                'startDate',
                'tanggalSelesai',
            ));

        } catch (\Exception $ex) {
          dd($ex->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    
    public function import(Request $request)
<<<<<<< HEAD
    {
        try 
        {
            $uploaddir = 'excel/';
            $uploadfile = $uploaddir . basename($_FILES['file']['name']); 
            move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile); 
            $file = 'excel/' . $_FILES['file']['name']; 
            $reader = IOFactory::createReader('Xlsx');
            $extension = pathinfo($file, PATHINFO_EXTENSION);
=======
{
    ini_set('max_execution_time', 120); 
    try {
        $uploaddir = 'excel/';
        $uploadfile = $uploaddir . basename($_FILES['file']['name']); 
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile); 
        $file = 'excel/' . $_FILES['file']['name']; 
        $reader = IOFactory::createReader('Xlsx');
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        if ($extension != 'xlsx') {
            return redirect()->route('import')->with('error', 'File harus berformat XLSX.');
        }

        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file);        

        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();
        $totalRows = count($data) - 2;


        if($data[1][3]=="PIN" && $data[1][0]=="Tanggal scan") {
            $totalRows = count($data);
            $importedRows = 0;

            for ($i = 2; $i < $totalRows; $i++) {
                $nim = $data[$i][3];
                $waktu = \Carbon\Carbon::parse($data[$i][0]);

                $absenExists = Absen::where('abs_nim', $nim)->where('abs_waktu', $waktu)->exists();
                if (!$absenExists) {
                    $absen = new Absen;
                    $absen->abs_nim = $nim;
                    $absen->abs_waktu = $waktu;
                    $absen->save();
                    $importedRows++;
                }
                $request->session()->put('importProgress', ['totalRows' => $totalRows, 'importedRows' => $importedRows]);
>>>>>>> c0a39bad8c170a13fec68eacee30044de8de092e

            if ($extension != 'xlsx') {
                return redirect()->route('import')->with('error', 'File harus berformat XLSX.');
            }

            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file);        

            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();
            $totalRows = count($data) - 2;

            if($data[1][3]=="PIN" && $data[1][0]=="Tanggal scan") {
                $totalRows = count($data);
                $importedRows = 0;

                for ($i = 2; $i < $totalRows; $i++) {
                    $nim = $data[$i][3];
                    $waktu = \Carbon\Carbon::parse($data[$i][0]);

                    $absenExists = Absen::where('nim', $nim)->where('waktu', $waktu)->exists();
                    if (!$absenExists) {
                        $absen = new Absen;
                        $absen->nim = $nim;
                        $absen->waktu = $waktu;
                        $absen->save();
                        $importedRows++;
                    }
                    $request->session()->put('importProgress', ['totalRows' => $totalRows, 'importedRows' => $importedRows]);

                }
            } else {
                return redirect()->route('import')->with('error', 'Kolom Tidak Sesuai');
            }
            $request->session()->forget('importProgress');
            echo '<script type="text/javascript">removeBlur();</script>';
            return redirect()->route('import')->with('success', 'Import '.$importedRows." Baris Berhasil");
        
        } catch (Exception $e) {
            dd($e->getMessage(), $file);
        }
    }

    public function getImportProgress(Request $request)
    {
        dd($request);
        $progress = $request->session()->get('importProgress', ['totalRows' => 0, 'importedRows' => 0]);
        return response()->json($progress);
    }

    public function soplapabsensi()
    {
        $apiUrl = "https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3";

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $dataMahasiswa = $response->json();

            $kelasMahasiswa = collect($dataMahasiswa)->pluck('kelas')->unique()->values()->all();

            return view('KoordinatorSOP_dan_TATIB/Laporan/laporan_Absensi', ['KelasMahasiswa' => $kelasMahasiswa]);
        }
        
     }

    public function soplapmnsabsen()
    {
        $apiUrl = "https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3";

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $dataMahasiswa = $response->json();

            $kelasMahasiswa = collect($dataMahasiswa)->pluck('kelas')->unique()->values()->all();

            return view('KoordinatorSOP_dan_TATIB/Laporan/laporan_jam_minus_absensi', ['KelasMahasiswa' => $kelasMahasiswa]);
        }
        
     }

    public function GetMahasiswaFromApi()
    {
         $apiUrl = "https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3";
 
         $response = Http::get($apiUrl);
 
         if ($response->successful()) {
             $dataMahasiswa = $response->json();

             return $dataMahasiswa;
         }else{
            return null;
         }
         
    }

<<<<<<< HEAD
    public function loadPartialView($filterValue, $startDate, $endDate)
    {
        try 
        {
=======
      public function loadPartialView($filterValue, $startDate, $endDate)
      {
        ini_set('max_execution_time', 10000); 
        try {
>>>>>>> c0a39bad8c170a13fec68eacee30044de8de092e
            $result = [];
  
            // Get data from the API
            $dataMahasiswa2 = $this->getMahasiswaFromApi();
            $dataMahasiswa = [];

            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->addDay();
            
            foreach ($dataMahasiswa2 as $mahasiswa) {
                if (isset($mahasiswa['kelas']) && $mahasiswa['kelas'] == $filterValue) {
                    $dataMahasiswa[] = $mahasiswa;
                }
            }
            $query = "EXEC sp_laporan_jamMinus @startdate = '". $startDate."', @enddate = '".$endDate."'";
            $absensiResult = DB::select($query);
               
            foreach ($dataMahasiswa as $mahasiswa) {
                foreach ($absensiResult as $absen) {
                    if ( $mahasiswa['nim'] == $absen->Nim) {
                        
                        $absensiData = [
                            'nim' => $absen->Nim,
                            'nama' => $mahasiswa['nama'],
                            'jenis' => 'Murni',
                            'jumlah_jam' => $absen->Jumlah_Jam,
                            'keterangan' => 'Rekap Jam Minus P5M Periode '.\Carbon\Carbon::parse($startDate)->toDateString().' - '.\Carbon\Carbon::parse($endDate->subDay())->toDateString(),
                            'tanggal' => now(),
                        ];
    
                        $result[] = $absensiData;
                    
                    }
                }

            }
            return view('KoordinatorSOP_dan_TATIB/Laporan/p5m_partial', compact(
                'result',
            ));
         
        } catch (\Exception $ex) {
            dd($ex->getMessage());
              return response()->json(['error' => 'Internal Server Error'], 500);
          }
          
<<<<<<< HEAD
    }

    public function loadPartialViewAbsensi($filterValue, $startDate, $endDate)
    {
        try 
        {
            $result = [];
=======
        }
      public function loadPartialViewAbsensi($filterValue, $startDate, $endDate)
      {
        ini_set('max_execution_time', 10000); 
          try {
              $result = [];
>>>>>>> c0a39bad8c170a13fec68eacee30044de8de092e
  
            // Get data from the API
            $dataMahasiswa2 = $this->getMahasiswaFromApi();
            $dataMahasiswa = [];
              
            foreach ($dataMahasiswa2 as $mahasiswa) 
            {      
                if (isset($mahasiswa['kelas']) && $mahasiswa['kelas'] == $filterValue) {
                      $dataMahasiswa[] = $mahasiswa;
                  }
            }
             
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate);
            // Get absensi data from the database
             
            $modifiedEndDate = $endDate->addDay()->startOfDay();
            //   dd( $startDate);
            $absensiResult = DB::select("SELECT * FROM GetAbsenViewByDateRange(?, ?) ORDER BY [nim], [tanggal]", [$startDate, $endDate]);
                  $endDate->subDay();
                foreach ($dataMahasiswa as $mahasiswa) {
                    foreach ($absensiResult as $absen) {
                
                        if ( $mahasiswa['nim'] == $absen->nim) {
                        
                            $absensiData = [
                                'nim' => $absen->nim,
                                'nama' => $mahasiswa['nama'],
                                'tanggal' => $absen->tanggal,
                                'inTime' => $absen->in,
                                'outTime' => $absen->out,
                            ];
        
                            $result[] = $absensiData;
                        
                        }
                    }
                        
                }
                // dd($result);
              $libur = "";
              $modifiedEndDate2 = $endDate->addDay();
                    $libur = Libur::whereBetween('lbr_tanggal', [$startDate, $modifiedEndDate2])
                    ->get();
                    $endDate->subDay();
              $kelas = $filterValue;
              $tanggalMulai = $startDate;
              $tanggalSelesai = $endDate;
            //   dd($result);
              return view('KoordinatorSOP_dan_TATIB/Laporan/absensi_partial', compact(
                  'result',
                  'dataMahasiswa',
                  'kelas',
                  'libur',
                  'tanggalMulai',
                  'startDate',
                  'tanggalSelesai',
              ));

        } catch (\Exception $ex) {
            dd($ex->getMessage());
              return response()->json(['error' => 'Internal Server Error'], 500);
<<<<<<< HEAD
        }
    }

    public function loadPartialViewAbsensiMinus($filterValue, $startDate, $endDate)
    {
        try {
=======
          }
      }
      public function loadPartialViewAbsensiMinus($filterValue, $startDate, $endDate)
      {
        ini_set('max_execution_time', 10000); 
          try {
>>>>>>> c0a39bad8c170a13fec68eacee30044de8de092e
              $result = [];
  
              // Get data from the API
              $dataMahasiswa2 = $this->getMahasiswaFromApi();
              $dataMahasiswa = [];
              
              foreach ($dataMahasiswa2 as $mahasiswa) {
                  if (isset($mahasiswa['kelas']) && $mahasiswa['kelas'] == $filterValue) {
                      $dataMahasiswa[] = $mahasiswa;
                  }
              }
             
              $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
              $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate);
              // Get absensi data from the database

             
              $modifiedEndDate = $endDate->addDay()->startOfDay();
            $absensiResult = DB::select("SELECT * FROM GetAbsenViewByDateRange(?, ?) ORDER BY [nim], [tanggal]", [$startDate, $endDate]);
                  $endDate->subDay();
                foreach ($dataMahasiswa as $mahasiswa) {
                    foreach ($absensiResult as $absen) {
                
                        if ( $mahasiswa['nim'] == $absen->nim) {
                        
                            $absensiData = [
                                'nim' => $absen->nim,
                                'nama' => $mahasiswa['nama'],
                                'tanggal' => $absen->tanggal,
                                'inTime' => $absen->in,
                                'outTime' => $absen->out,
                            ];
        
                            $result[] = $absensiData;
                        
                        }
                    }
                        
                }
              $libur = "";
              $modifiedEndDate2 = $endDate->addDay();
                    $libur = Libur::whereBetween('lbr_tanggal', [$startDate, $modifiedEndDate2])
                    ->get();
                    $endDate->subDay();
              $kelas = $filterValue;
              $tanggalMulai = $startDate;
              $tanggalSelesai = $endDate;
              return view('KoordinatorSOP_dan_TATIB/Laporan/absensi_minus_partial', compact(
                  'result',
                  'dataMahasiswa',
                  'kelas',
                  'libur',
                  'tanggalMulai',
                  'startDate',
                  'tanggalSelesai',
              ));

          } catch (\Exception $ex) {
              return response()->json(['error' => $ex->getMessage()], 500);
          }
      }
  
}
