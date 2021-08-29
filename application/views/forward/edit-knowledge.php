<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg">
            <form action="" method="post">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="id" class="col-sm-2 col-form-label">ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id" name="id" value="<?= $knowledge['id']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode_kriteria" class="col-sm-2 col-form-label">Kriteria</label>
                            <div class="col-sm-10">
                                <select name="kode_kriteria" class="form-control">

                                    <?php foreach ($kriteria as $k) : ?>
                                        <?php if ($k['kode_kriteria'] == $knowledge['kriteria']) : ?>
                                            <option value="<?= $k['kode_kriteria']; ?>" selected><?= $k['kode_kriteria']; ?> - <?= $k['nama_kriteria']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $k['kode_kriteria']; ?>"><?= $k['kode_kriteria']; ?> - <?= $k['nama_kriteria']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Pertanyaan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="pertanyaan" name="pertanyaan" value="<?= $knowledge['pertanyaan']; ?>">
                                <?= form_error('title', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Jawaban Ya</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="is_yes" name="is_yes" value="<?= $knowledge['is_yes']; ?>">
                                <?= form_error('title', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Jawaban Tidak</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="is_no" name="is_no" value="<?= $knowledge['is_no']; ?>">
                                <?= form_error('title', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Jika Ya</label>
                            <div class="col-sm-10">
                                <select name="jenis_yes" id="jenis_yes" class="form-control">
                                    <option value="">Select Value</option>
                                    <option value="kriteria_yes">Kriteria</option>
                                    <option value="kecerdasan_yes">Kecerdasan</option>
                                </select>
                                <?= form_error('jenis_yes', '<small class="text-danger">', '</small>'); ?>
                                <br>
                                <div id="kriteria_yes">
                                    <select name="to_yes_kriteria" id="kriteria" class="form-control">
                                        <option value="">Select Criteria</option>
                                        <?php foreach ($kriteria as $k) : ?>
                                            <option value="<?= $k['kode_kriteria']; ?>"><?= $k['kode_kriteria']; ?> - <?= $k['nama_kriteria']; ?></option>
                                        <?php endforeach; ?>
                                    </select><br>
                                </div>
                                <div id="kecerdasan_yes">
                                    <select name="to_yes_kecerdasan" id="kecerdasan" class="form-control">
                                        <option value="">Select Kecerdasan</option>
                                        <?php foreach ($kecerdasan as $k) : ?>
                                            <option value="<?= $k['kode_kecerdasan']; ?>"><?= $k['kode_kecerdasan']; ?> - <?= $k['nama_kecerdasan']; ?></option>
                                        <?php endforeach; ?>
                                    </select><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Jika Tidak</label>
                            <div class="col-sm-10">
                                <select name="jenis_no" id="jenis_no" class="form-control">
                                    <option value="">Select Value</option>
                                    <option value="kriteria_no">Kriteria</option>
                                    <option value="kecerdasan_no">Kecerdasan</option>
                                </select>
                                <?= form_error('jenis_no', '<small class="text-danger">', '</small>'); ?>
                                <br>
                                <div id="kriteria_no">
                                    <select name="to_no_kriteria" id="kriteria" class="form-control">
                                        <option value="">Select Criteria</option>
                                        <?php foreach ($kriteria as $k) : ?>
                                            <option value="<?= $k['kode_kriteria']; ?>"><?= $k['kode_kriteria']; ?> - <?= $k['nama_kriteria']; ?></option>
                                        <?php endforeach; ?>
                                    </select><br>
                                </div>
                                <div id="kecerdasan_no">
                                    <select name="to_no_kecerdasan" id="kecerdasan" class="form-control">
                                        <option value="">Select Kecerdasan</option>
                                        <?php foreach ($kecerdasan as $k) : ?>
                                            <option value="<?= $k['kode_kecerdasan']; ?>"><?= $k['kode_kecerdasan']; ?> - <?= $k['nama_kecerdasan']; ?></option>
                                        <?php endforeach; ?>
                                    </select><br>
                                </div>
                            </div>
                        </div>
                        <div class="form-group float-right justify-content-end">
                            <div class="col">
                                <a href="<?= base_url('ForwardAdmin/knowledge'); ?>" class="btn btn-warning">Cancel</a>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->