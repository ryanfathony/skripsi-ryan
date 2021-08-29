<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login Page</h1>
                                </div>
                                <?= $this->session->flashdata('message') ?>
                                <!--flashdata yang dikirim dari Auth.php -->

                                <form class="user" method="post" action="<?= base_url('auth'); ?>">
                                    <!-- Action mengarahkan ke Controller Auth.php dan memanggil Method default Index (Method Login) -->
                                    <!-- Atribute value="<= set_value('name'); >" digunakan untuk mempopulasi ulang form-->
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email') ?>">
                                        <!--type email dirubah menjadi text agar validasi dilakukan oleh CodeIgniter bukan html-->
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                        <!--Pemberitahuan ketika terdapat Error pada Colum Email -->
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                        <!--Pemberitahuan ketika terdapat Error pada Colum Password -->
                                    </div>
                                    <!-- <div class="form-group"> fungsi Remember Me
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div> -->
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                    <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> -->
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/registration'); ?>">Create an Account!</a>
                                    <!--Fungsi untuk Link menuju View registration.php yang terdapat pada folder auth-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>