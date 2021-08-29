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

            <a href="<?= base_url('ForwardAdmin/kecerdasanAdd'); ?>" class="btn btn-primary mb-3">Add New Intelligence</a>
            <a href="<?= base_url('ForwardAdmin/kecerdasanForm'); ?>" class="btn btn-success mb-3">Import Data Intelligence</a>
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
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Criteria</th>
                                    <th scope="col">Description</th>
                                    <!-- <th scope="col">Information</th>
                                    <th scope="col">Stimulasi</th>
                                    <th scope="col">Jurusan</th> -->
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Criteria</th>
                                    <th scope="col">Description</th>
                                    <!-- <th scope="col">Information</th>
                                    <th scope="col">Stimulasi</th>
                                    <th scope="col">Jurusan</th> -->
                                    <th scope="col">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($kecerdasan as $k) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $k['kode_kecerdasan']; ?></td>
                                        <td><?= $k['nama_kecerdasan']; ?></td>
                                        <td><?= $k['kriteria']; ?></td>
                                        <td><?= $k['deskripsi']; ?></td>
                                        <!-- <td><?= $k['informasi']; ?></td>
                                        <td><?= $k['stimulasi']; ?></td>
                                        <td><?= $k['jurusan']; ?></td> -->
                                        <td>
                                            <a href="<?= base_url('ForwardAdmin/kecerdasanEdit/') . $k['id']; ?>" class="badge badge-success">edit</a>
                                            <a href="<?= base_url('ForwardAdmin/kecerdasanDelete/') . $k['id']; ?>" class="badge badge-danger" onclick="return confirm ('Delete');">delete</a>
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