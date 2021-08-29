<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="<?= base_url('Teacher/studentAdd'); ?>" class="btn btn-primary mb-3">Add New Student</a>
            <a href="<?= base_url('Teacher/studentForm'); ?>" class="btn btn-success mb-3">Import Data Student</a>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Image</th>
                                    <!-- <th scope="col">Role</th> -->
                                    <th scope="col">Active</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Image</th>
                                    <!-- <th scope="col">Role</th> -->
                                    <th scope="col">Active</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($model as $m) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $m['name']; ?></td>
                                        <td><?= $m['email']; ?></td>
                                        <td><img class="img-responsive rounded-circle" height="20%" src="<?= base_url('assets/img/profile/') . $m['image']; ?>"></td>
                                        <!-- <td><?= $m['role']; ?></td> -->
                                        <td><?= $m['active']; ?></td>
                                        <td>
                                            <a href="<?= base_url('Teacher/studentEdit/') . $m['id']; ?>" class="badge badge-success">edit</a>
                                            <a href="<?= base_url('Teacher/studentDelete/') . $m['id']; ?>" class="badge badge-danger" onclick="return confirm ('Delete');">delete</a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->