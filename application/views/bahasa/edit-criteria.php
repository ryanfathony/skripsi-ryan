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
                                <input type="text" class="form-control" id="id" name="id" value="<?= $criteria['id']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="code_criteria" class="col-sm-2 col-form-label">Code Criteria</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code_criteria" name="code_criteria" value="<?= $criteria['code_criteria']; ?>">
                                <?= form_error('code_criteria', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="criteria" class="col-sm-2 col-form-label">Criteria</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="criteria" name="criteria" value="<?= $criteria['criteria']; ?>">
                                <?= form_error('criteria', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="weight" class="col-sm-2 col-form-label">Weight</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="weight" name="weight" value="<?= $criteria['weight']; ?>">
                                <?= form_error('weight', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="menu" class="col-sm-2 col-form-label">Attribute</label>
                            <div class="col-sm-10">
                                <select name="attribute_id" id="attribute_id" class="form-control">
                                    <?php foreach ($attribute as $a) : ?>
                                        <?php if ($a['id'] == $criteria['attribute_id']) : ?>
                                            <option value="<?= $a['id']; ?>" selected><?= $a['attribute']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $a['id']; ?>"><?= $a['attribute']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('menu', '<small class="text-danger">', '</small>'); ?>
                                <!--Pemberitahuan ketika terdapat Error pada Colum Email -->
                            </div>
                        </div>
                        <div class="form-group float-right justify-content-end">
                            <div class="col">
                                <a href="<?= base_url('BahasaManagement/criteria'); ?>" class="btn btn-warning">Cancel</a>
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