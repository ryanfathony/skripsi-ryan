<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg">

            <?= form_error('assessment', '<div class="alert alert-danger" role="alert">',  '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <!-- <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newAlternativeModal">Add New Alternative</a> -->
            <a href="<?= base_url('DSSManagement/assessmentForm'); ?>" class="btn btn-success mb-3">Import Data Score</a>
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
                                    <th scope="col">Criteria</th>
                                    <th scope="col">Score</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Criteria</th>
                                    <th scope="col">Score</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($assessment as $a) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $a['name']; ?></td>
                                        <td><?= $a['criteria']; ?></td>
                                        <td><?= $a['value']; ?></td>
                                        <td>
                                            <a href="<?= base_url('DSSManagement/assessmentEdit/') . $a['id']; ?>" class="badge badge-success">edit</a>
                                            <a href="<?= base_url('DSSManagement/assessmentDelete/') . $a['id']; ?>" class="badge badge-danger" onclick="return confirm ('Delete');">delete</a>
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