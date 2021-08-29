<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> <!-- Menerima $data['title'] -->

    <div class="row">
        <div class="col-lg-7">
            <?= $this->session->flashdata('message') ?></div>
    </div>

    <div class="card mb-3 col-lg-7">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img"> <!-- Menerima $data['user'] berupa image -->
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['name']; ?></h5> <!-- Menerima $data['user'] berupa name -->
                    <p class="card-text"><?= $user['email']; ?></p> <!-- Menerima $data['user'] berupa email -->
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->