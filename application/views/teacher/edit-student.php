<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg">
            <form action="" method="post">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="id" class="col-sm-2 col-form-label">ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id" name="id" value="<?= $datauser['id']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" value="<?= $datauser['email']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?= $datauser['name']; ?>">
                                <?= form_error('title', '<small class="text-danger">', '</small>'); ?>
                                <!--Pemberitahuan ketika terdapat Error pada Colum Email -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="is_active" class="col-sm-2 col-form-label">Activated</label>
                            <div class="col-sm-10">
                                <select name="is_active" id="is_active" class="form-control">
                                    <?php foreach ($active as $a) : ?>
                                        <?php if ($a['id'] == $datauser['is_active']) : ?>
                                            <option value="<?= $a['id']; ?>" selected><?= $a['active']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $a['id']; ?>"><?= $a['active']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('is_active', '<small class="text-danger">', '</small>'); ?>
                                <!--Pemberitahuan ketika terdapat Error pada Colum Email -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2"> Picture </div>
                            <div class="col-sm-10">
                                <div class="div row">
                                    <div class="col-sm-3">
                                        <img src="<?= base_url('assets/img/profile/') . $datauser['image']; ?>" class="img-thumbnail">
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group float-right justify-content-end">
                            <div class="col">
                                <a href="<?= base_url('Teacher/student'); ?>" class="btn btn-warning">Cancel</a>
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