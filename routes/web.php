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
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

/*Koordinator SOP dan TATIB Route*/

Route::get('sop', [DashboardController::class, 'sop']);
Route::get('/sop/download', [DashboardController::class, 'downloadAktifitas']);


Route::get('user_lihat', [PenggunaController::class, 'index']);
Route::get('/penggunainput',[PenggunaController::class,'pengguna_input']);
Route::post('/pengguna/insert',[PenggunaController::class,'save']);
Route::get('/penggunaedit/{id}',[PenggunaController::class,'pengguna_edit']);
Route::post('/pengguna/update',[PenggunaController::class,'update']);
Route::get('/pengguna/delete/{id}',[PenggunaController::class,'delete']);

Route::get('mahasiswa', [MahasiswaController::class, 'index']);
Route::get('/mahasiswainput',[MahasiswaController::class,'mahasiswa_input']);
Route::post('/mahasiswa/insert',[MahasiswaController::class,'save']);
Route::get('/mahasiswaedit/{id}',[MahasiswaController::class,'mahasiswa_edit']);
Route::post('/mahasiswa/update',[MahasiswaController::class,'update']);
Route::get('/mahasiswa/delete/{id}',[MahasiswaController::class,'delete']);

Route::get('/libur', [LiburController::class, 'libur']);

Route::get('/pelanggaran', [PelanggaranController::class, 'index']);
Route::get('/pelanggaraninput',[PelanggaranController::class,'pelanggaran_input']);
Route::post('/pelanggaran/insert',[PelanggaranController::class,'save']);
Route::get('/pelanggaranedit/{id}',[PelanggaranController::class,'pelanggaran_edit']);
Route::post('/pelanggaran/update',[PelanggaranController::class,'update']);
Route::get('/pelanggaran/delete/{id}',[PelanggaranController::class,'delete']);

Route::any('/p5msop', [P5MController::class, 'p5msop']);
Route::post('/p5msop/tambah', [P5MController::class, 'tambah']);
Route::post('p5mlihat', [P5MController::class, 'p5mlihat']);
Route::get('history_lihat', [P5MController::class, 'p5msophistory']);
Route::any('laporan_jam_minus', [P5MController::class, 'laporanp5m']);

Route::get('daftarAbsensi', [AbsensiController::class, 'index']);
Route::post('/daftarAbsensi/import_excel', [AbsensiController::class, 'import_excel']);
Route::any('laporan_absensi', [AbsensiController::class, 'soplapabsensi']);
Route::any('laporanJamMinusAbsensi', [AbsensiController::class, 'soplapmnsabsen']);

/*Koordinator Tingkat Route*/

Route::get('tingkat', [DashboardController::class, 'tingkat']);

Route::get('p5mtingkat', [P5MController::class, 'p5mtingkat']);
Route::get('p5mtingkathistory', [P5MController::class, 'p5mtingkathistory']);

Route::get('tingkatlapabsensi', [AbsensiController::class, 'tingkatlapabsensi']);
Route::get('tingkatlapmnsabsen', [AbsensiController::class, 'tingkatlapmnsabsen']);




