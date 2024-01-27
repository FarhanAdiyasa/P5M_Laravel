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


Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('login', [LoginController::class, 'login'])->name('login');

Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('sso', [SSOController::class, 'index'])->name('sso')->middleware('auth');
Route::get('ssoLog/{role}', [SSOController::class, 'ssoLog'])->name('ssoLog')->middleware('auth');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

/*Koordinator SOP dan TATIB Route*/



Route::get('mahasiswa', [MahasiswaController::class, 'index']);
Route::get('/mahasiswainput',[MahasiswaController::class,'mahasiswa_input']);
Route::post('/mahasiswa/insert',[MahasiswaController::class,'save']);
Route::get('/mahasiswaedit/{id}',[MahasiswaController::class,'mahasiswa_edit']);
Route::post('/mahasiswa/update',[MahasiswaController::class,'update']);
Route::get('/mahasiswa/delete/{id}',[MahasiswaController::class,'delete']);


Route::get('/P5M/LoadPartialViewAbsen/{filterValue}/{startDate}/{endDate}', [AbsensiController::class, 'loadPartialViewAbsensi'])->name('partial.absen');
Route::get('/P5M/LoadPartialViewAbsenMinus/{filterValue}/{startDate}/{endDate}', [AbsensiController::class, 'loadPartialViewAbsensiMinus'])->name('partial.absen.minus');
Route::get('/P5M/LoadPartialView/{filterValue}/{startDate}/{endDate}', [AbsensiController::class, 'loadPartialView'])->name('partial.p5m');

Route::any('p5msop', [P5MController::class, 'p5msop']);

Route::get('pilihkls', [P5MController::class, 'pilih_kelas']);
Route::get('/pilihkls/{kelas}', [P5MController::class, 'pilih_tanggal']);


Route::post('/p5msop/tambah', [P5MController::class, 'tambah']);
Route::post('p5mlihat', [P5MController::class, 'p5mlihat']);
Route::get('history_lihat', [P5MController::class, 'p5msophistory']);
Route::any('laporan_jam_minus', [P5MController::class, 'laporanp5m']);

Route::get('daftarAbsensi', [AbsensiController::class, 'index'])->name('import');
Route::post('/daftarAbsensi/import_excel', [AbsensiController::class, 'import_excel']);
Route::get('laporan_absensi', [AbsensiController::class, 'soplapabsensi']);
Route::any('laporanJamMinusAbsensi', [AbsensiController::class, 'soplapmnsabsen']);

/*Koordinator Tingkat Route*/

Route::get('tingkat', [DashboardController::class, 'tingkat']);

Route::get('p5mtingkat', [P5MController::class, 'p5mtingkat']);
Route::get('p5mtingkathistory', [P5MController::class, 'p5mtingkathistory']);

Route::get('tingkatlapabsensi', [AbsensiController::class, 'tingkatlapabsensi']);
Route::get('tingkatlapmnsabsen', [AbsensiController::class, 'tingkatlapmnsabsen']);




