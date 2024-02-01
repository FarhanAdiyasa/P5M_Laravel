
<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SSOController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\P5MController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\LiburController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin')->middleware('guest');



Route::get('dashboard', [DashboardController::class, 'index'])->name("idx");

Route::middleware(['role:KOORDINATOR SOP dan TATIB'])->group(function () {
    Route::get('pengguna', [PenggunaController::class, 'index'])->name("p.index");
    Route::get('/pengguna/tambah',[PenggunaController::class,'pengguna_input'])->name("p.create");
    Route::post('/pengguna/insert',[PenggunaController::class,'save']);
    Route::get('/pengguna/edit/{id}',[PenggunaController::class,'pengguna_edit'])->name("p.edit");
    Route::post('/pengguna/update',[PenggunaController::class,'update']);
    Route::get('/pengguna/delete/{id}',[PenggunaController::class,'delete']);

    Route::post('/checkUserExistence', [PenggunaController::class, 'checkUserExistence'])->name('checkUserExistence');
    Route::post('/checkUserExistenceEdit', [PenggunaController::class, 'checkUserExistenceEdit'])->name('checkUserExistenceEdit');

    Route::get('/pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran');
    Route::get('/pelanggaraninput',[PelanggaranController::class,'pelanggaran_input']);
    Route::post('/pelanggaran/insert',[PelanggaranController::class,'save']);
    Route::get('/pelanggaranedit/{id}',[PelanggaranController::class,'pelanggaran_edit']);
    Route::post('/pelanggaran/update',[PelanggaranController::class,'update']);
    Route::get('/pelanggaran/delete/{id}',[PelanggaranController::class,'delete']);
    
    Route::get('histori_p5m', [P5MController::class, 'pilih_kelas'])->name('pilihkls');
    Route::get('/libur', [LiburController::class, 'libur']);
    Route::post('/import_absensi',[AbsensiController::class,'import'])->name('import');
    Route::get('/getImportProgress', [AbsensiController::class, 'getImportProgress'])->name('progress');

    Route::get('/download/template', [AbsensiController::class, 'downloadTemplate'])->name('download.template');

});


Route::middleware(['auth'])->group(function () {
    Route::get('sso', [SSOController::class, 'index'])->name('sso');
    Route::get('ssoLog/{role}', [SSOController::class, 'ssoLog'])->name('ssoLog');
    Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');

    Route::get('mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa');
    Route::get('/mahasiswainput',[MahasiswaController::class,'mahasiswa_input']);
    Route::post('/mahasiswa/insert',[MahasiswaController::class,'save']);
    Route::get('/mahasiswaedit/{id}',[MahasiswaController::class,'mahasiswa_edit']);
    Route::post('/mahasiswa/update',[MahasiswaController::class,'update']);
    Route::get('/mahasiswa/delete/{id}',[MahasiswaController::class,'delete']);
    
    Route::get('/P5M/LoadPartialViewAbsen/{filterValue}/{startDate}/{endDate}', [AbsensiController::class, 'loadPartialViewAbsensi'])->name('partial.absen');
    Route::get('/P5M/LoadPartialViewAbsenMinus/{filterValue}/{startDate}/{endDate}', [AbsensiController::class, 'loadPartialViewAbsensiMinus'])->name('partial.absen.minus');
    Route::get('/P5M/LoadPartialView/{filterValue}/{startDate}/{endDate}', [AbsensiController::class, 'loadPartialView'])->name('partial.p5m');
    
    Route::any('p5m', [P5MController::class, 'p5msop'])->name('p5m');
    
    Route::post('/p5m/tambah', [P5MController::class, 'tambah'])->name('p5m.create');
    Route::post('p5mlihat', [P5MController::class, 'p5mlihat']);
    Route::get('history_lihat', [P5MController::class, 'p5msophistory']);
    Route::any('laporan_jam_minus', [P5MController::class, 'laporanp5m']);

    Route::any('histori_p5m/{kelas}', [P5MController::class, 'pilih_tanggal'])->name('pilikls');
    
    
    Route::get('import_absensi', [AbsensiController::class, 'index'])->name('import');
    Route::post('/daftarAbsensi/import_excel', [AbsensiController::class, 'import_excel']);
    Route::get('laporan_absensi', [AbsensiController::class, 'soplapabsensi'])->name('laporan_absensi');
    Route::any('laporan_jam_minus_absensi', [AbsensiController::class, 'soplapmnsabsen'])->name('LjamMinusAbs');
    
    
    
    Route::get('tingkat', [DashboardController::class, 'tingkat']);
    
    Route::get('p5mtingkat', [P5MController::class, 'p5mtingkat']);
    Route::get('p5mtingkathistory', [P5MController::class, 'p5mtingkathistory']);
    
    Route::get('tingkatlapabsensi', [AbsensiController::class, 'tingkatlapabsensi']);
    Route::get('tingkatlapmnsabsen', [AbsensiController::class, 'tingkatlapmnsabsen']);
    Route::get('/LoadChart/{startDate}/{endDate}', [DashboardController::class, 'getTotalPelanggaranData']);
    
    Route::get('/LoadChartNim/{startDate}/{endDate}', [DashboardController::class, 'GetNimPelanggaranData']);
});  




