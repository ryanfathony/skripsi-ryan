<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg">
            <?= form_open_multipart('ForwardAdmin/kecerdasanAdd'); ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Kode Kecerdasan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kode_kecerdasan" name="kode_kecerdasan" placeholder="Kode Kecerdasan" value="<?= set_value('kode_kecerdasan'); ?>">
                            <?= form_error('kode_kecerdasan', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Nama Kecerdasan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_kecerdasan" name="nama_kecerdasan" placeholder="Nama Kecerdasan" value="<?= set_value('nama_kecerdasan'); ?>">
                            <?= form_error('nama_kecerdasan', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Kriteria Kecerdasan</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="editor1" name="kriteria" placeholder="Kriteria Kecerdasan" cols="30" rows="10"></textarea>
                            <?= form_error('kriteria', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Deskripsi Kecerdasan</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="editor2" name="deskripsi" placeholder="Deskripsi Kecerdasan" cols="30" rows="10"></textarea>
                            <?= form_error('deskripsi', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Informasi Kecerdasan</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="editor3" name="informasi" placeholder="Informasi Kecerdasan" cols="30" rows="10"></textarea>
                            <?= form_error('informasi', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Stimulasi</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="editor4" name="stimulasi" placeholder="Stimulasi" cols="30" rows="10"></textarea>
                            <?= form_error('stimulasi', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Jurusan</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="editor5" name="jurusan" placeholder="Jurusan" cols="30" rows="10"></textarea>
                            <?= form_error('jurusan', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div> -->
                    <div class="form-group float-right justify-content-end">
                        <div class="col">
                            <a href="<?= base_url('ForwardAdmin/kecerdasan'); ?>" class="btn btn-warning">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
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