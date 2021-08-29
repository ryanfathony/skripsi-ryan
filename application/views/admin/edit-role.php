<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group row">
                            <label for="id" class="col-sm-2 col-form-label">ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id" name="id" value="<?= $role['id']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="role" name="role" value="<?= $role['role']; ?>">
                                <?= form_error('role', '<small class="text-danger">', '</small>'); ?>
                                <!--Pemberitahuan ketika terdapat Error pada Colum Email -->
                            </div>
                        </div>
                        <div class="form-group float-right justify-content-end">
                            <div class="col">
                                <a href="<?= base_url('Admin/role'); ?>" class="btn btn-warning">Cancel</a>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->