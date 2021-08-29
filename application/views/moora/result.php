<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg">
            <?= $this->session->flashdata('message'); ?>

            <a href="<?php echo base_url('MooraUser/get_result') ?>" class="btn btn-primary mb-3">Get result</a>
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
            <div class="card shadow mb-4">
                <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title6; ?></h6>
                </a>
                <div class="collapse show" id="collapseCardExample2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Alternative</th>
                                        <th>Criteria</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Alternative</th>
                                        <th>Criteria</th>
                                        <th>Score</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($assessment as $a) : ?>
                                        <tr>
                                            <td><?= $a['alternative']; ?></td>
                                            <td><?= $a['criteria']; ?></td>
                                            <td><?= $a['value']; ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title2; ?></h6>
                </a>
                <div class="collapse show" id="collapseCardExample1">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Criteria</th>
                                        <th>SQRT</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Criteria</th>
                                        <th>SQRT</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($sqrt as $s) : ?>
                                        <tr>
                                            <td><?= $s['criteria']; ?></td>
                                            <td><?= $s['sqrt']; ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <a href="#collapseCardExample6" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample6">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title3; ?></h6>
                </a>
                <div class="collapse show" id="collapseCardExample6">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Alternative</th>
                                        <th>Criteria</th>
                                        <th>Normalisasi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Alternative</th>
                                        <th>Criteria</th>
                                        <th>Normalisasi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($normalisasi as $n) : ?>
                                        <tr>
                                            <td><?= $n['alternative']; ?></td>
                                            <td><?= $n['criteria']; ?></td>
                                            <td><?= $n['normalisasi']; ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <a href="#collapseCardExample3" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title4; ?></h6>
                </a>
                <div class="collapse show" id="collapseCardExample3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Alternative</th>
                                        <th>Criteria</th>
                                        <th>Optimasi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Alternative</th>
                                        <th>Criteria</th>
                                        <th>Optimasi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($optimasi as $o) : ?>
                                        <tr>
                                            <td><?= $o['alternative']; ?></td>
                                            <td><?= $o['criteria']; ?></td>
                                            <td><?= $o['optimasi']; ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="card shadow mb-4">
                <a href="#collapseCardExample4" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample4">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title5; ?></h6>
                </a>
                <div class="collapse show" id="collapseCardExample4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Alternative</th>
                                        <th>Nilai Min</th>
                                        <th>Nilai Max</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Alternative</th>
                                        <th>Nilai Min</th>
                                        <th>Nilai Max</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($minmax as $m) : ?>
                                        <tr>
                                            <td><?= $m['alternative']; ?></td>
                                            <td><?= $m['min']; ?></td>
                                            <td><?= $m['max']; ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->