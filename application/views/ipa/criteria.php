<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg">

            <?= form_error('criteria', '<div class="alert alert-danger" role="alert">',  '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newCriteriaModal">Add New Criteria</a>
            <a href="<?= base_url('IPAManagement/criteriaForm'); ?>" class="btn btn-success mb-3">Import Data Criteria</a>
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
                                    <th scope="col">Code Criteria</th>
                                    <th scope="col">Criteria</th>
                                    <th scope="col">Weight</th>
                                    <th scope="col">Attribute</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Code Criteria</th>
                                    <th scope="col">Criteria</th>
                                    <th scope="col">Weight</th>
                                    <th scope="col">Attribute</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($model as $m) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $m['code_criteria']; ?></td>
                                        <td><?= $m['criteria']; ?></td>
                                        <td><?= $m['weight']; ?></td>
                                        <td><?= $m['attribute']; ?></td>
                                        <td>
                                            <a href="<?= base_url('IPAManagement/criteriaEdit/') . $m['id']; ?>" class="badge badge-success">edit</a>
                                            <a href="<?= base_url('IPAManagement/criteriaDelete/') . $m['id']; ?>" class="badge badge-danger" onclick="return confirm ('Delete');">delete</a>
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

<!-- Modal -->
<div class="modal fade" id="newCriteriaModal" tabindex="-1" role="dialog" aria-labelledby="newCriteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCriteriaModalLabel">Add New Criteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('IPAManagement/criteria'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="code_criteria" name="code_criteria" placeholder="Code Criteria">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="criteria" name="criteria" placeholder="Criteria Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight Criteria">
                    </div>
                    <div class="form-group">
                        <select name="attribute_id" id="attribute_id" class="form-control">
                            <option value="">Select Attribute</option>
                            <?php foreach ($attribute as $a) : ?>
                                <option value="<?= $a['id']; ?>"><?= $a['attribute']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>