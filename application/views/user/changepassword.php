<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg-10">
            <?= $this->session->flashdata('message') ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('user/changepassword'); ?>" method="post">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="col-sm">
                                <input type="password" class="form-control" id="current_password" name="current_password">
                                <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
                                <!--Pemberitahuan ketika terdapat Error pada Colum Current Email -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_password1">New Password</label>
                            <div class="col-sm">
                                <input type="password" class="form-control" id="new_password1" name="new_password1">
                                <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                <!--Pemberitahuan ketika terdapat Error pada Colum New Password -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_password2">Repeat Password</label>
                            <div class="col-sm">
                                <input type="password" class="form-control" id="new_password2" name="new_password2">
                            </div>
                        </div>
                        <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
                        <!--Pemberitahuan ketika terdapat Error pada Colum Email -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right">Change Password</button>
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