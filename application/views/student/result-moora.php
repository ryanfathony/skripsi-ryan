<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg">
            <?= $this->session->flashdata('message'); ?>

            <a href="<?php echo base_url('Student/getResultMoora') ?>" class="btn btn-primary mb-3">Refresh</a>
            <a href="<?php echo base_url('IPAManagement/resultMoora') ?>" class="btn btn-success mb-3">Rank Moora IPA</a>
            <a href="<?php echo base_url('IPSManagement/resultMoora') ?>" class="btn btn-warning mb-3">Rank Moora IPS</a>
            <a href="<?php echo base_url('BahasaManagement/resultMoora') ?>" class="btn btn-info mb-3">Rank Moora Bahasa</a>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Alternative</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Rank</th>
                                    <th>Alternative</th>
                                    <th>Score</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $i = 1;
                                foreach ($data->result() as $key => $value) : ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td><?php echo $value->alternative ?></td>
                                        <td><?php echo $value->score ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->