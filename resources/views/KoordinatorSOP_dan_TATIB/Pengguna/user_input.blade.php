<?php
  
  $url = file_get_contents('https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListMahasiswa?id_konsentrasi=3');
  $dataMahasiswa = json_decode($url, true);

  $curl = curl_init();
  
  $url = "https://api.polytechnic.astra.ac.id:2906/api_dev/efcc359990d14328fda74beb65088ef9660ca17e/SIA/getListKaryawan";

  $ch = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.polytechnic.astra.ac.id:2906/api_dev/AccessToken/Get",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(array(
        "username" => '0320210041',
        "password" => '',
        "grant_type" => "password"
    ))
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  $data = json_decode($response, true);
  
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer " . $data['access_token']
  ));

  $response = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  if ($http_code != 200) {
      echo "Failed to retrieve data. Response code: " . $http_code;
      exit;
  }

  $data = json_decode($response, true);

  curl_close($ch);
?>

@extends('KoordinatorSOP_dan_TATIB.layout.header')

@section('konten')
    <main id="main" class="main">

        <div class="pagetitle">
            <br>
            <h1>Tambah Pengguna</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Pengguna</li>
            </ol>
        </div>

        <section class="section dashboard">
            <div class="col-12">
                <div class="card">
                    <div class="container-fluid pt-4 px-4">
                        <div class="row g-8">
                            <br/>
                            <form role="form" action="{{ url('pengguna/insert') }}" method="post" id="penggunaForm">
                                @csrf

                                <br>
                                <div class="form-group">

                                    <label for="png_nama">Nama Pengguna<span style="color: red">*</span></label>
                                    <select name="png_nama" class="form-select" style="width:100%" required id="pilihPengguna">
                                        <option value="">-- Pilih Nama Pengguna --</option>

                                        <?php
                                        $kelas = [];

                                        $i = 0;
                                        foreach ($data as $d) {
                                            $i++;
                                            if ($data[$i - 1]['struktur'] == 'Unit Pelayanan Teknis Informatika' || $data[$i - 1]['struktur'] == 'Prodi MI') {
                                                array_push($kelas, $data[$i - 1]['nama']);
                                            }
                                                                                    }

                                        sort($kelas);
                                        $uniqueKelas = array_unique($kelas);

                                        foreach ($uniqueKelas as $kelasItem) {
                                            echo "<option value='" . $kelasItem . "'>" . $kelasItem . "</option>";
                                        }
                                        ?>
                                    </select>
                                    @error('png_nama')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <br>

                                <input type="hidden" name="png_username" id="png_username" value="">
                            <input type="hidden" name="png_nama" id="png_nama" value="">

                                <div class="form-group">
                                    <label for="png_role">Role<span style="color: red">*</span></label>
                                    <select name="png_role" class="form-select" style="width:100%" required id="png_role" onchange="cekExist()">
                                        <option value="">-- Pilih Role --</option>
                                        <option value="KOORDINATOR SOP dan TATIB">KOORDINATOR SOP dan TATIB</option>
                                        <option value="KOORDINATOR TINGKAT">KOORDINATOR TINGKAT</option>
                                        <option value="SEKRETARIS PRODI">SEKRETARIS PRODI</option>
                                    </select>
                                    @error('png_role')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <br>

                                <div class="form-group kelas-field">
                                    <label for="png_kelas">Kelas<span style="color: red">*</span></label>
                                    <select name="png_kelas" class="form-select" style="width:100%" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @php
                                            $kelas = [];
                                            $semuaKelas = 'Semua kelas';
                                            $i = 0;
                                            foreach ($dataMahasiswa as $dm) {
                                                $i++;
                                                array_push($kelas, $dataMahasiswa[$i - 1]['kelas']);
                                            }
                                            sort($kelas);
                                            $arrayLength = count($kelas);
                                        @endphp
                                        @for ($i = 1; $i < $arrayLength; $i++)
                                            @if ($kelas[$i] != $kelas[$i - 1])
                                                <option value="{{ $kelas[$i] }}">{{ $kelas[$i] }}</option>
                                            @endif
                                        @endfor
                                    </select>
                                    @error('png_kelas')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <br>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="png_status" value="1" hidden>
                                </div>

                                <button type="reset" class="btn btn-secondary m-2" data-dismis="modal"
                                        onclick="history.go(-1);">Kembali
                                </button>
                                &nbsp; &nbsp;
                                <button type="submit" class="btn btn-primary m-2">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
    $(document).ready(function () {
        function changeRole() {
            $('#png_role').on('change', function () {
                var selectedRole = $('#png_role option:selected').val();
                if (selectedRole === 'KOORDINATOR TINGKAT') {
                    $('.kelas-field').show();
                    $('select[name="kelas"]').prop('required', true);
                } else {
                    $('.kelas-field').hide();
                    $('select[name="kelas"]').prop('required', false);
                }
            });
        }

        function changePengguna() {
            $('#pilihPengguna').on('change', function () {
                var selectedUsername = $('#pilihPengguna option:selected').val();
                $('#png_username').val(selectedUsername);
                cekExist(selectedUsername);
                var selectedNamaPengguna = $('#pilihPengguna option:selected').text();
                $('#png_nama').val(selectedNamaPengguna);
                console.log(selectedUsername, selectedNamaPengguna);
            });
        }

        $('.kelas-field').hide();
        changeRole();
        changePengguna();

        $('.validasi').on('click', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        Swal.fire({
            title: 'Yakin data ingin dihapus?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete route with the correct parameter
                window.location.href = "{{ url('pengguna/CheckUserExistence') }}/" + id;
            }
        });
    });
    });

    const cekExist = (selectedUsername = null) => {
        var selectedRole = $('#png_role option:selected').val();

        if (selectedUsername == null) {
            selectedUsername = $('#png_username').val();
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
        url: "{{route('checkUserExistence')}}",
        type: 'POST', 
        headers: {
        'X-CSRF-TOKEN': csrfToken
        },
        data: { png_username: selectedUsername, png_role: selectedRole },
       
        success: function (result) {
            if (result.exists ) {
                Swal.fire({
                    title: "Error",
                    text: "User with the same username and role already exists.",
                    icon: "error",
                    buttons: {
                        confirm: {
                            text: "OK",
                            value: true,
                            visible: true,
                            className: "btn btn-danger",
                            closeModal: true
                        }
                    }
                });
                $('#penggunaForm')[0].reset();
            }
            console.log(result);
        },
        error: function (error) {
            console.log(error);
        }
    });

        
        if (selectedRole === 'KOORDINATOR SOP dan TATIB' || selectedRole === 'SEKRETARIS PRODI') {
            $('select[name="kelas"]').val('Semua kelas');
        }
    }
</script>
    </main>
@endsection
