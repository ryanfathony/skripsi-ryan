<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg-10">
            <form action="" method="post">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="id" class="col-sm-2 col-form-label">ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id" name="id" value="<?= $alternative['id']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="code_alternative" class="col-sm-2 col-form-label">Code Alternative</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code_alternative" name="code_alternative" value="<?= $alternative['code_alternative']; ?>">
                                <?= form_error('code_alternative', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alternative" class="col-sm-2 col-form-label">Alternative</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alternative" name="alternative" value="<?= $alternative['alternative']; ?>">
                                <?= form_error('alternative', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group float-right justify-content-end">
                            <div class="col">
                                <a href="<?= base_url('DSSManagement/alternativeIndividual'); ?>" class="btn btn-warning">Cancel</a>
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