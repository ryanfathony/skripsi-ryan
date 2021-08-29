<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <a href="<?= base_url('excel/formatKnowledge.xlsx'); ?>" class="btn btn-success">Download Format Criteria</a>
                        </div>
                    </div>
                    <form method="post" action="<?php echo base_url("ForwardAdmin/knowledgeForm"); ?>" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file" name="file">
                                    <label class="custom-file-label" for="file">Choose file</label>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-success" name="preview" value="Preview">
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
                        if (isset($upload_error)) { // Jika proses upload gagal
                            echo "<div style='color: red;'>" . $upload_error . "</div>"; // Muncul pesan error upload
                        } else {

                            // Buat sebuah tag form untuk proses import data ke database
                            echo "<form method='post' action='" . base_url("ForwardAdmin/knowledgeImport") . "'>";

                            echo
                                "<div class='table-responsive'>
                                <table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                                    <thead>    
                                        <tr>
                                            <th>Code Criteria</th>
                                            <th>Question</th>
                                            <th>Answer Yes</th>
                                            <th>Answer No</th>
                                            <th>Yes</th>
                                            <th>No</th>
                                        </tr>
                                    </thead>
                                    <tfoot>    
                                        <tr>
                                            <th>Code Criteria</th>
                                            <th>Question</th>
                                            <th>Answer Yes</th>
                                            <th>Answer No</th>
                                            <th>Yes</th>
                                            <th>No</th>
                                        </tr>
                                    </tfoot>";

                            $numrow = 1;
                            $kosong = 0;

                            // Lakukan perulangan dari data yang ada di excel
                            // $sheet adalah variabel yang dikirim dari controller
                            foreach ($sheet as $row) {
                                // Ambil data pada excel sesuai Kolom
                                $kriteria = $row['A']; // Ambil data NIS
                                $pertanyaan = $row['B']; // Ambil data NIS
                                $is_yes = $row['C']; // Ambil data NIS
                                $is_no = $row['D']; // Ambil data NIS
                                $to_yes = $row['E']; // Ambil data NIS
                                $to_no = $row['F']; // Ambil data NIS

                                // Cek jika semua data tidak diisi
                                if ($kriteria == "" && $pertanyaan == "" && $is_yes == "" && $is_no == "" && $to_yes == "" && $to_no == "")
                                    continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                                // Cek $numrow apakah lebih dari 1
                                // Artinya karena baris pertama adalah nama-nama kolom
                                // Jadi dilewat saja, tidak usah diimport
                                if ($numrow > 1) {
                                    // Validasi apakah semua data telah diisi
                                    $kriteria_td = (!empty($kriteria)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                    $pertanyaan_td = (!empty($pertanyaan)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                    $is_yes_td = (!empty($is_yes)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                    $is_no_td = (!empty($is_no)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                    $to_yes_td = (!empty($to_yes)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                    $to_no_td = (!empty($to_no)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah

                                    // Jika salah satu data ada yang kosong
                                    if ($kriteria == "" or $pertanyaan == "" or $is_yes == "" or $is_no == "" or $to_yes == "" or $to_no == "") {
                                        $kosong++; // Tambah 1 variabel $kosong
                                    }

                                    echo "<tr>";
                                    echo "<td" . $kriteria_td . ">" . $kriteria . "</td>";
                                    echo "<td" . $pertanyaan_td . ">" . $pertanyaan . "</td>";
                                    echo "<td" . $is_yes_td . ">" . $is_yes . "</td>";
                                    echo "<td" . $is_no_td . ">" . $is_no . "</td>";
                                    echo "<td" . $to_yes_td . ">" . $to_yes . "</td>";
                                    echo "<td" . $to_no_td . ">" . $to_no . "</td>";
                                    echo "</tr>";
                                }

                                $numrow++; // Tambah 1 setiap kali looping
                            }

                            echo "</table>";

                            // Cek apakah variabel kosong lebih dari 0
                            // Jika lebih dari 0, berarti ada data yang masih kosong
                            if ($kosong > 0) {
                    ?>
                                <script>
                                    $(document).ready(function() {
                                        // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                                        $("#jumlah_kosong").html('<?php echo $kosong; ?>');

                                        $("#kosong").show(); // Munculkan alert validasi kosong
                                    });
                                </script>
                    <?php
                            } else { // Jika semua data sudah diisi
                                echo "<hr>";

                                // Buat sebuah tombol untuk mengimport data ke database
                                echo "<div class='form-group float-right'>
                                    <div class='col'>
                                        <button type='submit' class='btn btn-primary'>Import</button>
                                        <a href='" . base_url("ForwardAdmin/knowledge") . "' class='btn btn-warning'>Cancel</a>
                                    </div>
                                </div>";
                            }

                            echo "</form>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->