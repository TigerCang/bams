<?= $this->extend('layouts/template-login') ?>
<?= $this->section('content') ?>

<!-- Sign In -->
<div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
        <h4 class="text-center mb-2"><?= lang('app.login start1') ?></h4>
        <p class="mb-4"><?= lang('app.login start2') ?></p>

        <form class="mb-3" action="/login/auth" method="POST">
            <?php if (session()->getFlashdata('message')) :
                echo json('alert failed-1') . session()->getFlashdata('message') . json('alert success-2');
            endif ?>

            <div class="form-floating form-floating-outline mb-4">
                <input type="text" class="form-control" id="username" name="username" placeholder="<?= lang('app.username') ?>" autofocus />
                <label for="username"><?= lang('app.username') ?></label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
                <input type="password" class="form-control ePassword" id="password" name="password" placeholder="<?= json('password') ?>" />
                <img src="<?= base_url('assets') ?>/image/eye-hide.png" class="toggle-password">
                <label for="password"><?= lang('app.password') ?></label>
            </div>
            <div class="d-flex justify-content-between mb-4 ">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" />
                    <label class="form-check-label" for="remember"><?= lang('app.remember me') ?> </label>
                </div>
                <a href="/forget" class="float-end mb-1"><span><?= lang('app.forget password') ?></span></a>
            </div>

            <button class="<?= json('btn submit') ?> d-flex w-100"><?= lang('app.btn login') ?></button>
        </form>

        <p class="text-center mt-2">
            <span><?= lang('app.ask user') ?></span>
            <a href="/signup"><span><?= lang('app.create user') ?></span></a>
        </p>
        <div class="divider divider-primary my-4">
            <div class="divider-text"><?= json('xVersion') ?></div>
        </div>
    </div>
</div>
<!-- End Sign In -->

<?= $this->endSection() ?>