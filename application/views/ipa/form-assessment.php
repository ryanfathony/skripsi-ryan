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
                            <a href="<?= base_url('excel/formatAssessment.xlsx'); ?>" class="btn btn-success">Download Format Assessment</a>
                        </div>
                    </div>
                    <form method="post" action="<?php echo base_url("IPAManagement/assessmentForm"); ?>" enctype="multipart/form-data">
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
                            echo "<form method='post' action='" . base_url("IPAManagement/assessmentImport") . "'>";

                            echo
                                "<div class='table-responsive'>
                                <table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                                    <thead>    
                                        <tr>
                                            <th>NIS</th>    
                                            <th>Code Criteria</th>
                                            <th>Score</th>
                                        </tr>
                                    </thead>
                                    <tfoot>    
                                        <tr>
                                            <th>NIS</th>    
                                            <th>Code Criteria</th>
                                            <th>Score</th>
                                        </tr>
                                    </tfoot>";

                            $numrow = 1;
                            $kosong = 0;

                            // Lakukan perulangan dari data yang ada di excel
                            // $sheet adalah variabel yang dikirim dari controller
                            foreach ($sheet as $row) {
                                // Ambil data pada excel sesuai Kolom
                                $nis = $row['E']; // Ambil data NIS
                                $code_criteria = $row['F']; // Ambil data NIS
                                $value = $row['G']; // Ambil data NIS

                                // Cek jika semua data tidak diisi
                                if ($nis == "" && $code_criteria == "" && $value == "")
                                    continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                                // Cek $numrow apakah lebih dari 1
                                // Artinya karena baris pertama adalah nama-nama kolom
                                // Jadi dilewat saja, tidak usah diimport
                                if ($numrow > 1) {
                                    // Validasi apakah semua data telah diisi
                                    $nis_td = (!empty($nis)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                    $code_criteria_td = (!empty($code_criteria)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                                    $value_td = (!empty($value)) ? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah

                                    // Jika salah satu data ada yang kosong
                                    if ($nis == "" or $code_criteria == "" or $value == "") {
                                        $kosong++; // Tambah 1 variabel $kosong
                                    }

                                    echo "<tr>";
                                    echo "<td" . $nis_td . ">" . $nis . "</td>";
                                    echo "<td" . $code_criteria_td . ">" . $code_criteria . "</td>";
                                    echo "<td" . $value_td . ">" . $value . "</td>";
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
                                        <a href='" . base_url("IPAManagement/assessment") . "' class='btn btn-warning'>Cancel</a>
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