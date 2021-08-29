<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <div class="container-fluid">
                <span class="alert alert-blok alert-success">
                    Jawab pertanyaan berikut ini untuk melakukan diagnosa kecerdasan berdasarkan kriteria
                </span>
                <br><br>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <p>
                            <strong>
                                <?php
                                if ($kecerdasan != "") { //Jika variable kecerdasan menampung data kecerdasan (tidak kosong)
                                    if (empty($kecerdasan->nama_kecerdasan)) {
                                        echo $kecerdasan;
                                    } else {
                                        echo "<div class='row'>";
                                        echo '<div class="col">';
                                        echo "Anda terindikasi kecerdasan <div class='alert alert-success'>" . $kecerdasan->nama_kecerdasan . "</div><br>";
                                        echo "Kriteria : <br>";
                                        echo $kecerdasan->kriteria;
                                        echo "<br> <br>";
                                        echo "Deskripsi : <br>";
                                        echo $kecerdasan->deskripsi;
                                        // echo "Informasi : <br>";
                                        // echo $kecerdasan->informasi;
                                        // echo "Stimulasi : <br>";
                                        // echo $kecerdasan->stimulasi;
                                        // echo "Jurusan : <br>";
                                        // echo $kecerdasan->jurusan;
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else { //Jika variable kecerdasan tidak menampung data kecerdasan (kosong)
                                    echo $diagnosa->pertanyaan;
                                }
                                ?>
                            </strong>
                        </p>

                        <div class="row">
                            <?php if ($kecerdasan == "") { ?>
                                <form action="<?= base_url('ForwardUser/proses/' . $diagnosa->kriteria) ?>" method="post">
                                    <div class="card-body">
                                        <div class="form-group col">
                                            <strong><input type="radio" name="jawab" value="1"> <?= $diagnosa->is_yes ?></strong><br>
                                            <strong><input type="radio" name="jawab" value="0"> <?= $diagnosa->is_no ?></strong><br>
                                            <br><br>
                                            <div class="pull-left">
                                                <button type="submit" class="btn btn-primary">Proses</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php } else {  ?>
                                <div class="pull-right">
                                    <a href="<?= base_url('ForwardUser/diagnosa') ?>" class="btn btn-warning"><i class="fa fa-refresh"></i> Diagnosa Ulang</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->