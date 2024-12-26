<?= $this->extend('layouts/template-login') ?>
<?= $this->section('content') ?>

<!-- Recover -->
<div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
        <h4 class="text-center mb-2"><?= lang('app.login recover1') ?></h4>
        <p class="mb-4"><?= lang('app.login recover2') ?></p>

        <form class="mb-3" action="/login/reset" method="POST">
            <?php if (session()->getFlashdata('message')) :
                echo json('alert failed-1') . session()->getFlashdata('message') . json('alert success-2');
            endif ?>
            <?php if (session()->getFlashdata('success message')) :
                echo json('alert success-1') . session()->getFlashdata('success message') . json('alert success-2');
            endif ?>
            <div class="form-floating form-floating-outline mb-4">
                <input type="text" class="form-control" id="username" name="username" placeholder="<?= lang('app.username') ?>" />
                <label for="username"><?= lang('app.username') ?></label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
                <input type="text" class="form-control" id="code" name="code" placeholder="<?= json('xCode') ?>" />
                <label for="code"><?= lang('app.code') ?></label>
            </div>

            <button class="<?= json('btn submit') ?> d-flex w-100"><?= lang('app.btn recover') ?></button>
        </form>

        <div class="text-center">
            <a href="/login" class="d-flex align-items-center justify-content-center"><i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px"></i><?= lang('app.reenter') ?></a>
        </div>
        <div class="divider divider-primary my-4">
            <div class="divider-text"><?= json('xVersion') ?></div>
        </div>

    </div>
</div>
<!-- End Recover -->

<?= $this->endSection() ?>