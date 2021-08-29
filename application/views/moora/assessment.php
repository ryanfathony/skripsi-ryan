<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg">
            <?= form_error('value[]', '<div class="alert alert-danger" role="alert">',  '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('MooraUser/assessment'); ?>" method="post">
                        <table class="table table-bordered">
                            <?php foreach ($alternative->result() as $key => $value) : ?>
                                <tr class="thead-dark">
                                    <th colspan="2"><?php echo $value->alternative ?> </th>
                                </tr>
                                <?php foreach ($criteria->result() as $k => $v) : ?>
                                    <tr>
                                        <td>
                                            <?php echo $v->criteria ?>
                                            <input type="hidden" name="alternative[]" value="<?php echo $value->id ?>">
                                            <input type="hidden" name="criteria[]" value="<?php echo $v->id ?>">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="value[]" value="<?= set_value('value[]'); ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </table>
                        <div class="form-group float-right justify-content-end">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Submit</button>
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