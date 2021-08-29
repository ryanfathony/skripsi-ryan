<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg-9">
            <form action="" method="post">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="id" class="col-sm-2 col-form-label">ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id" name="id" value="<?= $kriteria['id']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode_kriteria" class="col-sm col-form-label">Code Criteria</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kode_kriteria" name="kode_kriteria" value="<?= $kriteria['kode_kriteria']; ?>">
                                <?= form_error('kode_kriteria', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_kriteria" class="col-sm col-form-label">Criteria</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" id="nama_kriteria" name="nama_kriteria" cols="30" rows="10"><?= $kriteria['nama_kriteria']; ?></textarea>
                                <?= form_error('nama_kriteria', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group float-right justify-content-end">
                            <div class="col">
                                <a href="<?= base_url('ForwardAdmin/kriteria'); ?>" class="btn btn-warning">Cancel</a>
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