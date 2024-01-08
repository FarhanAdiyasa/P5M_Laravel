@extends('KoordinatorTingkat.layout.header')

@section('konten')

<main id="main" class="main">

    <div class="pagetitle">
        <br>
        <h1>History P5M</h1>
        <br>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <br>

                    <form action="" method="post" name="pilih" id="pilih">
                        <label for="birthday">Kelas &nbsp:</label>
                        <select class="form-select" style="width:20%; display:inline;" name="dropdown">
                            <?php
                            $DdlKelas = ''; // Initialize $DdlKelas here

                            $sql = "SELECT kelas FROM pengguna WHERE nama_pengguna = ? AND status = 1";

                            // Check if 'nama' key is set in the cookie
                            if (isset($_COOKIE['nama'])) {
                                $where = $_COOKIE['nama'];

                                // Assuming $this->db is an instance of the database connection (you might need to adjust this)
                                $machine = $this->db->query($sql, $where);

                                foreach ($machine->result() as $m) {
                                    $DdlKelas = $m->kelas;
                                    echo "<option value='" . $DdlKelas . "'>" . $DdlKelas . "</option>";
                                }
                            } else {
                                // Handle the case when 'nama' is not set in the cookie
                                // You might want to set a default value or show an error message
                                echo "<option value='default_value'>Kelas</option>";
                            }
                            ?>
                        </select>
                        &nbsp&nbsp
                        <input type="submit" id="cetak" name="cetak" class="btn btn-primary" value="Pilih" />
                    </form>

                    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Hari dan Tanggal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>

                                <?php

                                $tgl_sebelumnya = "";

                                foreach ($p5m as $h) {

                                    if ($h->kelas == $_POST['dropdown']) {

                                        if ($h->tgl_transaksi != $tgl_sebelumnya) {
                                ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?php $i++; ?>
                                                    <?php echo $i ?>
                                                </td>
                                                <td class="text-center"><?php echo $h->tgl_transaksi ?></td>
                                                <td class="text-center">
                                                    <form action="<?php echo site_url('P5MTingkat/lihat_p5m/'); ?>"
                                                        method="post" name="cetak" id="cetak">
                                                        <button class="btn btn-info fa fa-list" type="submit"></button>
                                                        <input type="hidden" id="tanggalTransaksi" name="tanggalTransaksi"
                                                            value="<?php echo $h->tgl_transaksi; ?>" />
                                                        <input type="hidden" id="kelasHistory" name="kelasHistory"
                                                            value="<?php echo $h->kelas; ?>" />
                                                    </form><br>
                                                </td>
                                            </tr>
                                <?php
                                            $tgl_sebelumnya = $h->tgl_transaksi;
                                        }
                                    }
                                }
                                ?>
                            </tbody>

                        </table>
                        <br>
                        <!-- <button type="submit" class="btn btn-primary m-2">Simpan</button>   -->
                        <br>
                        <!-- </form> -->
                    <?php } ?>

                </div>

            </div>
        </div><!-- End Recent Sales -->

    </section>

</main><!-- End #main -->

@endsection
