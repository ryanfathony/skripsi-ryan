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
                                <input type="text" class="form-control" id="id" name="id" value="<?= $assessment['id']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nis" class="col-sm-2 col-form-label">NIS</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nis" name="nis" value="<?= $assessment['nis']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="code_criteria" class="col-sm-2 col-form-label">Code Criteria</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code_criteria" name="code_criteria" value="<?= $assessment['code_criteria']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="value" class="col-sm-2 col-form-label">Value</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="value" name="value" value="<?= $assessment['value']; ?>">
                                <?= form_error('value', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group float-right justify-content-end">
                            <div class="col">
                                <a href="<?= base_url('IPSManagement/assessment'); ?>" class="btn btn-warning">Cancel</a>
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