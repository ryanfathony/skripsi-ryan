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
                                <input type="text" class="form-control" id="id" name="id" value="<?= $submenu['id']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="menu" class="col-sm-2 col-form-label">Menu</label>
                            <div class="col-sm-10">
                                <select name="menu_id" id="menu_id" class="form-control">
                                    <?php foreach ($menu as $m) : ?>
                                        <?php if ($m['id'] == $submenu['menu_id']) : ?>
                                            <option value="<?= $m['id']; ?>" selected><?= $m['menu']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('menu', '<small class="text-danger">', '</small>'); ?>
                                <!--Pemberitahuan ketika terdapat Error pada Colum Email -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Sub Menu</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" value="<?= $submenu['title']; ?>">
                                <?= form_error('title', '<small class="text-danger">', '</small>'); ?>
                                <!--Pemberitahuan ketika terdapat Error pada Colum Email -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="url" class="col-sm-2 col-form-label">Url</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="url" name="url" value="<?= $submenu['url']; ?>">
                                <?= form_error('url', '<small class="text-danger">', '</small>'); ?>
                                <!--Pemberitahuan ketika terdapat Error pada Colum Email -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="icon" class="col-sm-2 col-form-label">Icon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="icon" name="icon" value="<?= $submenu['icon']; ?>">
                                <?= form_error('icon', '<small class="text-danger">', '</small>'); ?>
                                <!--Pemberitahuan ketika terdapat Error pada Colum Email -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="is_active" class="col-sm-2 col-form-label">Activated</label>
                            <div class="col-sm-10">
                                <select name="is_active" id="is_active" class="form-control">
                                    <?php foreach ($active as $a) : ?>
                                        <?php if ($a['id'] == $submenu['is_active']) : ?>
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
                        <div class="form-group float-right justify-content-end">
                            <div class="col">
                                <a href="<?= base_url('Menu/submenu'); ?>" class="btn btn-warning">Cancel</a>
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