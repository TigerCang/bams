<?= $this->extend('layout/templatelogin') ?>
<?= $this->section('contentlogin') ?>

<section class="login-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-8"><img src="libraries\assets\images\auth\login-page1.png" alt="logo.png"></div>

            <div class="col-sm-4 mt-5">
                <form class="md-float-material form-material" action="/login/reset" method="POST">
                    <div class="text-center"><img src="libraries\assets\images\logo.png" alt="logo.png"></div>
                    <div class="auth-box card">
                        <div class="card-block">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <h3 class="text-center"><?= lang('app.log_pulih') ?></h3>
                                </div>
                            </div>

                            <?php if (session()->getFlashdata('pesan2')) :
                                $pesan = session()->getFlashdata('pesan2');
                                $alertClass = ($pesan == lang("app.mintaresetsukses")) ? 'success' : 'danger';
                                echo "<div class='alert alert-$alertClass background-$alertClass'>";
                                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                                echo "<i class='icofont icofont-close-line-circled text-white'></i></button>";
                                echo session()->getFlashdata('pesan2') . "</div>";
                            endif ?>

                            <div class="form-group form-primary">
                                <input type="text" name="username" class="form-control" placeholder="<?= lang('app.username') ?>" autocomplete="off" autofocus>
                                <span class="form-bar"></span>
                            </div>
                            <div class="form-group form-primary">
                                <input type="text" name="kode" class="form-control" placeholder="<?= lang('app.kodepeg') ?>" autocomplete="off">
                                <span class="form-bar"></span>
                            </div>
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <?= "<button type='submit' class='btn " . lang('app.btnRecover') . " btn-block waves-effect waves-light text-center m-b-20'>" . lang('app.btn_Recover') . "</button>" ?>
                                </div>
                            </div>
                            <div class="row m-t-25 text-left">
                                <div class="col-12">
                                    <div class="checkbox-fade fade-in-primary d-inline">
                                    </div>
                                    <div class="forgot-phone text-right f-right"><?= "<a href='/login' class='text-right f-w-600'>" . lang('app.log_kembali') . "</a>" ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>